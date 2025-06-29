<?php
    require_once __DIR__ . '/../../archivosPHP/SQL.php';
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="imgFondo">
    <main>
        <?php
            // declaro las variables de sesión, para guardar los datos del form.
            $_SESSION['nombreUser'] = '';
            $_SESSION['apellidosUser'] = '';
            $_SESSION['emailUser'] = '';
            $_SESSION['telefonoUser'] = '';
            $_SESSION['birthdayUser'] = '';
            $_SESSION['direccionUser'] = '';

            // validar datos del formulario.
            if (isset($_POST['submitUserAdmin'])) {
                // guardar datos.
                $_SESSION['nombreUser'] = $_POST['nombre'];
                $_SESSION['apellidosUser'] = $_POST['apellidos'];
                $_SESSION['emailUser'] = $_POST['email'];
                $_SESSION['telefonoUser'] = $_POST['telefono'];
                $_SESSION['birthdayUser'] = $_POST['birthday'];
                $_SESSION['direccionUser'] = $_POST['direccion'];
                // validar datos.
                $resultadoValidacion = SQL::validarRegistroAdmin();
                if (is_array($resultadoValidacion)) {
                    // La validación fue exitosa, devuelve los datos guarda el registro
                    list($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password, $rol) = $resultadoValidacion;
                    $returnOk = SQL::insertarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password, $rol);
                    if ($returnOk) {
                        // Si el registro fue éxitoso redirecciona a la página de origen del crud con un mensaje de confirmación
                        header('location:usuarios_administracion.php?msgConfirm=Registro Realizado&tareaAdmin=verUsersAdmin');
                        exit();
                    }
                } else {
                    // La validación falló, muestra el mensaje de error.
                    $valRegistro = $resultadoValidacion;
                }
            }
        ?>
        <!-- formulario insertar citas admin -->
        <div class="containAll flex">
            <div class="container formWidth">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Agregar Usuario</h2>
                        </div>
                        <div>
                            <div class="btnCerrarUsers flex">
                                <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                            </div>
                        </div>
                    </div>
                    <div class="containerInputs">
                        <input type="text" name="nombre" placeholder="* Nombre" value="<?php echo $_SESSION['nombreUser'] ?? '' ?>">
                        <input type="text" name="apellidos" placeholder="* Apellidos" value="<?php echo $_SESSION['apellidosUser'] ?? '' ?>">
                        <input type="email" name="email" placeholder="* Email" value="<?php echo $_SESSION['emailUser'] ?? '' ?>">
                        <input type="text" name="telefono" placeholder="* Teléfono" value="<?php echo $_SESSION['telefonoUser'] ?? '' ?>">
                        <label for="birthday" class="colorLabel">* Fecha de nacimiento:</label>
                        <input type="date" name="birthday" value="<?php echo $_SESSION['birthdayUser'] ?? '' ?>">
                        <input type="text" name="direccion" placeholder="Dirección" value="<?php echo $_SESSION['direccionUser'] ?? '' ?>">
                        <label for="sexo" class="colorLabel">Sexo: </label>
                        <select name="sexo">
                            <option value="">Selecciona un sexo</option>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                            <option value="otro">Otro</option>
                        </select>
                        <br><br>
                        <input type="text" name="usuario" placeholder="* Usuario">
                        <input type="password" name="password" placeholder="* Password">
                        <input type="text" name="rol" placeholder="* rol">
                        <div>
                            <input type="submit" name="submitUserAdmin" value="Agregar Usuario" class="outlineColor">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>