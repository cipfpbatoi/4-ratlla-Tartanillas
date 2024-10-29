<?php

namespace Joc4enRatlla\Controllers;

use Exception;
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
        $jugador2 = new Player('Maquinon', 'orange', true);
        $this->game = new Game($jugador1, $jugador2);
        $this->game->save();
    } else {
        $this->game = Game::restore();
    }
    $this->play($request);
}

public function play(Array $request)  {
    // TODO : Gestió del joc. Ací es on s'ha de vore si hi ha guanyador, si el que juga es automàtic  o manual, s'ha polsat reiniciar...
        if (!$this->game->getBoard()->isFull() && !$this->game->getWinner()) {
            $jugadorActual = $this->game->getPlayers()[$this->game->getNextPlayer()];
            $log = new Logs();
            if (!$jugadorActual->getIsAutomatic() && isset($request['columna'])) {
                try {
                    $this->game->play($request['columna']);
                    $log ->getLog()->info("El jugador " . $jugadorActual->getName() . " introduce una ficha en la columna: " . $request['columna'] );
                    $this->game->save();
                } catch(Exception $err) {
                    $log->getLog()->error("Error, columna ". $request['columna']);
                }
            } elseif ($jugadorActual->getIsAutomatic()) {
                $columnaAutomatica = $this->game->playAutomatic();
                $log ->getLog()->info("El jugador " . $jugadorActual->getName() . " introduce una ficha en la columna: " .  $columnaAutomatica);
            }
        }

        if (isset($request['reset'])) {
            $this->game->reset();
            $this->game->save();
        }
        
        if (isset($request['exit'])) {
            unset($_SESSION['game']);
            session_destroy();
            header("location:/index.php");
            exit();
        }
        
        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();
        loadView('index', compact('board', 'players', 'winner', 'scores'));
    }
    
}
?>