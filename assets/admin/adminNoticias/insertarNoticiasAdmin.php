<?php
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
            if (isset($_POST['submitInsertNoticiaAdmin'])) {
                // guardar datos 'textNoticia' y 'titulo'.
                $_SESSION['textNoticia'] = $_POST['textInsertNoticiaAdmin'];
                $_SESSION['titulo'] = $_POST['tituloInsertNoticiaAdmin'];
                $resultadoValidacion = SQL::validarInsertNoticiasAdmin();
                if ($resultadoValidacion === true) {
                    // Registro exitoso
                    header('location:noticias_administracion.php?msgConfirm=Noticia Agregada&tareaAdmin=verNoticiasAdmin');
                    exit();
                } else {
                    // La validación falló, muestra el mensaje de error.
                    $valRegistro = $resultadoValidacion;
                } 
            }
        ?>
        <!-- formulario insertar noticias admin -->
        <div class="containAll flex">
            <div class="container">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos" enctype="multipart/form-data">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Agregar Noticia</h2>
                        </div>
                        <div>
                            <div class="btnCerrarNoticias flex">
                                <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                            </div>
                        </div>
                    </div>
                    <div class="containerInputs">
                        <input type="hidden" value="<?php echo $_SESSION["idUser"] ?>" name="idUserInsertNoticiaAdmin">
                        <label for="tituloInsertNoticiaAdmin" class="colorLabel">* Titulo</label>
                        <input type="text" id="tituloInsertNoticiaAdmin" value="<?php echo $_SESSION['titulo'] ?? '' ?>" name="tituloInsertNoticiaAdmin">
                        <label for="imagenInsertNoticiaAdmin" class="colorLabel">* Imagen</label>
                        <input type="file" class="form-control-file inputFile" id="imagenInsertNoticiaAdmin" name="foto">
                        <label for="textInsertNoticiaAdmin" class="colorLabel">* Texto</label>
                        <div>
                            <textarea name="textInsertNoticiaAdmin" id="textInsertNoticiaAdmin" cols="35" rows="5"><?php echo $_SESSION['textNoticia'] ?? '' ?></textarea>
                        </div>
                        <label for="fechaInsertNoticiaAdmin" class="colorLabel">* Fecha</label>
                        <input type="date" id="fechaInsertNoticiaAdmin" name="fechaInsertNoticiaAdmin">
                        <div>
                            <input type="submit" name="submitInsertNoticiaAdmin" value="Agregar Noticia" class="outlineColor">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>