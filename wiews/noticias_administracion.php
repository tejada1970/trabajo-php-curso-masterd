<?php
    ob_start();
    session_start();
    if (!isset($_SESSION['usuario'])) {
        // redirecciono al usuario a la página login.php para VISITANTES.
        header('location: ./login.php');
    }
    else {
        if (isset($_SESSION['usuario'])) {
            if(isset($_SESSION['rol'])){
                if ($_SESSION['rol'] !== 'admin') {
                    // redirecciono al usuario a la página login.php para VISITANTES.
                    header('location: ./login.php');
                }
            }
        }
    }
    $valRegistro = null;
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
    <link rel="stylesheet" href="../assets/fonts/font.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <header class="flex">
        <nav class="nav flex">
            <ul class="flex">
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias.php">Noticias</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./usuarios_administracion.php?tareaAdmin=verUsersAdmin">Users/Adm</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./citas_administracion.php?tareaAdmin=verCitasAdmin">Citas/Adm</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="noticias_administracion.php?tareaAdmin=verNoticiasAdmin" class="color">Noticias/Adm</a></li>
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
        <div class="containerTareas tareas_flex">
            <!-- aquí, introduzco el contenedor PHP según la 'tareaAdmin' a realizar -->
            <?php
                $tareaAdmin = $_GET['tareaAdmin'] ?? '';
                switch ($tareaAdmin) {
                    case 'verNoticiasAdmin':
                        include('../assets/admin/adminNoticias/verNoticiasAdmin.php');
                        break;
                    case 'insertarNoticiasAdmin':
                        $_SESSION['textNoticia'] = '';
                        $_SESSION['titulo'] = '';
                        include('../assets/admin/adminNoticias/insertarNoticiasAdmin.php');
                        break;
                    case 'modificarNoticiasAdmin':
                        include('../assets/admin/adminNoticias/modificarNoticiasAdmin.php');
                        break;
                    case 'modificarImgNoticiasAdmin':
                        include('../assets/admin/adminNoticias/modificarImgNoticiasAdmin.php');
                        break;
                    case 'deleteAdmin':
                        include('../assets/admin/deleteAdmin.php');
                        break;
                    default:
                        include('../assets/admin/adminNoticias/verNoticiasAdmin.php');
                        break;
                }
            ?>
        </div>
    </main>
    <!-- footer -->
    <?php include '../assets/archivosHTML/footerHTML/footer.html'; ?>
    <!-- scripts -->
    <script src="../scripts/burguer.js"></script>
    <script src="../scripts/tareasAdmin.js"></script>
    <script src="../scripts/avatar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    <script src="../assets/archivosHTML/footerHTML/footer.js"></script>
    <link rel="stylesheet" href="../assets/archivosHTML/footerHTML/footer.css">
</body>
</html>