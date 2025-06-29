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
<body onload="cargarCitas();">
    <main>
        <?php
            // muestra una confirmación al 'usuario'.
            $valRegistro = null;
            if (isset($_GET['msgConfirm'])) {
                $valRegistro = $valRegistro;
            }
        ?>
        <!-- formulario para mostrar las citas con 'Ajax' -->
        <div class="container containerVerCitas">
            <div class="animate__animated animate__backInDown">
                <p class="validarDatos msgCitas"><?php echo $valRegistro; ?></p>
            </div>
            <form action="#" method="post" name="datos">
                <div class="containerFraseH2 flex">
                    <h2>Proximas Citas</h2>
                    <div class="btnCerrar flex">
                        <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                    </div>
                </div>
                <div class="containerInputs">
                    <table class="flex">
                        <tr>
                            <td id="tdCita" class="separadorCitas"></td>
                            <div class="separadorCitas2"></div>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </main>
</body>
</html>