<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
    <link rel="stylesheet" href="../css/messages.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body onload="abrirModal();">
    <?php
        // Muestra un confirmación al 'usuario'.
        $msgConfirm = null;
        if (isset($_GET['msgConfirm'])) {
            $msgConfirm = $_GET['msgConfirm'];
        }
    ?>
    <dialog class="animate__animated animate__backInDown" id="modal">
        <div class="divMsg">
            <p class="confirmDatos"><?php echo $msgConfirm; ?></p>
            <button id="btnAceptarMsg">Aceptar</button>
        </div>
    </dialog>

    <!-- scripts -->
    <script src="../scripts/messages.js"></script>
</body>
</html>