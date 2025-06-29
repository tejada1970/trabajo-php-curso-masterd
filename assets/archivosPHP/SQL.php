<?php
include('DB.php');

class SQL {
    /*
        Recoger datos del formulario (registro.php).
    */
    public static function validarRegistro() {
        try {
            // Comprobar mediante una expresión regular, el 'email' recibido.
            $expresionEmail = "/\w+@\w+\.+[a-z]/";
        
            // Comprobar mediante una expresión regular, el 'telefono' recibido.
            $expresionTelf = "/^([0-9]{9})$/";
        
            /* Comprobar que los campos obligatorios contienen datos y que no superen la longitud de caracteres especificada. */
            if (empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['email']) || 
                empty($_POST['telefono']) || empty($_POST['birthday']) || empty($_POST['usuario']) || 
                empty($_POST['password'])) {
                
                return 'los campos marcados ( * ) son obligatorios';
        
            }elseif (strlen($_POST['nombre'])>30) {
                return 'el nombre: no debe superar 30 caracteres';
            }
            elseif (strlen($_POST['apellidos'])>60) {
                return 'los apellidos: no deben superar 60 caracteres';
            }
            elseif(!preg_match($expresionEmail, $_POST['email'])) {
                return 'el email no es valido';
            }
            elseif (strlen($_POST['email'])>100) {
                return 'el email: no debe superar 100 caracteres';
            }
            elseif (!preg_match($expresionTelf, $_POST['telefono'])) {
                return 'el telefono: debe ser de 9 caracteres numericos';
            }
            elseif (strlen($_POST['direccion'])>100) {
                return 'la direccion: no debe superar 100 caracteres';
            }
            elseif (strlen($_POST['usuario'])>50) {
                return 'la direccion: no debe superar 100 caracteres';
            }
            else {
                // Compruebo si la fecha es mayor que la actual.
                $milisegundos = round(microtime(true) * 1000); // obtener la 'fecha actual' en milisegundos.
                $milisegundosCita = strtotime($_POST['birthday']) * 1000; // obtener la 'birthday' en milisegundos.
    
                if ($milisegundosCita > $milisegundos) {
                    return 'la fecha: no puede ser mayor a la actual';
                }
                else {
                    // Comprueba si existe 'EMAIL' en la base de datos.
                    $email = $_POST['email'];
                    $resultado = SQL::comprobarEmail($email);
                    if (count($resultado)>0) {
                        return 'el email "'.$email.'" ya esta registrado';
                    }
                    
                    // Comprueba si existe 'USUARIO' en la base de datos.
                    $usuario = $_POST['usuario'];
                    $resultado = SQL::comprobarUsuario($usuario);
                    if (count($resultado)>0) {
                        return 'el usuario "'.$usuario.'" ya esta registrado';
                    }

                    // Introducir todos los datos recogidos en sus respectivas variables.
                    $nombre = htmlspecialchars($_POST['nombre']);
                    $apellidos = htmlspecialchars($_POST['apellidos']);
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $telefono = htmlspecialchars($_POST['telefono']);
                    $fecha_nacimiento = htmlspecialchars($_POST['birthday']);
            
                    // Dirección
                    if ($_POST['direccion'] === '') {
                        $direccion = null;
                    }
                    else {
                        $direccion = htmlspecialchars($_POST['direccion']);
                    }
            
                    // Sexo
                    if ($_POST['sexo'] === '') {
                        $sexo = null;
                    }
                    else {
                        $sexo = htmlspecialchars($_POST['sexo']);
                    }
            
                    $usuario = htmlspecialchars($_POST['usuario']);
                    $password = htmlspecialchars($_POST['password']);

                    // Enviar los datos a insertarUsuario() para su inserción en la base de datos.
                    SQL::insertarUsuario($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password);
                }
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (insertarUserAdmin.php).
    */
    public static function validarRegistroAdmin() {
        try {
            // Expresiones para validar
            $expresionTelefono = "/^\d{9}$/";

            // Campos obligatorios
            $camposObligatorios = ['nombre', 'apellidos', 'email', 'telefono', 'birthday', 'usuario', 'password', 'rol'];
            foreach ($camposObligatorios as $campo) {
                if (empty($_POST[$campo])) {
                    return 'Los campos marcados ( * ) son obligatorios';
                }
            }

            // Longitudes máximas
            if (strlen($_POST['nombre']) > 30) return 'El nombre no debe superar 30 caracteres';
            if (strlen($_POST['apellidos']) > 60) return 'Los apellidos no deben superar 60 caracteres';
            if (strlen($_POST['email']) > 100) return 'El email no debe superar 100 caracteres';
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) return 'El email no es válido';
            if (!preg_match($expresionTelefono, $_POST['telefono'])) return 'El teléfono debe ser de 9 dígitos numéricos';
            if (strlen($_POST['direccion'] ?? '') > 100) return 'La dirección no debe superar 100 caracteres';
            if (strlen($_POST['usuario']) > 50) return 'El usuario no debe superar 50 caracteres';

            // Fecha de nacimiento no futura
            $fechaNacimiento = strtotime($_POST['birthday']);
            if ($fechaNacimiento === false || $fechaNacimiento > time()) {
                return 'La fecha no puede ser mayor a la actual';
            }

            // Rol válido
            $rol = $_POST['rol'];
            if (!in_array($rol, ['user', 'admin'])) return 'El rol debe ser "user" o "admin"';

            // Email único
            $email = $_POST['email'];
            $resultado = SQL::comprobarEmail($email);
            if ($resultado !== false && count($resultado) > 0) {
                return 'El email "' . $email . '" ya está registrado';
            }

            // Usuario único
            $usuario = $_POST['usuario'];
            $resultado = SQL::comprobarUsuario($usuario);
            if ($resultado !== false && count($resultado) > 0) {
                return 'El usuario "' . $usuario . '" ya está registrado';
            }

            // Recolectar datos limpios
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $telefono = htmlspecialchars($_POST['telefono']);
            $direccion = !empty($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : null;
            $sexo = !empty($_POST['sexo']) ? htmlspecialchars($_POST['sexo']) : null;
            $usuario = htmlspecialchars($_POST['usuario']);
            $password = $_POST['password']; // ⚠️ no aplicar htmlspecialchars a contraseñas
            
            return [$nombre, $apellidos, $email, $telefono, date('Y-m-d', $fechaNacimiento), $direccion, $sexo, $usuario, $password, $rol];

        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (login.php).
    */
    public static function validarLogin() {
        try {
            // Comprobar que todos los campos contienen datos.
            if (empty($_POST['usuarioLogin']) || empty($_POST['passwordLogin'])) {
                return 'todos los campos son obligatorios';
            }else {
                $usuarioLogin = htmlspecialchars($_POST['usuarioLogin']);
                $passwordLogin = htmlspecialchars($_POST['passwordLogin']);

                // Enviar los datos a comprobarLogin() para su comprobación.
                SQL::comprobarLogin($usuarioLogin, $passwordLogin);
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (perfil.php).
    */
    public static function validarPerfil() {
        try {
            // Comprobar mediante una expresión regular, el 'email' recibido.
            $expresionEmail = "/\w+@\w+\.+[a-z]/";
        
            // Comprobar mediante una expresión regular, el 'telefono' recibido.
            $expresionTelf = "/^([0-9]{9})$/";
        
            // Comprobar que los campos obligatorios contienen datos y que no superen la longitud de caracteres especificada.
            if (empty($_POST['nombre']) || empty($_POST['apellidos']) || 
                empty($_POST['telefono']) || empty($_POST['birthday'])) {
                
                return 'los campos marcados ( * ) son obligatorios';
        
            }elseif (strlen($_POST['nombre'])>30) {
                return 'el nombre: no debe superar 30 caracteres';
            }
            elseif (strlen($_POST['apellidos'])>60){
                return 'los apellidos: no deben superar 60 caracteres';
            }
            elseif(!preg_match($expresionEmail, $_POST['newEmail'])) {
                return 'el email no es valido';
            }
            elseif (strlen($_POST['newEmail'])>100) {
                return 'el email: no debe superar 100 caracteres';
            }
            elseif (!preg_match($expresionTelf, $_POST['telefono'])) {
                return 'el telefono: debe ser de 9 caracteres numericos';
            }
            elseif (strlen($_POST['direccion'])>100) {
                return 'la direccion: no debe superar 100 caracteres';
            }
            else {
                // Compruebo si la fecha es mayor que la actual.
                $milisegundos = round(microtime(true) * 1000); // obtener la 'fecha actual' en milisegundos.
                $milisegundosCita = strtotime($_POST['birthday']) * 1000; // obtener la 'birthday' en milisegundos.

                if ($milisegundosCita > $milisegundos) {
                    return 'la fecha: no puede ser posterior a la actual';
                }
                else {
                    // Comprueba si existe 'EMAIL' en la base de datos.
                    $email = $_POST['newEmail'];
                    $resultado = SQL::comprobarEmail($email);

                    if (count($resultado)>0 && $resultado[0]-> email !== $_POST['email']) {
                        return 'el email "'.$email.'" ya existe';
                    }
                    else {
                        // Introducir todos los datos recogidos en sus respectivas variables.
                        $nombre = htmlspecialchars($_POST['nombre']);
                        $apellidos = htmlspecialchars($_POST['apellidos']);
                        $email = filter_input(INPUT_POST, 'newEmail', FILTER_SANITIZE_EMAIL);
                        $telefono = htmlspecialchars($_POST['telefono']);
                        $fecha_nacimiento = htmlspecialchars($_POST['birthday']);
                        $direccion = htmlspecialchars($_POST['direccion']);
                        $sexo = htmlspecialchars($_POST['cajaSexo']);

                        // Si la nueva contraseña este vacia, obtener la contraseña del 'usuario' de la sesión actual para insertar la misma.
                        if (empty($_POST['newPassword'])) {
                            $passUser = [];
                            $passUser = SQL::comprobarUsuario($_SESSION['usuario']);
                            $password = $passUser[0]->password;
                        }else {
                            // Introducir la nueva contraseña y encriptarla, para sustituirla por la antigua.
                            $passUser = htmlspecialchars($_POST['newPassword']);
                            $coste = ['cost' => 10]; // 'coste' de la encriptación.
                            $password = password_hash($passUser, PASSWORD_BCRYPT,$coste); // encriptar password.
                        }
                        
                        // Enviar los datos a modificarPerfil() para su modificación y actualización en la base de datos.
                        SQL::modificarPerfil($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $password);
                    }
                }
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (insertarNoticiasAdmin.php), 'validarlos e insertarlos'.
    */
    public static function validarInsertNoticiasAdmin() {
        $conexion = null;
        try {
            if (
                empty($_POST['tituloInsertNoticiaAdmin']) || 
                empty($_POST['textInsertNoticiaAdmin']) || 
                empty($_POST['fechaInsertNoticiaAdmin'])
            ) {
                return 'los campos marcados ( * ) son obligatorios';
            } else {
                // Comprobar si existe el titulo de la noticia.
                $titulo = $_POST["tituloInsertNoticiaAdmin"];
                $resultado = SQL::comprobarTituloNoticiaAdmin($titulo);

                if (count($resultado) === 1) {
                    return 'el titulo ya existe';
                } else {
                    if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] !== '') {
                        $tipoArchivo = $_FILES['foto']['type'];
                        $permitido = ["image/jpeg", "image/jpg", "image/png"];
                        if (!in_array($tipoArchivo, $permitido)) {
                            return 'No se ha seleccionado ningún archivo o el archivo seleccionado no está permitido';
                        }

                        $tamanoArchivo = $_FILES['foto']['size'];
                        $maximoPermitido = 2 * 1024 * 1024; // 2MB
                        if ($tamanoArchivo > $maximoPermitido) {
                            return 'El archivo es demasiado grande. Máximo permitido: 2MB.';
                        }
                        if ($tamanoArchivo < 1024) { // 1 KB
                            return 'El archivo es demasiado pequeño o está dañado.';
                        }

                        $nombreArchivo = $_FILES['foto']['name'];
                        $binariosImage = file_get_contents($_FILES['foto']['tmp_name']);

                        $idUser = $_POST["idUserInsertNoticiaAdmin"];
                        $texto = $_POST["textInsertNoticiaAdmin"];
                        $fechaNoticia = $_POST["fechaInsertNoticiaAdmin"];

                        $conexion = mysqli_connect("127.0.0.1", "root", "", "small_pets");
                        mysqli_set_charset($conexion, "utf8");
                        $binariosImage = mysqli_escape_string($conexion, $binariosImage);
                        $titulo = mysqli_escape_string($conexion, $titulo);
                        $texto = mysqli_escape_string($conexion, $texto);
                        $fechaNoticia = mysqli_escape_string($conexion, $fechaNoticia);

                        $sentencia = "INSERT INTO noticias (idUser, titulo, nombre, imagen, tipo, texto, fecha_noticia)
                                    VALUES ('$idUser', '$titulo', '$nombreArchivo', '$binariosImage', '$tipoArchivo', '$texto', '$fechaNoticia')";

                        $resultado = mysqli_query($conexion, $sentencia);

                        if ($resultado) {
                            return true;
                        } else {
                            return 'Error al insertar en la base de datos';
                        }
                    } else {
                        return 'No se ha seleccionado ningún archivo';
                    }
                }
            }
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($conexion) {
                mysqli_close($conexion);
            }
        }
    }

    /*
        Recoger datos del formulario (modificarNoticiasAdmin.php), para los datos de la 'noticia'.
    */
    public static function validarModDatosNoticiasAdmin() {
        try {
            // Validar campos obligatorios
            if (empty($_POST['tituloModNoticiaAdmin']) || empty($_POST['textModNoticiaAdmin']) || empty($_POST['fechaModNoticiaAdmin'])) {
                return 'Los campos marcados ( * ) son obligatorios';
            }

            // Obtener IDs y título
            $idNoticia = $_POST['idModNoticiaAdmin'];
            $idUser = $_POST['idUserModNoticiaAdmin'];
            $titulo = $_POST['tituloModNoticiaAdmin'];

            // Comprobar si existe título duplicado
            $resultado = SQL::comprobarTituloNoticiaAdmin($titulo);

            // Validar: si existe título pero es la misma noticia y usuario, o no existe el título, continuar
            if ((count($resultado) > 0 && 
                $resultado[0]->idNoticia == $idNoticia && 
                $resultado[0]->titulo == $titulo && 
                $resultado[0]->idUser == $idUser) || count($resultado) < 1) {

                // Obtener datos para actualizar
                $textoNoticia = $_POST['textModNoticiaAdmin'];
                $fechaNoticia = $_POST['fechaModNoticiaAdmin'];

                // Retornamos los datos para hacer la modificación
                return [$idNoticia, $idUser, $titulo, $textoNoticia, $fechaNoticia];

            } else {
                return 'El título ya existe.';
            }
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (modificarImgNoticiasAdmin.php), para la imagen (foto) de la 'noticia.'.
        'Validarla e insertarla'.
    */
    public static function validarModImgNoticiasAdmin() {
        $conexion = null;
        try {
            if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
                return 'No se ha seleccionado ningún archivo o se ha producido un error al subirlo.';
            }

            $permitido = ["image/jpeg", "image/jpg", "image/png"];
            $tipoArchivo = $_FILES['foto']['type'];

            if (!in_array($tipoArchivo, $permitido)) {
                return 'El archivo seleccionado no está permitido.';
            }

            // Datos de la imagen
            $titulo = $_POST["tituloModImgNoticiaAdmin"] ?? '';
            if (empty($titulo)) {
                return 'El título es obligatorio.';
            }

            $tamanoArchivo = $_FILES['foto']['size'];
            $maximoPermitido = 2 * 1024 * 1024; // 2 MB
            if ($tamanoArchivo > $maximoPermitido) {
                return 'El archivo es demasiado grande. Máximo permitido: 2MB.';
            }
            if ($tamanoArchivo < 1024) { // 1 KB
                return 'El archivo es demasiado pequeño o está dañado.';
            }
            $nombreArchivo = $_FILES['foto']['name'];
            $binariosImage = file_get_contents($_FILES['foto']['tmp_name']);

            // Conexión PDO
            $conexion = DB::conn();
            $sentencia = $conexion->prepare("
                UPDATE noticias 
                SET nombre = :nombre, imagen = :imagen, tipo = :tipo 
                WHERE titulo = :titulo
            ");

            $sentencia->bindParam(':nombre', $nombreArchivo);
            $sentencia->bindParam(':imagen', $binariosImage, PDO::PARAM_LOB); // LOB para binarios
            $sentencia->bindParam(':tipo', $tipoArchivo);
            $sentencia->bindParam(':titulo', $titulo);

            $resultado = $sentencia->execute();

            if ($resultado) {
                return true;
            } else {
                return 'Error al actualizar la imagen.';
            }

        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($conexion !== null) {
                $conexion = null;
            }
        }
    }

    /*
        Recoger datos del formulario (insertarCita.php).
    */
    public static function validarInsertCita() {
        try {
            // Comprobar fecha de la cita.
            if (empty($_POST['fechaCita'])) {
                return 'los campos marcados ( * ) son obligatorios';

            }else {

                $milisegundos = round(microtime(true) * 1000); // obtener la 'fecha actual' en milisegundos.
                $milisegundosCita = strtotime($_POST['fechaCita']) * 1000; // obtener la 'fechaCita' en milisegundos.

                // Compruebo si la fecha de la cita es mayor que la actual.
                if ($milisegundosCita > $milisegundos || $_POST['fechaCita'] === date('Y-m-d')) {

                    // Si la fecha de la cita es MAYOR que la actual.
                    $fechaCita = $_POST['fechaCita'];

                    // Obtengo el 'id' del 'usuario actual de la sesión.'
                    $idUsuario = $_SESSION['idUser'];

                    // Compruebo si el motivo de la cita esta vacio.
                    if (!isset($_POST['textCita'])) {
                        // Si el motivo esta vacio.
                        $motivoCita = null;
                    }
                    else {
                        // Si el motivo contiene texto.
                        $motivoCita = $_POST['textCita'];
                    }
            
                    // Compruebo si la 'fecha' de la 'cita' ya exite en la tabla 'citas'.
                    $resultado = SQL::comprobarFechaCita($idUsuario, $fechaCita);

                    // Si existe
                    if (count($resultado)>0 && $resultado[0]-> fecha_cita === $_POST['fechaCita']) {
                        return 'Ya tienes cita para la fecha '.$resultado[0]-> fecha_cita;
        
                    }else {
                        // Enviar los datos para su inserción en la base de datos.
                        return [$idUsuario, $fechaCita, $motivoCita];
                    }

                }else {
                    // Si fecha de la cita es MENOR que la actual.
                    return 'La fecha de la Cita, no puede ser anterior a la de hoy';
                }
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (insertarCitaAdmin.php).
    */
    public static function validarInsertCitaAdmin() {
        try {
            // Comprobar fecha de la cita y si existe el 'idUser' del usuario en la tabla 'users_login'.
            if (empty($_POST['fechaCitaAdmin']) || empty($_POST['userCitaAdmin'])) {
                return 'los campos marcados ( * ) son obligatorios';

            }else {
                $userCitaAdmin = $_POST['userCitaAdmin'];
                $idUser = $userCitaAdmin;
                $resultado = SQL::comprobarIdUser($idUser);

                if ($resultado !== null) {

                    $idUsuario = $resultado->idUser;

                    $milisegundos = round(microtime(true) * 1000); // obtener la 'fecha actual' en milisegundos.
                    $milisegundosCita = strtotime($_POST['fechaCitaAdmin']) * 1000; // obtener la 'fechaCita' en milisegundos.

                    // Compruebo si la fecha de la cita es mayor que la actual.
                    if ($milisegundosCita > $milisegundos || $_POST['fechaCitaAdmin'] === date('Y-m-d')) {

                        // Si la fecha de la cita es MAYOR que la actual.
                        $fechaCita = $_POST['fechaCitaAdmin'];

                        // Compruebo si el motivo de la cita esta vacio.
                        if (!isset($_POST['textCitaAdmin'])) {
                            // Si el motivo esta vacio.
                            $motivoCita = null;
                        }
                        else {
                            // Si el motivo contiene texto.
                            $motivoCita = $_POST['textCitaAdmin'];
                        }
                
                        // Compruebo si la 'fecha' de la 'cita' ya exite en la tabla 'citas'.
                        $resultado = SQL::comprobarFechaCita($idUsuario, $fechaCita);

                        // Si existe
                        if (count($resultado)>0 && $resultado[0]-> fecha_cita === $_POST['fechaCitaAdmin']) {
                            return 'Ya tienes cita para la fecha '.$resultado[0]-> fecha_cita;
            
                        }else {
                            // Enviar los datos para su inserción en la base de datos.
                            return [$idUsuario, $fechaCita, $motivoCita];
                        }

                    }else {
                        // Si fecha de la cita es MENOR que la actual.
                        return 'La fecha de la Cita, no puede ser anterior a la de hoy';
                    }
                }
                else {
                    return 'el idUser '.$userCitaAdmin.' : No existe';
                }
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (actualizarCita.php) o (modificarCitaAdmin.php).
    */
    public static function validarActualizarCita() {
        try {
            // Comprobar fecha de la Cita.
            if (empty($_POST['nuevaFechaCita'])) {
                return 'los campos marcados ( * ) son obligatorios';

            }else {
                $milisegundos = round(microtime(true) * 1000); // obtener la 'fecha actual' en milisegundos.
                $milisegundosCita = strtotime($_POST['nuevaFechaCita']) * 1000; // obtener la 'nuevaFechaCita' en milisegundos.

                // Compruebo si la fecha de la cita es mayor que la actual.
                if ($milisegundosCita > $milisegundos || $_POST['nuevaFechaCita'] === date('Y-m-d')) {

                    // Si es MAYOR que la actual, recogo la fecha de la cita.
                    $nuevaFechaCita = $_POST['nuevaFechaCita'];

                    // Compruebo si el motivo de la cita esta vacio.
                    if (!isset($_POST['textActualizarCita'])) {
                        // Si el motivo esta vacio.
                        $textActualizarCita = null;
                    }
                    else {
                        // Si el motivo contiene texto.
                        $textActualizarCita = $_POST['textActualizarCita'];
                    }

                    // Obtengo el 'id' de la 'cita' para actualizar.
                    $idCita = $_POST['actualizarCitaId'];
                    
                    // Obtener el idUser dueño de la cita
                    $idUsuario = SQL::obtenerIdUsuarioDeCita($idCita);
                    if (!$idUsuario) {
                        return 'No se pudo verificar el usuario dueño de la cita';
                    }

                    // Compruebo si la 'fecha' de la 'cita' ya exite en la tabla 'citas'.
                    $resultado = SQL::comprobarFechaCita($idUsuario, $nuevaFechaCita);

                    if (count($resultado)>0 && $resultado[0]-> fecha_cita !== $_POST['fechaActualizarCita']) {
                        // Si existe la fecha y es distinta a la seleccionada.
                        return 'Ya tienes cita para la fecha '.$resultado[0]-> fecha_cita;
                    }
                    else {
                        // Enviar los datos a insertarCita() para su inserción en la base de datos.
                        return [$idCita, $nuevaFechaCita, $textActualizarCita];
                    }

                }else {
                    // Si fecha de la cita es MENOR que la actual.
                    return 'La fecha de la Cita, no puede ser anterior a la de hoy';
                }
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Recoger datos del formulario (modificarUserAdmin.php).
    */
    public static function validarModUserAdmin() {
        try {
            $expresionTelefono = "/^\d{9}$/";

            // Campos obligatorios
            $camposObligatorios = ['nombre', 'apellidos', 'email', 'newEmail', 'telefono', 'birthday', 'newUserAdmin', 'rol'];
            foreach ($camposObligatorios as $campo) {
                if (empty($_POST[$campo])) {
                    return 'Los campos marcados ( * ) son obligatorios';
                }
            }

            // Longitudes y validaciones individuales
            if (strlen($_POST['nombre']) > 30) return 'El nombre no debe superar 30 caracteres';
            if (strlen($_POST['apellidos']) > 60) return 'Los apellidos no deben superar 60 caracteres';
            if (strlen($_POST['newEmail']) > 100) return 'El email no debe superar 100 caracteres';
            if (!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL)) return 'El email no es válido';
            if (!preg_match($expresionTelefono, $_POST['telefono'])) return 'El teléfono debe ser de 9 dígitos numéricos';
            if (strlen($_POST['direccion'] ?? '') > 100) return 'La dirección no debe superar 100 caracteres';
            if (strlen($_POST['newUserAdmin']) > 50) return 'El usuario no debe superar 50 caracteres';

            // Validar fecha
            $fechaNacimiento = strtotime($_POST['birthday']);
            if ($fechaNacimiento === false || $fechaNacimiento > time()) {
                return 'La fecha no puede ser mayor a la actual';
            }

            // Rol válido
            $rol = $_POST['rol'];
            if (!in_array($rol, ['user', 'admin'])) return 'El rol debe ser "user" o "admin"';

            // Comprobar email único (solo si cambia)
            $emailNuevo = $_POST['newEmail'];
            $emailAntiguo = $_POST['email'];
            $resultado = SQL::comprobarEmail($emailNuevo);
            if ($resultado !== false && count($resultado) > 0 && $resultado[0]->email !== $emailAntiguo) {
                return 'El email "' . $emailNuevo . '" ya está registrado';
            }

            // Comprobar usuario único (solo si cambia)
            $usuarioNuevo = $_POST['newUserAdmin'];
            $usuarioAntiguo = $_POST['usuario'];
            $resultado = SQL::comprobarUsuario($usuarioNuevo);
            if ($resultado !== false && count($resultado) > 0 && $resultado[0]->usuario !== $usuarioAntiguo) {
                return 'El usuario "' . $usuarioNuevo . '" ya está registrado';
            }

            // Sanitizar datos para retorno
            $nombre = htmlspecialchars($_POST['nombre']);
            $apellidos = htmlspecialchars($_POST['apellidos']);
            $email = filter_input(INPUT_POST, 'newEmail', FILTER_SANITIZE_EMAIL);
            $telefono = htmlspecialchars($_POST['telefono']);
            $fecha_nacimiento = date('Y-m-d', $fechaNacimiento);
            $direccion = !empty($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : null;
            $sexo = !empty($_POST['cajaSexoAdmin']) ? htmlspecialchars($_POST['cajaSexoAdmin']) : null;
            $usuario = htmlspecialchars($_POST['newUserAdmin']);

            return [$nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $rol];

        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
    * Comprueba si un 'email' existe en la tabla 'users_data', y si existe,
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarEmail($email) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_data WHERE email = :email";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute([":email" => $email]);
            $result = $consulta->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) $consulta->closeCursor();
            $conexion = null; // cierra conexión explícitamente
        }
    }

    /*
    * Comprueba si el nombre de un 'usuario' existe en la tabla 'users_login', y si existe,
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarUsuario($usuario) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_login WHERE usuario = :usuario";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute([":usuario" => $usuario]);
            $result = $consulta->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) $consulta->closeCursor();
            $conexion = null; // cierra conexión explícitamente
        }
    }

    /*
    * Comprueba si el 'idUser' de un 'usuario' existe en la tabla 'users_login', y si existe,
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarIdUser($idUser) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_login WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute([":idUser" => $idUser]);
            $usuario = $consulta->fetch(PDO::FETCH_OBJ); // fetch único
            return $usuario ?: null; // Devuelve el objeto o null si no se encontró
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) $consulta->closeCursor();
            $conexion = null;
        }
    }

    /*
    * Comprueba si el nombre de un 'usuario' existe en la tabla 'users_login', y si existe,
    * devuelve un array de objetos con los datos del registro, en el que compruebo su contraseña.
    * @return array. 
    */
    public static function comprobarLogin($usuarioLogin, $passwordLogin) {
        try {
            // Comprobar si existe el usuario.
            $result = SQL::comprobarUsuario($usuarioLogin);

            // Si existe.
            if (count($result) === 1) {

                // Comprobar la contraseña del usuario.
                if (password_verify($passwordLogin, $result[0]->password)) {
                    
                    // Si es correcta, iniciar sesión e introducir el nombre del 'usuario' y su 'rol' en sus respectivas variables de sesión.
                    session_start();
                    $_SESSION['usuario'] = $result[0]->usuario;
                    $_SESSION['rol'] = $result[0]->rol;
                    $_SESSION['idUser'] = $result[0]->idUser;
            
                    // Redireccionar al 'usuario' a la página 'index.php'.
                    header("location:../index.php?msgConfirm=okk");
                    exit();
                }
                else {
                    // Si no es correcta. Redireccionar al 'usuario' a la página 'login.php'.
                    header('location:login.php?msgError=la contraseña no es correcta');
                    exit();
                }
            }
            else {
                // Si no existe. Redireccionar al 'usuario' a la página 'login.php'.
                header('location:login.php?msgError=el usuario ( '.$usuarioLogin.' ) no existe');
                exit();
            }
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
    * Comprueba si existe el 'titulo' de la noticia en la tabla 'noticias'.
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarTituloNoticiaAdmin($titulo) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $consulta = $conexion->prepare("SELECT * FROM noticias WHERE titulo = :titulo");
            $consulta->execute([':titulo' => $titulo]);
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta !== null) $consulta->closeCursor();
            $conexion = null;
        }
    }

    /*
    * Comprueba si la 'fecha de la cita a insertar' del 'usuario de la sesión actual' existe en la tabla 'citas', si existe
    * devuelve un array de objetos con los datos del registro.
    * @return array. 
    */
    public static function comprobarFechaCita($idUsuario, $fechaCita) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM citas WHERE idUser = :idUser AND fecha_cita = :fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute([
                ":idUser" => $idUsuario,
                ":fecha_cita" => $fechaCita
            ]);
            $result = $consulta->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;

        } finally {
            if ($consulta) $consulta->closeCursor();
            $conexion = null;
        }
    }

    /*
    * Comprueba si el 'usuario de la sesión actual' tiene citas pendientes, si las tiene,
    * devuelve un array de objetos con los datos del registro.
    * @return array. 
    */
    public static function comprobarSiHayCitas($idUsuario) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM citas WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
    * Obtengo y muestro todos los datos personales de la tabla 'users_data' del 'usuario' de la sesión actual,
    * donde coincida el 'idUser' de la tabla 'users_login' con el 'idUser' de la tabla 'users_data'.
    * @return array.
    */
    public static function obtenerDatosPersonales($idUsuario) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_data WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
    * Obtengo todos los 'usuarios' de la tabla 'users_data' y 'users_login' para 'verUsersAdmin.php'.
    * @return array.
    */
    public static function obtenerUsersAdmin() {
        $conexion = null;
        $stmt = null;
        try {
            $conexion = DB::conn();
            $sentencia = "
                SELECT ud.idUser, ud.nombre, ud.apellidos, ud.email, ud.telefono, ud.fecha_nacimiento,
                    ud.direccion, ud.sexo, ul.usuario, ul.rol
                FROM users_data ud
                JOIN users_login ul ON ud.idUser = ul.idUser
            ";
            $stmt = $conexion->prepare($sentencia);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($stmt) $stmt->closeCursor();
            $conexion = null;
        }
    }

    /*
    * Obtengo todos los 'idUser' de la tabla 'users_data' para compararlos con la encryptación en 'modificarUserAdmin.php'.
    * @return array.
    */
    public static function obtenerIdUsersAdmin() {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $consulta = $conexion->prepare("SELECT idUser FROM users_data");
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_OBJ); // traer todos los resultados de golpe
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta !== null) {
                $consulta->closeCursor();
            }
            if ($conexion !== null) {
                $conexion = null; // cerrar conexión
            }
        }
    }

    /*
    * Obtengo el 'usuario' de la tabla 'users_data' y 'users_login' que he seleccionado en 'verUsersAdmin.php'.
    * @return array.
    */
    public static function obtenerUsuarioAdmin($userAdmin) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sql = "
                SELECT 
                    ud.idUser, ud.nombre, ud.apellidos, ud.email, ud.telefono, 
                    ud.fecha_nacimiento, ud.direccion, ud.sexo,
                    ul.usuario, ul.rol
                FROM users_data ud
                JOIN users_login ul ON ud.idUser = ul.idUser
                WHERE ud.idUser = :idUser
            ";
            $consulta = $conexion->prepare($sql);
            $consulta->execute([':idUser' => $userAdmin]);
            $result = $consulta->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta !== null) {$consulta->closeCursor();}
            if ($conexion !== null) {$conexion = null;} // cerrar conexión
        }
    }

    /*
    * Obtengo todas las 'noticias' de la tabla 'noticias', para 'noticiasAdmin', 'visit' y 'user'.
    * @return array.
    */
    public static function obtenerNoticiasAdmin() {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $consulta = $conexion->prepare("SELECT * FROM noticias");
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta !== null) {$consulta->closeCursor();}
            if ($conexion !== null) {$conexion = null;} // cerrar conexión
        }
    }

    /*
    * Obtengo el 'nombre y apellidos' del 'usuario' que ha escrito la 'noticia'.
    * @return array.
    */
    public static function obtenerEscritorNoticia($iduserEscritor) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT nombre, apellidos FROM users_data WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $iduserEscritor));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }    
    }

    /*
    * Obtengo la 'noticia' de la tabla 'noticias' para modificarla.
    * @return array.
    */
    public static function obtenerNoticia($recogerTitulo) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $consulta = $conexion->prepare("SELECT * FROM noticias WHERE titulo = :titulo");
            $consulta->execute(array(":titulo" => $recogerTitulo));
            $result = $consulta->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta !== null) {
                $consulta->closeCursor();
            }
            if ($conexion !== null) {
                $conexion = null;
            }
        }
    }

    /*
    * Obtengo todas las citas de la tabla 'citas' del 'usuario de la sesión actual' que sean posteriores a la fecha actual.
    * @return array.
    */
    public static function obtenerCitas($idUsuario) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM citas WHERE idUser = :idUser AND fecha_cita > CURRENT_DATE() OR idUser = :idUser AND fecha_cita = CURRENT_DATE() ORDER BY fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
    * Obtengo todas las 'citas' de la tabla 'citas', para 'citasAdmin'.
    * @return array.
    */
    public static function obtenerCitasAdmin() {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $consulta = $conexion->prepare("SELECT * FROM citas");
            $consulta->execute();
            $result = $consulta->fetchAll(PDO::FETCH_OBJ); // obtén todos los resultados directamente
            return $result;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta !== null) {$consulta->closeCursor();}
            if ($conexion !== null) {$conexion = null;}
        }
    }

    /*
    * Obtengo todos los 'idUser' de la tabla 'citas' y retorno el que coincida con el 'encryptado'.
    * @return array.
    */
    public static function obteneridUsersCitas() {
        $conexion = null;
        $stmt = null;
        try {
            $conexion = DB::conn();
            $stmt = $conexion->prepare("SELECT idUser FROM citas");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($stmt) $stmt->closeCursor();
            $conexion = null; // libera la conexión
        }
    }

    /*
    * Obtengo la 'cita' de la tabla 'citas' del 'usuario de la sesión actual', a traves de su 'idUser' y la 'fecha_cita', para modificarla.
    * @return array.
    */
    public static function obtenerFechasCita($idUsuario, $mostrarCitas) {
        $conexion = null;
        $stmt = null;
        try {
            $conexion = DB::conn();
            $stmt = $conexion->prepare("
                SELECT * FROM citas 
                WHERE idUser = :idUser AND fecha_cita = :fecha_cita
            ");
            $stmt->execute([
                ":idUser" => $idUsuario,
                ":fecha_cita" => $mostrarCitas
            ]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($stmt) {$stmt->closeCursor();}
            $conexion = null;
        }
    }

    /*
        Obtener el idUser real dueño de la cita que se está modificando.
    */
    public static function obtenerIdUsuarioDeCita($idCita) {
        try {
            $conexion = DB::conn();
            $consulta = $conexion->prepare("SELECT idUser FROM citas WHERE idCita = :idCita");
            $consulta->execute([':idCita' => $idCita]);
            $resultado = $consulta->fetch(PDO::FETCH_OBJ);
            return $resultado ? $resultado->idUser : null;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Error al obtener el usuario de la cita.</p>";
            return null;
        } finally {
            if ($consulta) $consulta->closeCursor();
            $conexion = null;
        }
    }

    /*
        Inserta un registro en la tabla 'users_data' y 'users_login'.
    */
    public static function insertarUsuario($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password) {
        try {
            /** Insertar en la tabla 'users_data' **/
            $conexion = DB::conn(); // abrir conexión.
            $sentencia = 'INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
            VALUES (:nombre, :apellidos, :email, :telefono, :fecha_nacimiento, :direccion, :sexo)';
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":nombre", $nombre);
            $consulta->bindParam(":apellidos", $apellidos);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":telefono", $telefono);
            $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
            $consulta->bindParam(":direccion", $direccion);
            $consulta->bindParam(":sexo", $sexo);
            $consulta->execute();
            // Obtengo el 'id' de la última inserción de (users_data) para que corresponda al mismo 'id' de 'idUser' en (users_login).
            $ultimo_id = $conexion->lastInsertId();
            // Liberar la conexión al servidor y poner la conexión a 'null'.
            $consulta->closeCursor();
            $conexion = null;

            /** Insertar en la tabla 'users_login' **/
            $conexion = DB::conn(); // abrir conexión.
            $coste = ['cost' => 10]; // 'coste' de la encriptación.
            $pass = password_hash($password, PASSWORD_BCRYPT, $coste); // encriptar password.
            $rol = "user"; // para que predeterminadamente todos se registren con el 'rol = user'.
            // $rol = "admin"; // este 'rol' es para la primera inserción de la tabla, que será la mia con el 'rol = admin'.
            $sentencia = 'INSERT INTO users_login (idUser, usuario, password, rol)
            VALUES (:idUser, :usuario, :password, :rol)';
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idUser", $ultimo_id);
            $consulta->bindParam(":usuario", $usuario);
            $consulta->bindParam(":password", $pass);
            $consulta->bindParam(":rol", $rol);
            $consulta->execute();
            // Liberar la conexión al servidor y poner la conexión a 'null'.
            $consulta->closeCursor();
            $conexion = null;

            /**  Redireccionar al 'usuario' a la página 'login.php' **/
            header('location:./login.php?msgConfirm=Registro realizado, puedes iniciar sesión');
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        }
    }

    /*
        Inserta un registro en la tabla 'users_data' y 'users_login', desde 'insertarUserAdmin.php'(usuarios_administración.php).
    */
    public static function insertarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password, $rol) {
        $conexion = null;
        $stmt1 = null;
        $stmt2 = null;
        try {
            $conexion = DB::conn();
            $conexion->beginTransaction(); // Iniciar transacción

            // Insertar en users_data
            $sentencia1 = 'INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
                        VALUES (:nombre, :apellidos, :email, :telefono, :fecha_nacimiento, :direccion, :sexo)';
            $stmt1 = $conexion->prepare($sentencia1);
            $stmt1->execute([
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':email' => $email,
                ':telefono' => $telefono,
                ':fecha_nacimiento' => $fecha_nacimiento,
                ':direccion' => $direccion,
                ':sexo' => $sexo
            ]);

            $ultimo_id = $conexion->lastInsertId();

            // Insertar en users_login
            $coste = ['cost' => 10];
            $pass = password_hash($password, PASSWORD_BCRYPT, $coste);

            $sentencia2 = 'INSERT INTO users_login (idUser, usuario, password, rol)
                        VALUES (:idUser, :usuario, :password, :rol)';
            $stmt2 = $conexion->prepare($sentencia2);
            $stmt2->execute([
                ':idUser' => $ultimo_id,
                ':usuario' => $usuario,
                ':password' => $pass,
                ':rol' => $rol
            ]);

            $conexion->commit(); // Confirmar transacción

            return true;

        } catch (Exception $e) {
            if ($conexion) {
                $conexion->rollBack(); // Deshacer si hay error
            }
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;

        } finally {
            if ($stmt1) $stmt1->closeCursor();
            if ($stmt2) $stmt2->closeCursor();
            $conexion = null;
        }
    }

    /*
        Inserta un registro en la tabla 'citas'.
    */
    public static function insertarCita($idUsuario, $fechaCita, $motivoCita) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "INSERT INTO citas (idUser, fecha_cita, motivo_cita)
                        VALUES (:idUser, :fecha_cita, :motivo_cita)";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute([
                ":idUser" => $idUsuario,
                ":fecha_cita" => $fechaCita,
                ":motivo_cita" => $motivoCita
            ]);
            return true;
        } catch (Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) $consulta->closeCursor();
            $conexion = null;
        }
    }

    /*
        Modifica y actualiza un registro en las tablas 'users_data' y 'users_login' (del 'usuario' de la sesión actual, por medio de su perfil).
    */
    public static function modificarPerfil($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $password) {
        $conexion = null;
        $stmt1 = null;
        $stmt2 = null;
        try {
            $idUsuario = $_SESSION['idUser'];
            if (!$idUsuario) return false;

            $conexion = DB::conn();
            $conexion->beginTransaction(); // 🔐

            // 1. users_data
            $stmt1 = $conexion->prepare("
                UPDATE users_data SET 
                    nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono, 
                    fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, sexo = :sexo 
                WHERE idUser = :idUser
            ");
            $stmt1->execute([
                ":nombre" => $nombre,
                ":apellidos" => $apellidos,
                ":email" => $email,
                ":telefono" => $telefono,
                ":fecha_nacimiento" => $fecha_nacimiento,
                ":direccion" => $direccion,
                ":sexo" => $sexo,
                ":idUser" => $idUsuario
            ]);

            // 2. users_login
            $stmt2 = $conexion->prepare("
                UPDATE users_login SET password = :password WHERE idUser = :idUser
            ");
            $stmt2->execute([
                ":password" => $password,
                ":idUser" => $idUsuario
            ]);

            $conexion->commit(); // ✅
            header('location:perfil.php?msgConfirm=Registro Actualizado');
            exit;

        } catch (Exception $e) {
            if ($conexion) $conexion->rollBack(); // ❌
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;

        } finally {
            if ($stmt1) $stmt1->closeCursor();
            if ($stmt2) $stmt2->closeCursor();
            $conexion = null;
        }
    }

    /*
        Modifica y actualiza un registro en las tablas 'users_data' y 'users_login'.
    */
    public static function modificarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $rol) {
        $conexion = null;
        $stmt1 = null;
        $stmt2 = null;
        try {
            $idUserAdmin = $_SESSION['identUserAdmin'];
            if (!$idUserAdmin) {
                return false;
            }
            $conexion = DB::conn();
            $conexion->beginTransaction(); // 🔐 transacción
            // Actualizar users_data
            $stmt1 = $conexion->prepare("
                UPDATE users_data SET 
                    nombre = :nombre,
                    apellidos = :apellidos,
                    email = :email,
                    telefono = :telefono,
                    fecha_nacimiento = :fecha_nacimiento,
                    direccion = :direccion,
                    sexo = :sexo 
                WHERE idUser = :idUser
            ");
            $stmt1->execute([
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':email' => $email,
                ':telefono' => $telefono,
                ':fecha_nacimiento' => $fecha_nacimiento,
                ':direccion' => $direccion,
                ':sexo' => $sexo,
                ':idUser' => $idUserAdmin
            ]);
            // Actualizar users_login
            $stmt2 = $conexion->prepare("
                UPDATE users_login SET 
                    usuario = :usuario, 
                    rol = :rol 
                WHERE idUser = :idUser
            ");
            $stmt2->execute([
                ':usuario' => $usuario,
                ':rol' => $rol,
                ':idUser' => $idUserAdmin
            ]);
            $conexion->commit(); // ✅ confirmar transacción
            return true;
        } catch (Exception $e) {
            if ($conexion) {
                $conexion->rollBack(); // ❌ revertir cambios si hay error
            }
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if (isset($stmt1)) $stmt1->closeCursor();
            if (isset($stmt2)) $stmt2->closeCursor();
            $conexion = null;
        }
    }

    /*
        Modifica y actualiza solo 'los datos de la noticia' en la tabla 'noticias'.
    */
    public static function modificarDatosNoticiaAdmin($idNoticia, $idUser, $titulo, $textoNoticia, $fechaNoticia) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "UPDATE noticias SET idUser = :idUser, titulo = :titulo, texto = :texto, fecha_noticia = :fecha_noticia WHERE idNoticia = :idNoticia";
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idNoticia", $idNoticia);
            $consulta->bindParam(":idUser", $idUser);
            $consulta->bindParam(":titulo", $titulo);
            $consulta->bindParam(":texto", $textoNoticia);
            $consulta->bindParam(":fecha_noticia", $fechaNoticia);
            $consulta->execute();
            return true;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) {$consulta->closeCursor();}
            $conexion = null;
        }
    }

    /*
        Modifica y actualiza un registro en la tabla 'citas'.
    */
    public static function modificarCita($idCita, $nuevaFechaCita, $textActualizarCita) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "UPDATE citas SET fecha_cita = :fecha_cita, motivo_cita = :motivo_cita WHERE idCita = :idCita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idCita", $idCita);
            $consulta->bindParam(":fecha_cita", $nuevaFechaCita);
            $consulta->bindParam(":motivo_cita", $textActualizarCita);
            $consulta->execute();
            return true;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) {
                $consulta->closeCursor(); // 🧹 cerrar cursor siempre, si fue creado
            }
            $conexion = null; // 🧹 liberar conexión
        }
    }

    /*
        Elimina un registro en la tabla 'noticias' desde el rol 'admin'.
    */
    public static function eliminarNoticiaAdmin($recogerDato) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM noticias WHERE titulo = :titulo";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":titulo" => $recogerDato));
            return true;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) {$consulta->closeCursor();}
            $conexion = null;
        }
    }

    /*
        Elimina un registro en la tabla 'citas' desde el rol 'user'.
    */
    public static function eliminarCita($idUsuario, $fechaEliminacion) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM citas WHERE idUser = :idUser AND fecha_cita = :fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario, ":fecha_cita" => $fechaEliminacion));
            return true;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) {$consulta->closeCursor();}
            $conexion = null; // 🧹 liberar conexión
        }
    }

    /*
        Elimina un registro en la tabla 'citas' desde el rol 'admin'.
    */
    public static function eliminarCitaAdmin($idCita) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM citas WHERE idCita = :idCita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idCita" => $idCita));
            return true;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) {$consulta->closeCursor();}
            $conexion = null; // 🧹 liberar conexión
        }
    }

    /*
        Elimina un registro en las tablas 'users_data y users_login' desde el rol 'admin'.
    */
    public static function eliminarUserAdmin($idUser) {
        $conexion = null;
        $consulta = null;
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM users_data WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUser));
            return true;
        }catch(Exception $e) {
            echo "<p style='color:red;'>Ha ocurrido un error en la operación. Por favor, inténtalo de nuevo más tarde.</p>";
            return false;
        } finally {
            if ($consulta) {$consulta->closeCursor();}
            $conexion = null; // 🧹 liberar conexión
        }
    }
}
?>