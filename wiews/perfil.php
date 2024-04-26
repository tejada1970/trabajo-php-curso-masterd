<?php
    session_start();

    // para la barra de navegación según inicie sesión USUARIO o ADMIN.
    $_SESSION['header'] = null;

    if (!isset($_SESSION['usuario'])) {
        // redirecciono al usuario a la página login.php para VISITANTES.
        header('location: ./login.php');
    }
    else {
        if (isset($_SESSION['usuario'])) {
        
            if(isset($_SESSION['rol'])){
        
                switch($_SESSION['rol']){
        
                    case 'admin':
                        // asigno la barra de navegación para ADMIN.
                        $_SESSION['header'] = 'headerAdminPerfil';
                    break;
        
                    case 'user':
                        // asigno la barra de navegación para USUARIO.
                        $_SESSION['header'] = 'headerUserPerfil';
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body class="imgFondo">
    <?php
        // Muestra una confirmación al 'usuario', de la actualización del perfil.
        if (isset($_GET['msgConfirm'])) {
            include('../assets/archivosPHP/messages.php');
            $valConfirm = null;
        }

        // validar datos del formulario.
        if (isset($_POST['submitPerfil'])) {
            $valRegistro = SQL::validarPerfil();
            $valRegistro = $valRegistro;
        }
    ?>
    <?php
        // aquí incluyo la barra de navegación según sea (usuario o admin).
        if ($_SESSION['header'] === 'headerAdminPerfil') {
        ?>
        <header class="flex">
            <nav class="nav flex">
                <ul class="flex">
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="noticias.php">Noticias</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./usuarios_administracion.php?tareaAdmin=verUsersAdmin">Usuarios/Admin</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./citas_administracion.php?tareaAdmin=verCitasAdmin">Citas/Admin</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias_administracion.php?tareaAdmin=verNoticiasAdmin">Noticias/Admin</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./perfil.php" class="color">Perfil</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../assets/archivosPHP/cerrarSesion.php">Cerrar sesión</a></li>
                </ul>
                <?php include('../assets/archivosPHP/logo2Avatar.php'); ?>
            </nav>
            <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
        </header>
        <?php
        }
        elseif ($_SESSION['header'] === 'headerUserPerfil') {
        ?>
        <header>
            <nav class="nav flex">
                <ul class="flex">
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias.php">Noticias</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./citaciones.php?tarea=tareas">Citaciones</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="perfil.php" class="color">Perfil</a></li>
                    <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../assets/archivosPHP/cerrarSesion.php">Cerrar sesión</a></li>
                </ul>
                <?php include('../assets/archivosPHP/logo2Avatar.php'); ?>
            </nav>
            <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
        </header>
        <?php
            }
        ?>
    <main>
        <!-- formulario perfil -->
        <div class="containAll flex">
            <div class="container container2 formWidth">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="datos">
                    <div class="containerFraseH2 flex">
                        <h2>Perfil</h2>
                    </div>
                    <!--
                        Primero muestro todos los datos personales del 'usuario' de la sesión actual.
                        En caso de que el 'usuario' pulse 'Actualizar' tras a ver realizado algún cambio o no,
                        envio los datos a 'SQL.php' para su validación, modificación y actualización, en sus respectivas tablas.
                    -->
                    <?php
                        // Obtengo todos sus datos personales de la tabla 'users_data', a traves de su 'idUser'.
                        $resultado = [];
                        $resultado = SQL::obtenerDatosPersonales($_SESSION['idUser']);
                        
                        if ($resultado > 0) {
                    ?>
                        <div class="containerInputs">
                            <div class="flexRow nonWrap gap10">
                                <div>
                                  <label for="nombre" class="colorLabel">* Nombre: </label>
                                  <input type="text" id="nombre" name="nombre" value="<?php echo $resultado[0]->nombre ?>" placeholder="* Nombre">
                                </div>
                                <div>
                                   <label for="apellidos" class="colorLabel">* Apellidos: </label>
                                   <input type="text" id="apellidos" name="apellidos" value="<?php echo $resultado[0]->apellidos ?>" placeholder="* Apellidos">
                                </div>
                            </div>
                            <label class="colorLabel">Email: </label>
                            <input type="email" name="email" value="<?php echo $resultado[0]->email ?>" readonly>
                            <label for="newEmail" class="colorLabel">* Cambiar: </label>
                            <input type="email" id="newEmail" name="newEmail" value="<?php echo $resultado[0]->email ?>" placeholder="* Nuevo email">
                            <div class="flexRow nonWrap gap10">
                               <div>
                                  <label for="telefono" class="colorLabel">* Telefono: </label>
                                  <input type="text" id="telefono" name="telefono" value="<?php echo $resultado[0]->telefono ?>" placeholder="* Teléfono">
                               </div>
                               <div>
                                  <label for="birthday" class="colorLabel">* Fecha nacimiento: </label>
                                  <input type="date" id="birthday" name="birthday" value="<?php echo $resultado[0]->fecha_nacimiento ?>">
                               </div>
                            </div>
                            <label for="direccion" class="colorLabel">Direccion: </label>
                            <input type="text" id="direccion" name="direccion" value="<?php echo $resultado[0]->direccion ?>" placeholder="Dirección">
                            <div class="sexo_flex">
                                <label class="colorLabel">Sexo: </label>
                                <input type="text" id="cajaSexo" name="cajaSexo" value="<?php echo $resultado[0]->sexo ?>" readonly>
                                <select name="sexo" id="sexo" onchange="obtenerSexo(this)">
                                    <option value="">Selecciona un sexo</option>
                                    <option value="hombre">Hombre</option>
                                    <option value="mujer">Mujer</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                            <br>
                            <label for="newPassword" class="colorLabel">Cambiar contraseña: </label>
                            <input type="password" id="newPassword" name="newPassword" placeholder="Nueva contraseña">
                            <div class="enviar">
                                <input type="submit" name="submitPerfil" value="Actualizar">
                            </div>
                        </div> 
                    <?php
                        } 
                    ?>
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
    <script src="../scripts/obtenerSexo.js"></script>
    <script src="../scripts/burguer.js"></script>
    <script src="../scripts/avatar.js"></script>
</body>
</html>