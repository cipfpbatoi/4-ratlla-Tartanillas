<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Formulario</h1>
    <form action="#" method="post">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="color">Elige un color</label>
        <select id="color" name="color">
            <option value="red">Rojo</option>
            <option value="orange">Naranja</option>
            <option value="blue">Azul</option>
            <option value="yellow">Amarillo</option>
            <option value="purple">Morado</option>
            <option value="white">Blanco</option>
        </select><br><br>

        <input type="submit" value="Enviar">
    </form>
</body>
</html>
