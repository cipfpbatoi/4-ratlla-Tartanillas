<?php

namespace Joc4enRatlla\Models;

class Board {
    public const FILES = 6;
    public const COLUMNS = 7;
    public const DIRECTIONS = [
        [0, 1],   // Horizontal derecha
        [1, 0],   // Vertical abajo
        [1, 1],   // Diagonal abajo-derecha
        [1, -1]   // Diagonal abajo-izquierda
    ];

    private array $slots;

    public function __construct() {
        // TODO: Ha d'inicializar $slots
        $this->slots = self::initializeBoard();
    }

    // Getters i Setters 

    //Inicialitza la graella amb valors buits
    private static function initializeBoard(): array {
        $slots = [];
        for ($fila = 1; $fila <= self::FILES; $fila++) {
            for ($columna = 1; $columna <= self::COLUMNS; $columna++) {
                $slots[$fila][$columna] = 0;
            }
        }
        return $slots;
    }

    //Realitza un moviment en la graella
    public function setMovementOnBoard(int $column, int $player): array {
        for ($fila = count($this->slots); $fila > 0 ; $fila--) {
            if ($this->slots[$fila][$column] == 0) {
                $this->slots[$fila][$column] = $player;
                break;
            }
        }
        return $this->slots;
    }
    
    //Comprova si hi ha un guanyador
    public function checkWin(array $coord): bool {
        // TODO: Comprova si hi ha un guanyador
        $jugador = $this->slots[$coord[0]][$coord[1]];
        foreach (self::DIRECTIONS as $direction) {
            $fila = $coord[0];
            $columna = $coord[1];
            for ($i = 0; $i < 4; $i++) {
                $fila += $direction[0];
                $columna += $direction[1];
                if ($this->slots[$fila][$columna] != $jugador) {
                    break;
                }
                if ($i == 3) {
                    return true;
                }
            }
        }
        return false;
    }

    //Comprova si el moviment és vàlid
    public function isValidMove(int $column): bool {
        if ($column < 0 || $column >= 7) {
            echo '<span class="incorrect">Introduce una columna válida.</span>';
            return false;
        } else {
            for ($fila = count(self::$slots) - 1; $fila >= 0; $fila--) {
                if ($this->slots[$fila][$column] == 0) {
                    return true;
                }
            }
            return false;
        }
    }
    public function isFull(): bool {
        // TODO: El tauler està ple?
        foreach ($this->slots as $fila) {
            foreach ($fila as $celda) {
                if($celda != 0) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
    * @return array
    */
    public function getSlots(): array {
        return $this->slots;
    }
}
