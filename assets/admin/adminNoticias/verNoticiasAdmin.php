<?php
    include('../assets/archivosPHP/SQL.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="trabajo obligatorio de PHP 'sobre un negocio ficticio de veterinaria' realizado durante el curso para desarrollo web en masterD">
    <title>Trabajo final PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bulma.min.css">

</head>
<body class="imgFondo">
    <?php
        // declaro la variable de sesión 'delRegistro' para la 'noticia' a eliminar (deleteAdmin.php).
        $_SESSION['delRegistro'] = 'noticiaAdmin';

        // declaro la variable de sesión 'cancel' para volver a la 'tabla' correspondiente (deleteAdmin.php).
        $_SESSION['cancel'] = 'verNoticiasAdmin';

        // muestra una confirmación al 'usuario'.
        if (isset($_GET['msgConfirm'])) {
            include('../assets/archivosPHP/messages.php');
            $_GET['msgConfirm'] = '';
        }       
    ?>
    <div class="containerAllTable">
        <div class="containerTable">
            <div class="containerTitleH2 flexRow nonWrap gap10">
                <div>
                    <h2>Tabla Noticias</h2>
                </div>
                <div>
                    <div class="btnAgregar">
                        <a href="noticias_administracion.php?tareaAdmin=insertarNoticiasAdmin" class="btnTable btnInsert">Agregar</a>
                    </div>
                </div>
            </div>
            <div class="divTable">
                <table id="tableNoticiasAdmin" class="table">
                    <thead>
                        <tr scope="row">
                            <th class="pl-6 pr-6" scope="col">idUser</th>
                            <th class="pl-6 pr-6" scope="col">título</th>
                            <th class="pl-6 pr-6" scope="col">imagen</th>
                            <th class="pl-6 pr-6" scope="col">texto</th>
                            <th class="pl-6 pr-6" scope="col">fecha_noticia</th>
                            <th class="pl-6 pr-6" scope="col">editFoto</th>
                            <th class="pl-6 pr-6" scope="col">editData</th>
                            <th class="pl-6 pr-6" scope="col">delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtengo y muestro todas las 'noticias' de la tabla 'noticias'.
                        $resultado = SQL::obtenerNoticiasAdmin();  
                        if ($resultado) {
                            foreach ($resultado as $value) {
                        ?>
                        <tr scope="row">
                            <td><?php echo $value->idUser ?></td>
                            <td class="has-text-left"><?php echo $value->titulo ?></td>
                            <td><img src="data:<?php echo $value->tipo ?>;base64,<?php echo base64_encode($value->imagen) ?>" alt="imgNoticiasAdmin"></td>
                            <td class="has-text-left"><?php echo $value->texto ?></td>
                            <td><?php echo $value->fecha_noticia ?></td>
                            <td><a href="noticias_administracion.php?recogerTitulo=<?php echo $value->titulo ?>&tareaAdmin=modificarImgNoticiasAdmin" class="btnTable btnEdit">EditFoto</a></td>
                            <td><a href="noticias_administracion.php?recogerTitulo=<?php echo $value->titulo ?>&tareaAdmin=modificarNoticiasAdmin" class="btnTable btnEdit">EditData</a></td>
                            <td><a href="noticias_administracion.php?recogerDato=<?php echo $value->titulo ?>&tareaAdmin=deleteAdmin" class="btnTable btnDelete">Delete</a></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr scope="row">
                            <th colspan="8">Fin Tabla</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- escripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bulma.min.js"></script>
    <script src="../scripts/tableBulma.js"></script>
</body>
</html>