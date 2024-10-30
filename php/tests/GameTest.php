<?php
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;
use PHPUnit\Framework\TestCase;
    class GameTest extends TestCase {
        private $game;

        protected function setUp(): void {
            session_start();
            $jugador1 = new Player('Jugador 1', 'red');
            $jugador2 = new Player('Jugador 2', 'yellow');
            $this->game = new Game($jugador1, $jugador2);
        }
    
        public function testSaveAndRestoreSession(): void {
            $this->game->play(1);
            $this->game->play(2);
            $this->game->save();
            $restoredGame = Game::restore();
            $this->assertEquals($this->game->getBoard()->getSlots(), $restoredGame->getBoard()->getSlots());
            $this->assertEquals($this->game->getNextPlayer(), $restoredGame->getNextPlayer());
        }
    }
    ?>