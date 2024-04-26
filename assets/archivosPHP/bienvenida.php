<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
    <link rel="stylesheet" href="./css/msgBienvenida.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body onload="abrirModalBienvenida();">
 
    <modal id="modalBienvenida">
        <div class="divBienvenida animate__animated animate__backInDown">
            <p class="bienvenida"><?php echo $_SESSION['nameUser']; ?></p>
            <button id="btnAceptBienvenida">Aceptar</button>
        </div>
    </modal>

    <!-- scripts -->
    <script src="./scripts/msgBienvenida.js"></script>
</body>
</html>