<?php
  include('../assets/archivosPHP/SQL.php');
  $valRegistro = null;
  $userAdmin = null;
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
            /* Obtengo el 'idUser encryptado con md5' pasado por 'url' desde verUsersAdmin.php. */
            if (isset($_GET['rUmCa'])) {
                $userAdmin = $_GET['rUmCa'];
                $_SESSION['numUser'] = '';
                $idUser = '';
                $array = array();
                $users = [];
                $users = SQL::obtenerIdUsersAdmin();
                foreach($users as $value) {
                    $array = array($value->idUser);
                    $idUser = implode(",", $array);
                    if (md5($idUser) === $userAdmin) {
                        $_SESSION['numUser'] = $idUser;
                    }
                }
                $userAdmin = $_SESSION['numUser'];
                // declaro la variable de sesión 'identUser' para el 'usuario' a modificar y actualizar.
                $_SESSION['identUserAdmin'] = $userAdmin;
            }
            // validar datos del formulario.
            if (isset($_POST['submitModUserAdmin'])) {
                $valRegistro = SQL::validarModUserAdmin();
            }
        ?>
        <!-- formulario modoficar citas admin -->
        <div class="containAll flex">
            <div class="container formWidth">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Modificar Usuario</h2>
                        </div>
                        <div>
                            <div class="btnCerrarUsers flex">
                                <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                            </div>
                        </div>
                    </div>
                    <?php
                            // Obtengo el 'usuario' del registro seleccionado a traves de su 'email'.
                            $resultado = [];
                            $resultado = SQL::obtenerUsuarioAdmin($userAdmin);
                            
                            if ($resultado > 0) {
                        ?>
                            <div class="containerInputs">
                                <div class="flexAdmin">
                                    <div>
                                    <label for="nombreUserAdmin" class="colorLabel">* Nombre: </label>
                                    <input type="text" id="nombreUserAdmin" name="nombre" value="<?php echo $resultado[0]->nombre ?>" placeholder="* Nombre">
                                    </div>
                                    <div>
                                    <label for="apellidosUserAdmin" class="colorLabel">* Apellidos: </label>
                                    <input type="text" id="apellidosUserAdmin" name="apellidos" value="<?php echo $resultado[0]->apellidos ?>" placeholder="* Apellidos">
                                    </div>
                                </div>
                                <label fo="emailUserAdmin" class="colorLabel">Email: </label>
                                <input type="email" id="emailUserAdmin" name="email" value="<?php echo $resultado[0]->email ?>" readonly>
                                <label for="newEmailUserAdmin" class="colorLabel">* Cambiar: </label>
                                <input type="email" id="newEmailUserAdmin" name="newEmail" value="<?php echo $resultado[0]->email ?>" placeholder="* Nuevo email">
                                <div class="flexAdmin">
                                    <div>
                                    <label for="telefonoUserAdmin" class="colorLabel">* Telefono: </label>
                                    <input type="text" id="telefonoUserAdmin" name="telefono" value="<?php echo $resultado[0]->telefono ?>" placeholder="* Teléfono">
                                    </div>
                                    <div>
                                    <label for="birthdayUserAdmin" class="colorLabel">* Fecha nacimiento: </label>
                                    <input type="date" id="birthdayUserAdmin" name="birthday" value="<?php echo $resultado[0]->fecha_nacimiento ?>">
                                    </div>
                                </div>
                                <label for="direccionUserAdmin" class="colorLabel">Direccion: </label>
                                <input type="text" id="direccionUserAdmin" name="direccion" value="<?php echo $resultado[0]->direccion ?>" placeholder="Dirección">
                                <div class="sexo_flex">
                                    <label class="colorLabel">Sexo: </label>
                                    <input type="text" id="cajaSexoAdmin" name="cajaSexoAdmin" value="<?php echo $resultado[0]->sexo ?>" readonly>
                                    <select name="sexoUserAdmin" id="sexoUserAdmin" onchange="obtenerSexoAdmin(this)">
                                        <option value="">Selecciona un sexo</option>
                                        <option value="hombre">Hombre</option>
                                        <option value="mujer">Mujer</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <br>
                                <div class="flexAdmin">
                                    <div>
                                    <label for="usuarioUserAdmin" class="colorLabel">Usuario: </label>
                                    <input type="text" id="usuarioUserAdmin" name="usuario" value="<?php echo $resultado[0]->usuario ?>" readonly>
                                    </div>
                                    <div>
                                    <label for="newUserAdmin" class="colorLabel">* Cambiar : </label>
                                    <input type="text" id="newUserAdmin" name="newUserAdmin" value="<?php echo $resultado[0]->usuario ?>" placeholder="* New Usuario">
                                    </div>
                                    <div>
                                    <label for="rolUserAdmin" class="colorLabel">* Rol: </label>
                                    <input type="text" id="rolUserAdmin" name="rol" value="<?php echo $resultado[0]->rol ?>" placeholder="* rol">
                                    </div>
                                </div>
                                <div class="enviar">
                                    <input type="submit" name="submitModUserAdmin" value="Actualizar Usuario">
                                </div>
                            </div> 
                        <?php
                            } 
                        ?>
                </form>
            </div>
        </div>
    </main>
    <!-- scripts -->
    <script src="../scripts/obtenerSexo.js"></script>
</body>
</html>