<?php
  include('../assets/archivosPHP/SQL.php');
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
<body>
    <?php
        // validar datos del formulario.
        if (isset($_POST['submitBuscarCita'])) {

            if ($_POST['selectModCita'] === '0') {
                $valRegistro = 'no se ha seleccionado ninguna fecha';

            }else {
                $fechaCita = $_POST['selectModCita'];
                /**  Redireccionar al 'usuario' a la página 'citaciones.php'. para la actualización **/
                header('location:citaciones.php?recogerFechaCita='.$fechaCita.'&tarea=actualizar');
            }
        }
    ?>
    <main>
        <!-- formulario modificar citas -->
        <div class="container">
            <div class="animate__animated animate__backInDown">
                <p class="validarDatos"><?php echo $valRegistro; ?></p>
            </div>
            <form action="#" method="post" name="datos">
                <div class="containerFraseH2 flex">
                    <h2>Modificar Cita</h2>
                    <div class="btnCerrar flex">
                        <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                    </div>
                </div>
                <div class="containerInputs">
                    <div>
                        <br>
                        <label class="colorLabel">* Fecha Cita: </label>
                        <select name="selectModCita" id="selectModCita">
                            <option value="0">Selecciona una fecha:</option>
                            <?php
                            // Obtengo todas las citas del 'usuario de la sesión actual', a traves de su 'idUser'.
                            $SelectCitas =  [];
                            $SelectCitas = SQL::obtenerCitas($_SESSION['idUser']);

                            // Si hay resultados, introduzco solo la fechas en el 'select'.
                            if ($SelectCitas) {
                                foreach($SelectCitas as $key => $value) {
                                    echo '<option value="'.$value->fecha_cita.'">'.$value->fecha_cita.'</option>';
                                }
                            }
                            ?>
                        </select>
                        <input type="submit" name="submitBuscarCita" value="Buscar Cita" class="outlineColor">
                        <br><br>
                        <div class="separadorCitas"></div>
                    </div>
                    <?php
                        // Obtengo todas las citas del 'usuario de la sesión actual', a traves de su 'idUser'.
                        $ResultCitas =  [];
                        $ResultCitas = SQL::obtenerCitas($_SESSION['idUser']);
                        
                        // Si hay resultados.
                        if ($ResultCitas) {
                            // Recorro el array de citas para introducirlas en el formulario.
                            foreach($ResultCitas as $value) {
                    ?>
                                <br>
                                <label>Fecha Cita: </label>
                                <input type="date" name="fechaModCita" value="<?php echo $value->fecha_cita ?>" readonly>
                                <br>
                                <label><br>Motivo de la cita</label>
                                <div>
                                    <textarea name="textModCita" cols="10" rows="5" readonly><?php echo $value->motivo_cita ?></textarea>
                                </div>
                                <br>
                                <div class="separadorCitas"></div>
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