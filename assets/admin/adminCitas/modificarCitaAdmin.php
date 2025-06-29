<?php
    require_once __DIR__ . '/../../archivosPHP/SQL.php';
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
        if (isset($_GET['rUmC'])) {
            $hashBuscado = $_GET['rUmC'];
            $idsUsuarios = SQL::obteneridUsersCitas();
            $userCita = ''; // inicializa fuera del foreach
            foreach ($idsUsuarios as $idUser) {
                if (md5($idUser) === $hashBuscado) {
                    $userCita = $idUser;
                    break;
                }
            }
        }
        // validar fecha cita.
        if (isset($_POST['submitActualizarCitaAdmin'])) {
            $resultadoValidacion = SQL::validarActualizarCita();
            if (is_array($resultadoValidacion)) {
                // La validación fue exitosa, devuelve los datos y modifica el registro
                list($idCita, $nuevaFechaCita, $textActualizarCita) = $resultadoValidacion;
                $returnOk = SQL::modificarCita($idCita, $nuevaFechaCita, $textActualizarCita);
                if ($returnOk) {
                    // Si el registro fue éxitoso redirecciona a la página de origen del crud con un mensaje de confirmación
                    header('location:citas_administracion.php?msgConfirm=Cita Actualizada&tareaAdmin=verCitasAdmin');
                    exit();
                }
            } else {
                // La validación falló, muestra el mensaje de error.
                $valRegistro = $resultadoValidacion;
            }
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