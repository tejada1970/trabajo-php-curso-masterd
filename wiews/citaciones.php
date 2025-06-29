<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        // redirecciono al usuario a la página login.php para VISITANTES.
        header('location: ./login.php');
    }
    else {
        if (isset($_SESSION['usuario'])) {
            if(isset($_SESSION['rol'])){
                if ($_SESSION['rol'] !== 'user') {
                    // redirecciono al usuario a la página login.php para VISITANTES.
                    header('location: ./login.php');
                }
            }
        }
    }
    if (isset($_GET['msgConfirm'])) {
        include('../assets/archivosPHP/messages.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/citaciones.css">
    <link rel="stylesheet" href="../assets/archivosHTML/footerHTML/footer.css">
</head>
<body class="imgFondo">
    <header>
        <nav class="nav flex">
            <ul class="flex">
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias.php">Noticias</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="citaciones.php?tarea=tareas" class="color">Citaciones</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./perfil.php">Perfil</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../assets/archivosPHP/cerrarSesion.php">Cerrar sesión</a></li>
            </ul>
            <div class="divAvatar flex">
                <div class="avatarIco">
                    <img src="../assets/icons/user-solid.svg" alt="icono_usuario" class="icon">
                </div>
                <div class="avatarUser">
                    <p><?php echo $_SESSION['usuario'] ?></p>
                </div>
            </div>
            <div class="containLogo2 flex">
                <div class="logo2"></div>
                <div>
                    <h1><span class="spanColorLogo2">S</span>mall <span class="spanColorLogo2">P</span>ets</h1>
                </div>
            </div>
        </nav>
        <!-- burguer -->
        <div class="containBtnResp">
            <div class="abrirCerrar_menu button_menu">
                <span></span>
                <span></span>   
                <span></span>
            </div>
            <div class="containLogo flex">
                <div class="logo"></div>
                <div>
                    <h1><span class="spanColorLogo">S</span>mall <span class="spanColorLogo">P</span>ets</h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="containAll flex mostrarTareas cerrarTareas">
            <div class="containerTareas tareas_flex">
                <!-- aquí, introduzco el contenedor HTML según la 'tarea' a realizar -->
                <?php
                    $tarea = null;
                    if (isset($_GET['tarea'])) {
                        if ($_GET['tarea'] === 'insertar') {
                            $_SESSION['textCita'] = '';
                            include('../assets/archivosPHP/insertarCita.php');
                            $tarea = null;

                        }elseif ($_GET['tarea'] === 'verCitas') {
                            // muestro todas las 'citas' del 'usuario de la sesión actual' a traves de 'ajax'.
                            include('../assets/archivosPHP/verCitas.php');
                            $tarea = null;
                        }
                        elseif ($_GET['tarea'] === 'modificar') {
                            include('../assets/archivosPHP/modificarCita.php');
                            $tarea = null;

                        }elseif ($_GET['tarea'] === 'actualizar') {
                            include('../assets/archivosPHP/actualizarCita.php');
                            $tarea = null;

                        }elseif ($_GET['tarea'] === 'anular') {
                            include('../assets/archivosPHP/anularCita.php');
                            $tarea = null;

                        }elseif ($_GET['tarea'] === 'eliminar') {
                            include('../assets/archivosPHP/eliminarCita.php');
                            $tarea = null;

                        }elseif ($_GET['tarea'] === 'tareas') {
                            include('../assets/archivosPHP/tareasCitas.php');
                            $tarea = null;
                            
                        }else {
                            include('../assets/archivosPHP/tareasCitas.php');
                            $tarea = null;
                        }
                    }else {
                        include('../assets/archivosPHP/tareasCitas.php');
                        $tarea = null;
                    }
                ?>
            </div>
        </div>
    </main>
    <!-- footer -->
    <?php include '../assets/archivosHTML/footerHTML/footer.html'; ?>
    <!-- scripts -->
    <script src="../scripts/tareasCitas.js"></script>
    <script src="../scripts/resetear.js"></script>
    <script src="../scripts/cargarCitas.js"></script>
    <script src="../scripts/burguer.js"></script>
    <script src="../scripts/avatar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    <script src="../assets/archivosHTML/footerHTML/footer.js"></script>
</body>
</html>