<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
</head>
<body>
    <!-- este header es para la barra de navegación de VISITANTE -->
    <header class="header" id="headerVisit">
        <nav class="nav flex">
            <ul class="flex">
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="index.php" class="color">Index</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./wiews/noticias.php">Noticias</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./wiews/registro.php">Registro</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./wiews/login.php">Login/inicio sesión</a></li>
            </ul>
            <?php include('./assets/archivosPHP/logo2.php'); ?>
        </nav>
        <?php include('./assets/archivosPHP/logo1Burguer.php'); ?>
    </header>
</body>
</html>