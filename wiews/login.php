<?php
  include('../assets/archivosPHP/SQL.php');
  $valRegistro = null;
  $valConfirm = null;
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
    <link rel="stylesheet" href="../assets/fonts/font.css"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="imgFondo">
    <?php
        // Muestra un confirmación al 'usuario' recien registrado.
        if (isset($_GET['msgConfirm'])) {
            include('../assets/archivosPHP/messages.php');
            $valConfirm = null;
        }

        // Muestra un error al iniciar sesión.
        if (isset($_GET['msgError'])) {
            $valRegistro = $_GET['msgError'];
        }

        // validar datos del formulario.
        if (isset($_POST['submitLogin'])) {
            $valRegistro = SQL::validarLogin();
        }
    ?>
    <header>
        <nav class="nav flex">
            <ul class="flex">
            <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias.php">Noticias</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./registro.php">Registro</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="login.php" class="color">Login/inicio sesión</a></li>
            </ul>
            <?php include('../assets/archivosPHP/logo2.php'); ?>
        </nav>
        <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
    </header>
    <main>
        <!-- formulario login -->
        <div class="containAll flex">
            <div class="msgCredenciales">
                <p class="validarDatos">
                    Credenciales para administrador:<br />
                    1. usuario = admin uno<br />
                    2. contraseña = admin123
                </p>
                <p class="validarDatos">
                    Credenciales para usuario:<br />
                    1. usuario = usuario uno<br />
                    2. contraseña = user123
                </p>
            </div>
            <div class="container">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="datos">
                    <div class="containerFraseH2 flex">
                        <h2>Login <i class="icon-key colorIco"></i></h2>
                    </div>
                    <div class="containerInputs">
                        <div class="flex">
                            <div class="flexRow">
                                <input type="text" class="icono-placeholder inputLogin txtCenter" placeholder="Usuario" name="usuarioLogin">
                                <i class="icon-user icono"></i>
                            </div>
                            <div class="flexRow">
                                <input type="password" class="icono-placeholder inputLogin txtCenter" placeholder="Contraseña" name="passwordLogin">
                                <i class="icon-key icono"></i>
                            </div>
                        </div>
                        <div class="container_submit">
                            <input type="submit" value="Iniciar sesión" name="submitLogin" class="submit">
                            <h3>¿No estas registrado? <br><a href="./registro.php" class="resetear">Registrate aquí</a></h3>
                        </div>
                        <div class="containerVideo">
                            <video src="../assets//video/gato.mp4" loop="loop" autoplay="autoplay" width="300" height="200"></video>
                            <div class="capaVideo"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <div class="paspartu">
            <iframe src="../assets/archivosHTML/footerHTML/footer.html"></iframe>
        </div>
    </footer>

    <!-- scripts -->
    <script src="../scripts/resetear.js"></script>
    <script src="../scripts/burguer.js"></script>
</body>
</html>