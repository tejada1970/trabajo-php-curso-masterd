<?php
    session_start();

    // para la barra de navegación según inicie sesión USUARIO o ADMIN.
    $_SESSION['header'] = null;

    if (!isset($_SESSION['usuario'])) {
        // asigno la barra de navegación para VISITANTE.
        $_SESSION['header'] = 'headerVisitNoticias';
    }
    else {
        if (isset($_SESSION['usuario'])) {
        
            if(isset($_SESSION['rol'])){
        
                switch($_SESSION['rol']){
        
                    case 'admin':
                        // asigno la barra de navegación para ADMIN.
                        $_SESSION['header'] = 'headerAdminNoticias';
                    break;
        
                    case 'user':
                        // asigno la barra de navegación para USUARIO.
                        $_SESSION['header'] = 'headerUserNoticias';
                    break;
        
                    default;
                        // redirecciono al usuario a la página login.php para VISITANTES.
                        header('location: ./login.php');
                    break;
                }
            }
        }
    }

    include('../assets/archivosPHP/SQL.php');
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
    <link rel="stylesheet" href="../css/noticias.css">
    <link rel="stylesheet" href="../assets/archivosHTML/footerHTML/footer.css">
</head>
<body class="imgFondo">
    <?php
        // aquí incluyo la barra de navegación según sea (admin, usuario o visitante).
        if ($_SESSION['header'] === 'headerAdminNoticias') {
        ?>
        <header class="flex" id="headerAdminNoticias">
            <nav class="nav flex">
                <ul class="flex">
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="noticias.php" class="color">Noticias</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./usuarios_administracion.php?tareaAdmin=verUsersAdmin">Users/Admin</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./citas_administracion.php?tareaAdmin=verCitasAdmin">Citas/Admin</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias_administracion.php?tareaAdmin=verNoticiasAdmin">Noticias/Admin</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./perfil.php">Perfil</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../assets/archivosPHP/cerrarSesion.php">Cerrar sesión</a></li>
                </ul>
                <?php include('../assets/archivosPHP/logo2Avatar.php'); ?>
            </nav>
            <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
        </header>
        <?php
        }
        elseif ($_SESSION['header'] === 'headerUserNoticias') {
        ?>
        <header id="headerUserNoticias">
            <nav class="nav flex">
                <ul class="flex">
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="noticias.php" class="color">Noticias</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./citaciones.php?tarea=tareas">Citaciones</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./perfil.php">Perfil</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../assets/archivosPHP/cerrarSesion.php">Cerrar sesión</a></li>
                </ul>
                <?php include('../assets/archivosPHP/logo2Avatar.php'); ?>
            </nav>
            <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
        </header>
        <?php
        }else {
        ?>
        <header id="headerVisitNoticias">
            <nav class="nav flex">
                <ul class="flex">
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="noticias.php" class="color">Noticias</a></li> 
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./registro.php">Registro</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./login.php">Login/inicio sesión</a></li>
                </ul>
                <?php include('../assets/archivosPHP/logo2.php'); ?>
            </nav>
            <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
        </header>
        <?php
        }
    ?>
    <main>
        <div class="containAll flex">
            <section class="section sectionNoticias flex">
                <h2 class="h2Title">Ultimas Noticias</h2>
                <div class="containerArticle flex">
                    <?php                    
                    // Obtengo y muestro todas las 'noticias' de la tabla 'noticias'.
                    $resultado = SQL::obtenerNoticiasAdmin();
                    if ($resultado) {
                        foreach ($resultado as $value) {
                    ?>
                    <article class="articleNoticias">
                        <div><h2 class="titleNoticia"><?php echo $value->titulo ?></h2></div>
                        <div class="divNoticia flex">
                            <div class="divNoticia_1">
                                <div><p class="txtNoticia"><?php echo $value->texto ?></p></div>
                            </div>
                            <div class="divNoticia_2">
                                <div><img src="data:<?php echo $value->tipo ?>;base64,<?php echo base64_encode($value->imagen) ?>" alt="imgNoticiasAdmin"></div>
                                <div><p><?php echo "Fecha: ".$value->fecha_noticia ?></p></div>
                                <?php
                                // Obtengo y muestro el 'nombre y apellidos' del 'usuario' que ha escrito la 'noticia'.
                                $iduserEscritor = $value->idUser;
                                $result = SQL::obtenerEscritorNoticia($iduserEscritor);
                                if ($result) {
                                    foreach ($result as $value) {
                                ?>
                                <div class="divNoticiaLast"><p><?php echo "Escrito por: ".$value->nombre.' '.$value->apellidos ?></p></div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </article>
                    <?php
                        }
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>
    <!-- footer -->
    <?php include '../assets/archivosHTML/footerHTML/footer.html'; ?>
    <!-- scripts -->
    <script src="../scripts/burguer.js"></script>
    <script src="../scripts/avatar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    <script src="../assets/archivosHTML/footerHTML/footer.js"></script>
</body>
</html>