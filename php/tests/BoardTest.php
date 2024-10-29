<?php
use Joc4enRatlla\Models\Board;
use PHPUnit\Framework\TestCase;
    class BoardTest extends TestCase {
        private $board;

        // Método setUp se ejecuta antes de cada prueba
        protected function setUp(): void {
        $this->board = new Board();
    }

        public function testInitializeBoard(): void {
            $this->assertIsArray($this->board->getSlots());
            $this->assertEquals(Board::FILES, count($this->board->getSlots()));
        }

        public function testSetMovementOnBoard(): void {
            $this->board->setMovementOnBoard(3, 1);
            $this->assertEquals(1, $this->board->getSlots()[6][3]);
        }

        public function testCheckWin(): void {
            $this->board->setMovementOnBoard(1, 1);
            $this->board->setMovementOnBoard(2, 1);
            $this->board->setMovementOnBoard(3, 1);
            $this->board->setMovementOnBoard(4, 1);
            $this->assertTrue($this->board->checkWin(1));
        }
    }
?>