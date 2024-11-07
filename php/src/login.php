<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/../vendor/autoload.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/../Helpers/functions.php'; 
    use Joc4enRatlla\Services\Db;

    if (isset($_POST['login'])) {
        $usuario = htmlspecialchars($_POST['usuario']);
        $contrasenya = htmlspecialchars($_POST['contrasenya']);
        $pdo = Db::connect();

        $sql = "SELECT * FROM usuaris WHERE nom_usuari = :usuario";
        $sentence = $pdo->prepare($sql);
        $sentence->setFetchMode(PDO::FETCH_ASSOC);
        $sentence->bindParam(':usuario', $usuario);
        $sentence->execute();
        $usuarioDevuelto = $sentence->fetch(PDO::FETCH_OBJ);

        if($usuarioDevuelto) {
            if(password_verify($contrasenya, $usuarioDevuelto->contrasenya)) {
                $_SESSION['usuarioId'] = $usuarioDevuelto->id;
                header("Location: index.php");
                exit();
            } else {
                header("Location: login.php");
                exit();
            }
        } else {
            $contrasenyaHasheada = password_hash($contrasenya, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuaris (nom_usuari, contrasenya) VALUES (:usuario, :contrasenya)";
            $sentence = $pdo->prepare($sql);
            $sentence->bindParam(':usuario', $usuario);
            $sentence->bindParam(':contrasenya', $contrasenyaHasheada);
            $sentence->execute();
            header("Location: index.php");
            exit();
        }
    } else {
        loadView('login');
    }
?>