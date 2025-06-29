<?php
    require_once __DIR__ . '/../assets/archivosPHP/SQL.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="stylesheet" href="../assets/archivosHTML/footerHTML/footer.css">
</head>
<body class="imgFondo">
    <?php
        // Muestra un error al 'usuario' que se esta registrando.
        if (isset($_GET['msgError'])) {
            $valRegistro = $_GET['msgError'];
        }

        // validar datos del formulario.
        if (isset($_POST['submitRegistro'])) {

            // guardar datos.
            $_SESSION['nombre'] = $_POST['nombre'];
            $_SESSION['apellidos'] = $_POST['apellidos'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['telefono'] = $_POST['telefono'];
            $_SESSION['birthday'] = $_POST['birthday'];
            $_SESSION['direccion'] = $_POST['direccion'];
            $_SESSION['usuario'] = $_POST['usuario'];

            // validar datos.
            $valRegistro = SQL::validarRegistro();
        }
    ?>
    <header>
        <nav class="nav flex">
            <ul class="flex">
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="../index.php">Index</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./noticias.php">Noticias</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="registro.php" class="color">Registro</a></li>
                <li class="flex"><img src="../assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="./login.php">Login/inicio sesión</a></li>
            </ul>
            <?php include('../assets/archivosPHP/logo2.php'); ?>
        </nav>
        <?php include('../assets/archivosPHP/logo1Burguer.php'); ?>
    </header>
    <main>
        <!-- formulario registro -->
        <div class="containAll flex">
            <div class="container formWidth">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="datos">
                    <div class="containerFraseH2 flex">
                        <h2>Registro</h2>
                    </div>
                    <div class="containerInputs">
                        <input type="text" name="nombre" placeholder="* Nombre" value="<?php echo $_SESSION['nombre'] ?? '' ?>">
                        <input type="text" name="apellidos" placeholder="* Apellidos" value="<?php echo $_SESSION['apellidos'] ?? '' ?>">
                        <input type="email" name="email" placeholder="* Email" value="<?php echo $_SESSION['email'] ?? '' ?>">
                        <input type="text" name="telefono" placeholder="* Teléfono" value="<?php echo $_SESSION['telefono'] ?? '' ?>">
                        <label for="birthday" class="colorLabel">* Fecha de nacimiento:</label>
                        <input type="date" name="birthday" value="<?php echo $_SESSION['birthday'] ?? '' ?>">
                        <input type="text" name="direccion" placeholder="Dirección" value="<?php echo $_SESSION['direccion'] ?? '' ?>">
                        <label for="sexo" class="colorLabel">Sexo: </label>
                        <select name="sexo">
                            <option value="">Selecciona un sexo</option>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                            <option value="otro">Otro</option>
                        </select>
                        <br><br>
                        <input type="text" name="usuario" placeholder="* Usuario" value="<?php echo $_SESSION['usuario'] ?? '' ?>">
                        <input type="password" name="password" placeholder="* Password">
                        <div class="container_submit">
                            <input type="submit" name="submitRegistro" value="Registrar">
                            <h3>¿Ya estas registrado? <br><a href="./login.php" class="resetear">Inicia sesión aquí</a></h3>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- footer -->
    <?php include '../assets/archivosHTML/footerHTML/footer.html'; ?>
    <!-- scripts -->
    <script src="../scripts/resetear.js"></script>
    <script src="../scripts/burguer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    <script src="../assets/archivosHTML/footerHTML/footer.js"></script>
</body>
</html>