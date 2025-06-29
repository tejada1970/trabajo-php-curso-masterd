<?php
    require_once __DIR__ . '/../../archivosPHP/SQL.php';
    $valRegistro = null;
    $recogerTitulo = null;
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
            // recogo el 'titulo' de la noticia para mostrar la 'noticia' a modificar y actualizar.
            if (isset($_GET['recogerTitulo'])) {
                $recogerTitulo = $_GET['recogerTitulo'];
            }
            // validar datos del formulario.
            if (isset($_POST['submitModImgNoticiaAdmin'])) {
                $resultadoValidacion = SQL::validarModImgNoticiasAdmin();
                if ($resultadoValidacion) {
                    // Si el registro fue éxitoso redirecciona a la página de origen del crud con un mensaje de confirmación
                    header('location:noticias_administracion.php?msgConfirm=Imagen Actualizada&tareaAdmin=verNoticiasAdmin');
                    exit();
                }
            }
        ?>
        <!-- formulario modificar 'img' (foto) noticias admin -->
        <div class="containAll flex">
            <div class="container">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos" enctype="multipart/form-data">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Modificar Foto Noticia</h2>
                        </div>
                        <div>
                            <div class="btnCerrarNoticias flex">
                                <a href="#"><img src="../assets/icons/left-long-solid.svg" alt="icono_back" class="icon"></a>
                            </div>
                        </div>
                    </div>
                    <?php
                        // Obtengo la 'noticia' del registro seleccionado a traves del 'titulo' de la 'noticia'.
                        $resultado = [];
                        $resultado = SQL::obtenerNoticia($recogerTitulo);
                        if ($resultado > 0) {
                    ?>
                    <div class="containerInputs">
                        <input type="hidden" value="<?php echo $resultado[0]->titulo ?>" name="tituloModImgNoticiaAdmin">
                        <div>
                            <img id="previewImg" width="100" src="data:<?php echo $resultado[0]->tipo ?>;base64,<?php echo base64_encode($resultado[0]->imagen);?>" alt="imgNoticiasAdmin">
                        </div>
                        <label for="modImgNoticiaAdmin" class="colorLabel">* Imagen</label>
                        <input type="file" class="form-control-file inputFile" id="modImgNoticiaAdmin" name="foto">
                        <div>
                            <input type="submit" name="submitModImgNoticiaAdmin" value="Actualizar Foto" class="outlineColor">
                        </div>
                    </div>
                    <?php
                        } 
                    ?>
                </form>
            </div>
        </div>
    </main>
    <!-- script -->
    <script>
        const inputFile = document.getElementById('modImgNoticiaAdmin');
        const previewImg = document.getElementById('previewImg');

        inputFile.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validar tipo mime
                if (!file.type.startsWith('image/')) {
                    alert('Por favor, selecciona un archivo de imagen válido (jpg o png).');
                    this.value = ''; // limpiar input para que no quede ese archivo inválido seleccionado
                    // NO cambiar previewImg.src para mantener la imagen actual
                    return;
                }
                // Si es válido, cargar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>