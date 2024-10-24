<?php

namespace Joc4enRatlla\Controllers;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;


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
    
    $this->game->play($request['columna']);
    $board = $this->game->getBoard();
    $players = $this->game->getPlayers();
    $winner = $this->game->getWinner();
    $scores = $this->game->getScores();
    loadView('index',compact('board','players','winner','scores'));
}
}
?>