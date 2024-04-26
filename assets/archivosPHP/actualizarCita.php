<?php
  include('../assets/archivosPHP/SQL.php');
  $valRegistro = null;
  $mostrarCitas = null;
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
<body>
    <?php
        // declaro la variable de sesión 'identUser' para la 'cita' a modificar y actualizar.
        $_SESSION['identUser'] = $_SESSION['idUser'];

        // recogo 'fecha' para mostrar la 'cita' a modificar y actualizar.
        if (isset($_GET['recogerFechaCita'])) {
            $mostrarCitas = $_GET['recogerFechaCita'];
        }

        // validar fecha cita.
        if (isset($_POST['submitActualizarCita'])) {
            $valRegistro = SQL::ValidarActualizarCita();
        }
    ?>
    <main>
        <!-- formulario actualizar citas -->
        <div class="container">
            <div class="animate__animated animate__backInDown">
                <p class="validarDatos"><?php echo $valRegistro; ?></p>
            </div>
            <form action="#" method="post" name="datos">
                <div class="containerFraseH2 flex">
                    <h2>Actualizar Cita</h2>
                    <div class="btnCerrar flex">
                        <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                    </div>
                </div>
                <div class="containerInputs">
                    <?php
                        // Obtengo la cita del 'usuario de la sesión actual', a traves de su 'idUser' y la fecha.
                        $idUsuario = $_SESSION['idUser'];
                        $ResultCitas =  [];
                        $ResultCitas = SQL::obtenerFechasCita($idUsuario, $mostrarCitas);
                        
                        // Si hay resultados.
                        if ($ResultCitas) {
                            // Recorro el array de citas para introducirlas en el formulario.
                            foreach($ResultCitas as $value) {
                    ?>
                                <input type="hidden" name="actualizarCitaId" value="<?php echo $value->idCita ?>">
                                <label class="colorLabel">* Fecha cita:</label>
                                <input type="date" name="nuevaFechaCita" value="<?php echo $value->fecha_cita ?>">
                                <br>
                                <div class="separadorCitas"></div>
                                <label>Fecha Cita: </label>
                                <input type="date" name="fechaActualizarCita" value="<?php echo $value->fecha_cita ?>" readonly>
                                <br>
                                <label><br>Motivo de la cita</label>
                                <div>
                                    <textarea name="textActualizarCita" cols="39" rows="5"><?php echo $value->motivo_cita ?></textarea>
                                </div>
                                <input type="submit" name="submitActualizarCita" value="Actualizar Cita" class="outlineColor">
                    <?php
                            }
                        }
                    ?>
                </div>
            </form>
        </div>
    </main>
</body>
</html>