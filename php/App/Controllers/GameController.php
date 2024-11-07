<?php

namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Exceptions\ColumnaLlenaException;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Services\Logs;


class GameController {
private Game $game;

// Request és l'array $_POST
public function __construct($request=null) {
    //Inicialització del joc
    if(isset($request['name'])) {
        $jugador1 = new Player($request['name'], $request['color']);
        $jugador2 = new Player('Maquinon', 'green', true);
        $this->game = new Game($jugador1, $jugador2);
        $this->game->save();
    } else {
        $this->game = Game::restore();
    }
    $this->play($request);
}

public function play(Array $request)  {
    if (isset($request['reset'])) {
        $this->game->reset();
        $this->game->save();
    }
    
    if(isset($request['saveGame'])) {
        $this->game->saveGame();
    }

    if(isset($request['restoreGame'])) {
        $this->game->restoreGame();
    }

    if (isset($request['exit'])) {
        unset($_SESSION['game']);
        session_destroy();
        header("location:/index.php");
        exit();
    }

    if (!$this->game->getBoard()->isFull() && !$this->game->getWinner()) {
        $jugadorActual = $this->game->getPlayers()[$this->game->getNextPlayer()];
        $log = new Logs();
        if (!$jugadorActual->getIsAutomatic() && isset($request['columna'])) {
            try {
                $this->game->play($request['columna']);
                $log->getLog()->info("El jugador " . $jugadorActual->getName() . " introduce una ficha en la columna: " . $request['columna']);
                $this->game->save();
                
                if (!$this->game->getWinner()) {
                    $columnaAutomatica = $this->game->playAutomatic();
                    $log->getLog()->info("La máquina introduce una ficha en la columna: " . $columnaAutomatica);
                    $this->game->save();
                }
            } catch(ColumnaLlenaException $err) {
                echo "<span class='incorrect'>" . $err->getMessage() . "</span>";
                $log->getLog()->error($err->getMessage());
            }
        } elseif ($jugadorActual->getIsAutomatic()) {
            $columnaAutomatica = $this->game->playAutomatic();
            $log->getLog()->info("La máquina introduce una ficha en la columna: " . $columnaAutomatica);
            $this->game->save();
        }
    }
    
    $board = $this->game->getBoard();
    $players = $this->game->getPlayers();
    $winner = $this->game->getWinner();
    $scores = $this->game->getScores();
    loadView('index', compact('board', 'players', 'winner', 'scores'));
}

    
}
?>