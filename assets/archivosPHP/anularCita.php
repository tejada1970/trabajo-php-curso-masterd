<?php
    include('../assets/archivosPHP/SQL.php');
    $valRegistro = null;
    $fechaEliminarCita = null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
        <link rel="stylesheet" href="../css/msgDelete.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <?php
        // validar datos del formulario.
        if (isset($_POST['submitAnularCita'])) {
            $fechaEliminarCita = $_POST['selectDeleteCita'];
            $idUsuario = $_SESSION['idUser'];
            $resultado = SQL::eliminarCita($idUsuario, $fechaEliminarCita);
            if ($resultado) {
                header('location:citaciones.php?msgConfirm=Cita anulada&tarea=tareasCitas');
                exit();
            } else {
                $valRegistro = $resultado;
            }
        }
    ?>
    <main>
        <!-- formulario anular citas -->
        <div class="container">
            <div class="animate__animated animate__backInDown">
                <p class="validarDatos"><?php echo $valRegistro; ?></p>
            </div>
            <form action="#" method="post" name="datos">
                <div class="containerFraseH2 flex">
                    <h2>Anular Cita</h2>
                    <div class="btnCerrar flex">
                        <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                    </div>
                </div>
                <div class="containerInputs">
                    <div>
                    <br>
                        <label class="colorLabel">* Fecha Cita: </label>
                        <select name="selectDeleteCita" id="selectDeleteCita">
                            <option value="0">Selecciona una fecha:</option>
                            <?php
                            // Obtengo todas las citas del 'usuario de la sesión actual', a traves de su 'idUser'.
                            $SelectDeleteCitas =  [];
                            $SelectDeleteCitas = SQL::obtenerCitas($_SESSION['idUser']);
                            // Si hay resultados, introduzco solo la fechas en el 'select'.
                            if ($SelectDeleteCitas) {
                                foreach($SelectDeleteCitas as $key => $value) {
                                    echo '<option value="'.$value->fecha_cita.'">'.$value->fecha_cita.'</option>';
                                }
                            }
                            ?>
                        </select>
                        <button type="button" class="danger" id="abrirModal">Anular cita</button>
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
                                <input type="date" name="fechaAnularCita" value="<?php echo $value->fecha_cita ?>" readonly>
                                <br>
                                <label><br>Motivo de la cita</label>
                                <div>
                                    <textarea name="textAnularCita" cols="10" rows="5" readonly><?php echo $value->motivo_cita ?></textarea>
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
        <dialog class="animate__animated animate__backInDown" id="modalDelete">
            <div class="confirmDelete">
                <p>¿Deseas anular definitivamente la cita del:<br/> <span id="fechaConfirmacion"></span>?</p>
                <div class="confirmDelete_btn">
                    <button class="btnModalDelete btnAccept" id="btnConfirmar">Aceptar</button> 
                    <button class="btnModalDelete btnCancel" id="btnCancelar">Cancelar</button>
                </div>
            </div>
        </dialog>
    </main>
    <script>
        const modal = document.getElementById('modalDelete');
        const btnAbrir = document.getElementById('abrirModal');
        const btnConfirmar = document.getElementById('btnConfirmar');
        const btnCancelar = document.getElementById('btnCancelar');
        const form = document.forms['datos'];
        const parrafoError = document.querySelector('.validarDatos');
        const spanFecha = document.getElementById('fechaConfirmacion');

        btnAbrir.addEventListener('click', () => {
            const seleccion = document.getElementById('selectDeleteCita').value;
            if (seleccion === "0") {
                // Mostrar el error directamente en el HTML
                parrafoError.textContent = 'Por favor, selecciona una fecha';
                return;
            }
            // Si todo está bien, borramos el error anterior y mostramos el modal
            parrafoError.textContent = '';
            spanFecha.textContent = seleccion; // esta es la fecha seleccionada del <select>
            modal.showModal();
        });

        btnCancelar.addEventListener('click', () => {
            modal.close();
            window.location.href = 'citaciones.php?msgConfirm=Anulación cancelada&tarea=tareasCitas';
        });

        btnConfirmar.addEventListener('click', () => {
            // Insertar un input hidden para simular que aceptó el modal
            const inputHidden = document.createElement('input');
            inputHidden.type = 'hidden';
            inputHidden.name = 'submitAnularCita';
            inputHidden.value = '1';
            form.appendChild(inputHidden);
            form.submit();
        });
    </script>
</body>
</html>