<?php
namespace Joc4enRatlla\Models;
use Joc4enRatlla\Exceptions\ColumnaLlenaException;
use Joc4enRatlla\Models\Board;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Services\Db;

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
        $this->board = new Board();
        $this->nextPlayer = 1;
        $this->winner = null;
    }
    //Realitza un moviment
    public function play($columna){
        // TODO: Realitza un moviment
        if (!$this->board->isValidMove($columna)){
            throw new ColumnaLlenaException($columna);
        }
        $this->board->setMovementOnBoard($columna, $this->nextPlayer);
        if ($this->board->checkWin($this->nextPlayer)){
            $this->winner = $this->players[$this->nextPlayer];
            $this->scores[$this->nextPlayer]++;
        } else {
            $this->nextPlayer = ($this->nextPlayer == 1) ? 2 : 1;
        }
        $this->save();
    }

        public function playAutomatic(){
            $opponent = $this->nextPlayer === 1 ? 2 : 1;
    
            for ($col = 1; $col <= Board::COLUMNS; $col++) {
                if ($this->board->isValidMove($col)) {
                    $tempBoard = clone($this->board);
                    $coord = $tempBoard->setMovementOnBoard($col, $this->nextPlayer);
    
                    if ($tempBoard->checkWin($this->nextPlayer)) {
                        $this->play($col);
                        return;
                    }
                }
            }
    
            for ($col = 1; $col <= Board::COLUMNS; $col++) {
                if ($this->board->isValidMove($col)) {
                    $tempBoard = clone($this->board);
                    $coord = $tempBoard->setMovementOnBoard($col, $opponent);
                    if ($tempBoard->checkWin($this->nextPlayer )) {
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
            $random = count($possibles)>1?rand(-1,1):0;
            $middle = (int) (count($possibles) / 2);
            if (count($possibles) > 1) {
                $middle = max(0, min(count($possibles) - 1, $middle + $random));
            }
            $inthemiddle = $possibles[$middle];
            $this->play($inthemiddle);
            return $inthemiddle;            
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

    /**
    * @return int
    */
    public function getNextPlayer(): int {
        return $this->nextPlayer;
    }

    public function saveGame() {
        $sql = "INSERT INTO partides (usuari_id, game) VALUES (:usuario_id, :game) ON DUPLICATE KEY UPDATE game = :game";
        $pdo = Db::connect();
        $sentence = $pdo->prepare($sql);
        $sentence->bindParam(':usuario_id', $_SESSION['usuarioId']);
        $sentence->bindParam(':game', $_SESSION['game']);
        $sentence->execute();

        $this->save();
    }

    public function restoreGame() {
        $sql = "SELECT game FROM partides WHERE usuari_id = :usuario_id";
        $pdo = Db::connect();
        $sentence = $pdo->prepare($sql);
        $sentence->bindParam(':usuario_id', $_SESSION['usuarioId']);
        $sentence->execute();
        $partida = $sentence->fetch();
        $_SESSION['game'] = $partida['game'];
        $this->restore();
    }
}
?>