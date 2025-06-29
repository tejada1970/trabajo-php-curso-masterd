<?php
    if (isset($_SESSION['usuario'])) {
        if(isset($_SESSION['rol'])){
            if ($_SESSION['rol'] === 'admin') {
                $_SESSION['userCitaAdmin'] = $_SESSION['idUser'];
            }
        }
    }
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
            // validar datos del formulario.
            if (isset($_POST['submitCitaAdmin'])) {
                // guardar datos 'userCitaAdmin' y 'textCitaAdmin'.
                $_SESSION['userCitaAdmin'] = $_POST['userCitaAdmin'];
                $_SESSION['textCitaAdmin'] = $_POST['textCitaAdmin'];
                $resultadoValidacion = SQL::validarInsertCitaAdmin();
                if (is_array($resultadoValidacion)) {
                    // La validación fue exitosa, devuelve los datos y guarda el registro
                    list($idUsuario, $fechaCita, $motivoCita) = $resultadoValidacion;
                    $returnOk = SQL::insertarCita($idUsuario, $fechaCita, $motivoCita);
                    if ($returnOk) {
                        // Si el registro fue éxitoso redirecciona a la página de origen del crud con un mensaje de confirmación
                        header('location:citas_administracion.php?msgConfirm=Nueva cita creada&tareaAdmin=verCitasAdmin');
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
            <div class="container">
                <div>
                    <p></p>
                </div>
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Agregar Cita</h2>
                        </div>
                        <div>
                            <div class="btnCerrarCitas flex">
                                <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                            </div>
                        </div>
                    </div>
                    <div class="containerInputs">
                        <label for="userCitaAdmin" class="colorLabel">* ID-User</label>
                        <input type="text" id="userCitaAdmin" value="<?php echo $_SESSION['userCitaAdmin'] ?? '' ?>" name="userCitaAdmin">
                        <label for="fechaCitaAdmin" class="colorLabel">* Fecha Cita</label>
                        <input type="date" id="fechaCitaAdmin" name="fechaCitaAdmin">
                        <label for="textCitaAdmin" class="colorLabel">Motivo de la cita</label>
                        <div>
                            <textarea name="textCitaAdmin" id="textCitaAdmin" cols="39" rows="5"><?php echo $_SESSION['textCitaAdmin'] ?? '' ?></textarea>
                        </div>
                        <div>
                            <input type="submit" name="submitCitaAdmin" value="Agregar Cita" class="outlineColor">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>