<?php
  include('../assets/archivosPHP/SQL.php');
  $recogerDato = null;
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
<body class="imgFondo" onload="abrirModalDelete();">

    <!-- este 'div' es solo para que ocupe todo el body y el 'mensaje' me salga en el centro -->
    <div class="relleno imgFondo"></div>

    <?php
        //  Obtengo el 'idUser encryptado con md5' pasado por 'url' desde verUsersAdmin.php.
        if (isset($_GET['rUmCa'])) {
            $_SESSION['userAdmin'] = $_GET['rUmCa'];
        }

        //  Obtengo el 'idUser encryptado con md5' pasado por 'url' desde verCitasAdmin.php.
        if (isset($_GET['rUmC'])) {
            $_SESSION['userCita'] = $_GET['rUmC'];
        }

        /* Obtengo el 'dato' pasado por 'url' desde verUsersAdmin.php, verNoticiasAdmin.php o verCitasAdmin.php */
        if (isset($_GET['recogerDato'])) {
            $_SESSION['recogerDato'] = $_GET['recogerDato'];
        }

        // envio el registro seleccionado a eliminar.
        if (isset($_GET['eliminar'])) {

            if ($_SESSION['delRegistro'] == 'noticiaAdmin') {
                $recogerDato = $_SESSION['recogerDato'];
                SQL::eliminarNoticiaAdmin($recogerDato);
            }

            if ($_SESSION['delRegistro'] == 'citaAdmin') {
                /*
                    - Guardo en la variable '$userCita' el 'idUser encryptado con md5' pasado por 'url' desde verCitasAdmin.php.
                    - Luego, obtengo todos los 'idUser' de la tabla 'citas', recorro el array y cada valor
                        lo convierto en string.
                    - A continuación, creo un 'if' para comparar cada valor del array con la encryptación.
                    - Por ultimo, el valor que coincide, me lo guarda en la variable de sesión $_SESSION['numUser'],
                        que a su vez guarda el valor en la variable '$userCita', donde la utilizaré para eliminar
                        la 'cita' del usuario enviado por url.
                */
                $userCita = $_SESSION['userCita'];
                $_SESSION['numUser'] = '';
                $idUser = '';
                $array = array();
                $users = [];
                $users = SQL::obteneridUsersCitas();
                foreach($users as $value) {
                    $array = array($value->idUser);
                    $idUser = implode(",", $array);
                    if (md5($idUser) === $userCita) {
                        $_SESSION['numUser'] = $idUser;
                    }
                }
                $userCita = $_SESSION['numUser'];
                $recogerDato = $_SESSION['recogerDato'];
                SQL::eliminarCitaAdmin($userCita, $recogerDato);
            }

            if ($_SESSION['delRegistro'] == 'usersAdmin') {
                /* Obtengo el 'idUser encryptado con md5' pasado por 'url' desde verUsersAdmin.php. */
                $userAdmin = $_SESSION['userAdmin'];
                $_SESSION['numUserAdmin'] = '';
                $idUser = '';
                $array = array();
                $users = [];
                $users = SQL::obtenerIdUsersAdmin();
                foreach($users as $value) {
                    $array = array($value->idUser);
                    $idUser = implode(",", $array);
                    if (md5($idUser) === $userAdmin) {
                        $_SESSION['numUserAdmin'] = $idUser;
                    }
                }
                $userAdmin = $_SESSION['numUserAdmin'];
                SQL::eliminarUserAdmin($userAdmin);
            }
        }

        // redirecciono al 'usuario' a la 'tabla' correspondiente.
        if (isset($_GET['cancel'])) {

            if ($_SESSION['cancel'] == 'verNoticiasAdmin') {
                header('location:noticias_administracion.php?msgConfirm=Operación cancelada&tareaAdmin=verNoticiasAdmin');
            }

            if ($_SESSION['cancel'] == 'verCitasAdmin') {
                header('location:citas_administracion.php?msgConfirm=Operación cancelada&tareaAdmin=verCitasAdmin');
            }

            if ($_SESSION['cancel'] == 'verUsersAdmin') {
                header('location:usuarios_administracion.php?msgConfirm=Operación cancelada&tareaAdmin=verUsersAdmin');
            }
        }
    ?>
    <!-- pongo 'noticias_administracion' en todos los 'a', porque el único 'objetivo' es que me devuelva a esta página otra vez -->
    <dialog class="animate__animated animate__backInDown" id="modalDelete">
        <div class="confirmDelete">
            <p>¿ Deseas eliminar definitivamente el registro seleccionado ?</p>
            <div class="confirmDelete_btn">
                <a href="noticias_administracion.php?eliminar=true&tareaAdmin=deleteAdmin" class="btnModalDelete btnAccept" id="btnAccept">Aceptar</a> 
                <a href="noticias_administracion.php?cancel=true&tareaAdmin=deleteAdmin" class="btnModalDelete btnCancel" id="btnCancel">Cancelar</a>
            </div>
        </div>
    </dialog>

    <!-- scripts -->
    <script src="../scripts/msgDelete.js"></script>
</body>
</html>