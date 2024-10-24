<?php
namespace Joc4enRatlla\Models;

use Joc4enRatlla\Models\Board;
use Joc4enRatlla\Models\Player;

class Game {
    private Board $board;
    private int $nextPlayer;
    private array $players;
    private ?Player $winner;
    private array $scores = [1 => 0, 2 => 0];

    public function __construct(Player $jugador1, Player $jugador2) {
        $this->board = new Board();
        $this->players = [1=> $jugador1, 2=> $jugador2];
        $this->nextPlayer = 1;
        $this->winner = null;
    }

    // getters i setters
    public function getBoard() { 
        return $this->board; 
    }

    public function getPlayers() { 
        return $this->players; 
    }

    public function getWinner() { 
        return $this->winner; 
    }    
    
    public function getScores() { 
        return $this->scores; 
    }

    //Reinicia el joc
    public function reset(): void {
        if(isset($_SESSION['partida'])) {
            unset($_SESSION['partida']);
        }
    }
    //Realitza un moviment
    public function play($columna) {
        if($columna < 0 || $columna >= 7) {
            echo '<span class="incorrect">Introduce una columna válida.</span>';
            return false;
        } else {
            $this->board->setMovementOnBoard($columna, $this->nextPlayer);
            $this->nextPlayer = $this->nextPlayer === 1 ? 2 : 1;
        }
        return true;
    }

    public function playAutomatic(){
        $opponent = $this->nextPlayer === 1 ? 2 : 1;

        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone($this->board);
                $coord = $tempBoard->setMovementOnBoard(+$col, $this->nextPlayer);
                if ($tempBoard->checkWin($coord)) {
                    $this->play($col);
                    return;
                }
            }
        }

        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone($this->board);
                $coord = $tempBoard->setMovementOnBoard($col, $opponent);
                if ($tempBoard->checkWin($coord)) {
                    $this->play($col);
                    return;
                }
            }
        }

        $possibles = array();
        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $possibles[] = $col;
            }
        }
        if (count($possibles)>2) {
            $random = rand(-1,1);
        }
        $middle = (int) (count($possibles) / 2)+$random;
        $inthemiddle = $possibles[$middle];
        $this->play($inthemiddle);
    }
    //Guarda l'estat del joc a les sessions
    public function save() {
        $_SESSION['game'] = serialize($this);
    }
    //Restaura l'estat del joc de les sessions
    public static function restore() {
        if(isset($_SESSION['game'])) {
            return unserialize($_SESSION['game'], [Game::class]);
        }
        return null;
    }
}
?>