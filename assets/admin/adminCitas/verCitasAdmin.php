<?php
    require_once __DIR__ . '/../../archivosPHP/SQL.php';

    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrf_token = $_SESSION['csrf_token'];

    if (isset($_GET['msgConfirm'])) {
        require_once __DIR__ . '/../../archivosPHP/messages.php';
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bulma.min.css">
    <script>
        const CSRF_TOKEN = '<?php echo $csrf_token; ?>';
    </script>
</head>
<body class="imgFondo">
    <div class="containerAllTable">
        <div class="containerTable">
            <div class="containerTitleH2 flexRow nonWrap gap10">
                <div>
                    <h2>Tabla Citas</h2>
                </div>
                <div>
                    <div class="btnAgregar">
                        <a href="citas_administracion.php?tareaAdmin=insertarCitaAdmin" class="btnTable btnInsert">Agregar</a>
                    </div>
                </div>
            </div>
            <div class="divTable">
                <table id="tableCitasAdmin" class="table">
                    <thead>
                        <tr scope="row">
                            <th class="pl-6 pr-6" scope="col">idUser</th>
                            <th class="pl-6 pr-6" scope="col">fecha_cita</th>
                            <th class="pl-6 pr-6" scope="col">motivo_cita</th>
                            <th class="pl-6 pr-6" scope="col">Editar</th>
                            <th class="pl-6 pr-6" scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtengo y muestro todas las 'citas' en la tabla
                        $resultado = SQL::obtenerCitasAdmin();          
                        if ($resultado) {
                            foreach ($resultado as $value) {
                        ?>
                        <tr scope="row">
                            <td><?php echo $value->idUser ?></td>
                            <td><?php echo $value->fecha_cita ?></td>
                            <td class="has-text-left"><?php echo $value->motivo_cita ?></td>
                            <td><a href="citas_administracion.php?fecha=<?php echo $value->fecha_cita ?>&rUmC=<?php echo md5($value->idUser) ?>&tareaAdmin=modificarCitaAdmin" class="btnTable btnEdit">Editar</a></td>
                            <td><a href="#" class="btnEliminar btnTable btnDelete" data-from="verCitasAdmin" data-dato="<?php echo $value->idCita; ?>" data-redirect="citas_administracion.php">Eliminar</a></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr scope="row">
                            <th colspan="5">Fin Tabla</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Modal de confirmación para eliminar registros -->
        <dialog id="modalDelete" class="animate__animated animate__backInDown">
            <div class="confirmDelete">
                <p>¿Deseas eliminar definitivamente el registro seleccionado?</p>
                <div class="confirmDelete_btn">
                    <button id="btnConfirmDelete" class="btnModalDelete btnAccept">Aceptar</button>
                    <button id="btnCancel" class="btnModalDelete btnCancel">Cancelar</button>
                </div>
            </div>
        </dialog>
    </div>
    <!-- scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bulma.min.js"></script>
    <script src="../scripts/tableBulma.js"></script>
    <script src="../scripts/msgDelete.js"></script>
</html>