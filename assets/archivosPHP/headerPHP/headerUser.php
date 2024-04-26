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
    <!-- este header es para la barra de navegación de USUARIO -->
    <header class="header" id="headerUser">
        <nav class="nav flex">
            <ul class="flex">
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="index.php" class="color">Index</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./wiews/noticias.php">Noticias</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./wiews/citaciones.php?tarea=tareas">Citaciones</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./wiews/perfil.php">Perfil</a></li>
                <li class="flex"><img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./assets/archivosPHP/cerrarSesion.php">Cerrar sesión</a></li>
            </ul>
            <div class="divAvatar flex">
                <div class="avatarIco">
                    <img src="./assets/icons/user-solid.svg" alt="icono_usuario" class="icon">
                </div>
                <div class="avatarUser">
                    <p><?php echo $_SESSION['usuario'] ?></p>
                </div>
            </div>
            <?php include('./assets/archivosPHP/logo2.php'); ?>
        </nav>
        <?php include('./assets/archivosPHP/logo1Burguer.php'); ?>
    </header>
</body>
</html>