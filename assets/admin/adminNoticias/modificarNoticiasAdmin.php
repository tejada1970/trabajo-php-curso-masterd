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
            if (isset($_POST['submitModNoticiaAdmin'])) {
                $resultadoValidacion = SQL::validarModDatosNoticiasAdmin();
                if (is_array($resultadoValidacion)) {
                    // La validación fue exitosa, devuelve los datos y modifica el registro
                    list($idNoticia, $idUser, $titulo, $textoNoticia, $fechaNoticia) = $resultadoValidacion;
                    $returnOk = SQL::modificarDatosNoticiaAdmin($idNoticia, $idUser, $titulo, $textoNoticia, $fechaNoticia);
                    if ($returnOk) {
                        // Si el registro fue éxitoso redirecciona a la página de origen del crud con un mensaje de confirmación
                        header('Location: noticias_administracion.php?msgConfirm=Datos Actualizados&tareaAdmin=verNoticiasAdmin');
                        exit();
                    } else {
                        $valRegistro = 'Error al actualizar los datos.';
                    }
                } else {
                    // La validación falló, muestra el mensaje de error.
                    $valRegistro = $resultadoValidacion;
                }
            }
        ?>
        <!-- formulario modificar noticias admin -->
        <div class="containAll flex">
            <div class="container">
                <div class="animate__animated animate__backInDown">
                    <p class="validarDatos"><?php echo $valRegistro; ?></p>
                </div>
                <form action="#" method="post" name="datos">
                    <div class="containerTitleH2 flexRow nonWrap gap10">
                        <div>
                            <h2>Modificar Noticia</h2>
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
                        <input type="hidden" value="<?php echo $resultado[0]->idNoticia ?>" name="idModNoticiaAdmin">
                        <input type="hidden" value="<?php echo $resultado[0]->idUser ?>" name="idUserModNoticiaAdmin">
                        <label for="tituloModNoticiaAdmin" class="colorLabel">* Titulo</label>
                        <input type="text" id="tituloModNoticiaAdmin" value="<?php echo $resultado[0]->titulo ?>" name="tituloModNoticiaAdmin">
                        <label for="textModNoticiaAdmin" class="colorLabel">* Texto</label>
                        <div>
                            <textarea name="textModNoticiaAdmin" id="textModNoticiaAdmin" cols="35" rows="5"><?php echo $resultado[0]->texto ?></textarea>
                        </div>
                        <label for="fechaModNoticiaAdmin" class="colorLabel">* Fecha</label>
                        <input type="date" id="fechaModNoticiaAdmin" value="<?php echo $resultado[0]->fecha_noticia ?>" name="fechaModNoticiaAdmin">
                        <div>
                            <input type="submit" name="submitModNoticiaAdmin" value="Actualizar Noticia" class="outlineColor">
                        </div>
                    </div>
                    <?php
                        } 
                    ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>