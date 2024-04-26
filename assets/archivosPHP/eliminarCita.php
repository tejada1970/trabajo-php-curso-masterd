<?php
  include('../assets/archivosPHP/SQL.php');
  $valRegistro = null;
  $fechaEliminacion = null;
  $msgConfirm = null;
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
<body onload="abrirModalDelete();">

    <!-- este 'div' es solo para que ocupe todo el body y el 'mensaje' me salga en el centro -->
    <div class="relleno imgFondo"></div>

    <?php
        // recogo 'fecha' para eliminar 'cita'.
        if (isset($_GET['recogerFechaCita'])) {
            $valRegistro = $_GET['recogerFechaCita'];
        }

        // envio la cita a eliminar.
        if (isset($_GET['eliminación'])) {

            if ($_GET['eliminación'] === 'true') {
                $fechaEliminacion = $_SESSION['selectDeleteCita'];
                $idUsuario = $_SESSION['idUser'];
                SQL::eliminarCita($idUsuario, $fechaEliminacion);
            }
        }
    ?>
    <dialog class="animate__animated animate__backInDown" id="modalDelete">
        <div class="confirmDelete">
            <p>¿ Deseas anular definitivamente la cita del: <?php echo $valRegistro; ?> ?</p>
            <div class="confirmDelete_btn">
                <a href="citaciones.php?eliminación=true&tarea=eliminar" class="btnModalDelete btnAccept" id="btnAccept">Aceptar</a> 
                <a href="citaciones.php?msgConfirm=Anulación cancelada&tarea=verCitas" class="btnModalDelete btnCancel" id="btnCancel">Cancelar</a>
            </div>
        </div>
    </dialog>

    <!-- scripts -->
    <script src="../scripts/msgDelete.js"></script>
</body>
</html>