<?php
    include('SQL.php');
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
    <main>
        <?php
            // validar datos del formulario.
            if (isset($_POST['submitCita'])) {
                // guardar dato 'textCita'.
                $_SESSION['textCita'] = $_POST['textCita'];
                $resultadoValidacion = SQL::validarInsertCita();
                if (is_array($resultadoValidacion)) {
                    // La validación fue exitosa, devuelve los datos y guarda el registro
                    list($idUsuario, $fechaCita, $motivoCita) = $resultadoValidacion;
                    $returnOk = SQL::insertarCita($idUsuario, $fechaCita, $motivoCita);
                    if ($returnOk) {
                        // Si el registro fue éxitoso redirecciona a la página de origen del crud con un mensaje de confirmación
                        header('location:citaciones.php?msgConfirm=Nueva cita creada&tarea=tareas');
                        exit();
                    }
                } else {
                    // La validación falló, muestra el mensaje de error.
                    $valRegistro = $resultadoValidacion;
                }
            }
        ?>
        <!-- formulario insertar citas user -->
        <div class="container">
            <div class="animate__animated animate__backInDown">
                <p class="validarDatos"><?php echo $valRegistro; ?></p>
            </div>
            <form action="#" method="post" name="datos">
                <div class="containerFraseH2 flex">
                    <h2>Agregar Cita</h2>
                    <div class="btnCerrar flex">
                        <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                    </div>
                </div>
                <div class="containerInputs">
                    <label for="fechaCita" class="colorLabel">* Fecha Cita: </label>
                    <input type="date" id="fechaCita" name="fechaCita">
                    <br>
                    <label for="textCita"><br>Motivo de la cita</label>
                    <div>
                        <textarea name="textCita" id="textCita" cols="39" rows="5"><?php echo $_SESSION['textCita'] ?? '' ?></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submitCita" value="Agregar Cita" class="outlineColor">
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>