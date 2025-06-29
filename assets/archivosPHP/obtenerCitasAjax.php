<?php
    session_start();

    include('SQL.php');

    // Obtengo las citas para pasarselas al objeto 'Ajax' en (cargarCitas.js).
    $idUsuario = $_SESSION['idUser'];
    $ResultCitas =  [];
    $ResultCitas = SQL::obtenerCitas($idUsuario);
   
    foreach($ResultCitas as $value) {
        echo $value->fecha_cita.' '.$value->motivo_cita.'separador';
    }
?>