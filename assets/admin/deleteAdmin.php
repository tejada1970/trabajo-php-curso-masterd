<?php
    session_start();
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($_SESSION['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Token CSRF inválido']);
        exit;
    }

    if (isset($input['eliminar']) && $input['eliminar'] === true) {
        
        require_once '../archivosPHP/SQL.php';

        switch ($input['from']) {
            case 'verNoticiasAdmin':
                SQL::eliminarNoticiaAdmin($input['dato']);
                break;
            case 'verCitasAdmin':
                SQL::eliminarCitaAdmin((int) $input['dato']);
                break;
            case 'verUsersAdmin':
                SQL::eliminarUserAdmin((int) $input['dato']);
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Origen inválido']);
                exit;
        }

        echo json_encode(['success' => true]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Parámetros inválidos']);
?>