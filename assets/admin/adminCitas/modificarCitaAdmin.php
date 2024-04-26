<?php
  include('../assets/archivosPHP/SQL.php');
  $valRegistro = null;
  $mostrarCitas = null;
  $userCita = null;
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
    <?php    
        // recogo 'fecha' para mostrar la 'cita' a modificar y actualizar.
        if (isset($_GET['fecha'])) {
            $mostrarCitas = $_GET['fecha'];
        }

        /*
            - Obtengo el 'idUser encryptado con md5' pasado por 'url' desde verUsersAdmin.php.
            - Luego, obtengo todos los 'idUser' de la tabla 'citas', recorro el array y cada valor
                lo convierto en string.
            - A continuación, creo un 'if' para comparar cada valor del array con la encryptación.
            - Por ultimo, el valor que coincide, me lo guarda en la variable de sesión $_SESSION['numUser'],
                que a su vez guarda el valor en la variable '$userCita', donde la utilizaré más abajo para obtener
                todos los datos de la 'cita' del usuario enviado por url.
        */
        if (isset($_GET['rUmC'])) {
            $userCita = $_GET['rUmC'];
            $_SESSION['numUser'] = '';
            $idUser = '';
            $array = array();
            $users = [];
            $users = SQL::obteneridUsersCitas();
            foreach($users as $value) {
                $array = array($value->idUser);
                $idUser = implode(",", $array);
                if (md5($idUser) === $userCita) {
                    $_SESSION['numUser'] = $idUser;
                }
            }
            $userCita = $_SESSION['numUser'];
            // declaro la variable de sesión 'identUser' para la 'cita' a modificar y actualizar.
            $_SESSION['identUser'] = $userCita;
            // declaro la variable de sesión 'idUserGo' para volver del proceso de la 'cita' a modificar y actualizar.
            $_SESSION['idUserGo'] = 1;
        }

        // validar fecha cita.
        if (isset($_POST['submitActualizarCitaAdmin'])) {
            $valRegistro = SQL::ValidarActualizarCita();
        }
    ?>
    <main>
        <!-- formulario actualizar citas -->
        <div class="containAll flex">
            <div class="container">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Modificar Cita</h2>
                        </div>
                        <div>
                            <div class="btnCerrarCitas flex">
                                <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                            </div>
                        </div>
                    </div>
                    <div class="containerInputs">
                        <?php
                            // Obtengo la cita del 'usuario', a traves de su 'idUser' y la fecha.
                            $ResultCitas =  [];
                            $ResultCitas = SQL::obtenerFechasCita($userCita, $mostrarCitas);
                            
                            // Si hay resultados.
                            if ($ResultCitas) {
                                // Recorro el array de citas para introducirlas en el formulario.
                                foreach($ResultCitas as $value) {
                        ?>
                                    <input type="hidden" name="actualizarCitaId" value="<?php echo $value->idCita ?>">
                                    <label class="colorLabel">* Fecha cita:</label>
                                    <input type="date" name="nuevaFechaCita" value="<?php echo $value->fecha_cita ?>">
                                    <br><br>
                                    <div class="separadorCitas"></div>
                                    <label class="colorLabel">Fecha cita</label>
                                    <input type="date" name="fechaActualizarCita" value="<?php echo $value->fecha_cita ?>" readonly>
                                    <label class="colorLabel">Motivo de la cita</label>
                                    <div>
                                        <textarea name="textActualizarCita" cols="39" rows="5"><?php echo $value->motivo_cita ?></textarea>
                                    </div>
                                    <input type="submit" name="submitActualizarCitaAdmin" value="Actualizar Cita" class="outlineColor">
                        <?php
                                }
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>