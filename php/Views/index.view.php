<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <title>4 en ratlla</title>
    <style>
        td.player1 {
            background-color: <?php echo $players[1]->getColor(); ?>;
            border: 5px solid <?php echo $players[1]->getColor(); ?>;
        }

        td.player2 {
            background-color: <?php echo $players[2]->getColor(); ?>;
            border: 5px solid <?php echo $players[2]->getColor(); ?>;
        }
    </style>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <?php include_once $_SERVER['DOCUMENT_ROOT'].'/../Views/board.view.php'  ?>
    <input type="submit" name="reset" value="Reiniciar juego">
    <input type="submit" name="exitGame" value="Salir del juego">
    <input type="submit" name="exit" value="Cerrar sesión"><br>
    <input type="submit" name="saveGame" value="Guardar partida">
    <input type="submit" name="restoreGame" value="Cargar partida">
</form>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/../Views/panel.view.php'  ?>
</body>
</html>