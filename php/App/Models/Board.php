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

    public function __construct() {}

    // Getters i Setters 

    //Inicialitza la graella amb valors buits
    private static function initializeBoard(): array {
        for ($fila = 0; $fila < self::FILES; $fila++) {
            for ($columna = 0; $columna < self::COLUMNS; $columna++) {
                self::$slots[$fila][$columna] = 0;
            }
        }
        return self::$slots;
    }

    //Realitza un moviment en la graella
    public function setMovementOnBoard(int $column, int $player): array {
        for ($fila = 0; $fila < self::FILES; $fila++) {
            if ($this->slots[$fila][$column] == 0) {
                $this->slots[$fila][$column] = $player;
                return [$fila, $column];
            }
        }
    }
    
    //Comprova si hi ha un guanyador
    public function checkWin(array $coord): bool {
    
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
}
