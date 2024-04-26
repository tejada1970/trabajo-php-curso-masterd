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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarRegistro()" . $e->getMessage();
        }
    }

    /*
        Recoger datos del formulario (insertarUserAdmin.php).
    */
    public static function validarRegistroAdmin() {
        try {
            // Comprobar mediante una expresión regular, el 'email' recibido.
            $expresionEmail = "/\w+@\w+\.+[a-z]/";
        
            // Comprobar mediante una expresión regular, el 'telefono' recibido.
            $expresionTelf = "/^([0-9]{9})$/";
        
            /* Comprobar que los campos obligatorios contienen datos y que no superen la longitud de caracteres especificada. */
            if (empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['email']) || 
                empty($_POST['telefono']) || empty($_POST['birthday']) || empty($_POST['usuario']) || 
                empty($_POST['password']) || empty($_POST['rol'])) {
                
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

            }elseif (strlen($_POST['direccion'])>100) {
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
                    // Compruebo el 'rol'.
                    if ($_POST['rol'] === 'user' || $_POST['rol'] === 'admin') {

                        $rol = htmlspecialchars($_POST['rol']);

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

                        // Enviar los datos a insertarUserAdmin() para su inserción en la base de datos.
                        SQL::insertarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password, $rol);
                    }
                    else {
                        return 'el rol: debe ser "user" o "admin"';
                    }
                }
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarRegistroAdmin()" . $e->getMessage();
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarLogin() " . $e->getMessage();
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarPerfil()" . $e->getMessage();
        }
    }

    /*
        Recoger datos del formulario (insertarNoticiasAdmin.php), 'validarlos e insertarlos'.
    */
    public static function validarInsertNoticiasAdmin() {
        try {
            // Comprobar que los campos obligatorios contienen datos y que no superen la longitud de caracteres especificada.
            if (empty($_POST['tituloInsertNoticiaAdmin']) || empty($_POST['textInsertNoticiaAdmin']) || empty($_POST['fechaInsertNoticiaAdmin'])) {
                return 'los campos marcados ( * ) son obligatorios';
            }else {
                // Comprobar si existe el titulo de la noticia.
                $titulo = $_POST["tituloInsertNoticiaAdmin"];
                $resultado = SQL::comprobarTituloNoticiaAdmin($titulo);

                if (count($resultado) === 1) {
                    return 'el titulo ya existe';
                }
                else {
                    // Comprobar la foto.
                    if (isset($_FILES['foto']['name'])) {

                        $tipoArchivo = $_FILES['foto']['type'];
            
                        // Permiso solo para subir los archivos especificados (image/* seria para todo tipo de imagenes).
                        $permitido = array("image/jpeg", "image/jpg", "image/png");
            
                        if(in_array($tipoArchivo, $permitido) == false) {
                            return'no se ha seleccionado ningun archivo o el archivo seleccionado no esta permitido';
            
                        }else {
                            $nombreArchivo = $_FILES['foto']['name'];
                            $tamanoArchivo = $_FILES['foto']['size'];
                            /*
                                - Extraer los binarios de la imagen -
                                Para ello abrimos el archivo temporal donde se guarda la imagen con su nombre correspondiente,
                                mediante la función 'fopen()'. 'r', es para especificar que el archivo sea de modo lectura.
                                A continuación extraemos los binarios.
                                mediante la función 'fread()' leemos el archivo que hemos abierto con la función 'fopen()' y guardado en '$imagenSubida'.
                                Y por último con la funcion 'mysqli_escape_string' limpiamos los binarios.
                            */
                            $imagenSubida = fopen($_FILES['foto']['tmp_name'], 'r');
                            $binariosImage = fread($imagenSubida, $tamanoArchivo);
            
                            $idUser = $_POST["idUserInsertNoticiaAdmin"];
                            $titulo = $_POST["tituloInsertNoticiaAdmin"];
                            $texto = $_POST["textInsertNoticiaAdmin"];
                            $fechaNoticia = $_POST["fechaInsertNoticiaAdmin"];
            
                            // Insertar los datos en la tabla 'noticias'.
                            $conexion = mysqli_connect("127.0.0.1", "root", "", "small_pets");
                            mysqli_set_charset($conexion, "utf8");
                            $binariosImage = mysqli_escape_string($conexion, $binariosImage);
                
                            $sentencia = "INSERT INTO noticias (idUser, titulo, nombre, imagen, tipo, texto, fecha_noticia)
                            VALUES ('$idUser','$titulo', '$nombreArchivo', '$binariosImage', '$tipoArchivo', '$texto', '$fechaNoticia')";
            
                            $resultado = mysqli_query($conexion, $sentencia);

                            if($resultado) {
                                /**  Redireccionar al 'usuario' a la página 'noticias_administracion.php'. **/
                                header('location:noticias_administracion.php?msgConfirm=Noticia Agregada&tareaAdmin=verNoticiasAdmin');
                            }
                            mysqli_close($conexion);
                        }
                    }
                    else {
                        return'no se ha seleccionado ningun archivo';
                    }
                }
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarInsertNoticiasAdmin()" . $e->getMessage();
        }
    }

    /*
        Recoger datos del formulario (modificarNoticiasAdmin.php), para los datos de la 'noticia'.
    */
    public static function validarModDatosNoticiasAdmin() {
        try {
            // Comprobar que los campos obligatorios contienen datos y que no superen la longitud de caracteres especificada.
            if (empty($_POST['tituloModNoticiaAdmin']) || empty($_POST['textModNoticiaAdmin']) || empty($_POST['fechaModNoticiaAdmin'])) {
                return 'los campos marcados ( * ) son obligatorios';
            }else {
                // Obtengo el 'id' del 'titulo' de la noticia y el 'idUser' de quien la escrito.
                $idNoticia = $_POST['idModNoticiaAdmin'];
                $idUser = $_POST['idUserModNoticiaAdmin'];
                
                // Comprobar si existe el 'titulo' de la noticia.
                $titulo = $_POST["tituloModNoticiaAdmin"];
                $resultado = SQL::comprobarTituloNoticiaAdmin($titulo);

                // Si existe, pero pertenece a la misma 'idNoticia' y mismo 'idUser' (se guarda), sino, se rechaza.
                if (count($resultado)>0 && $resultado[0]-> idNoticia == $idNoticia && $resultado[0]-> titulo == $titulo
                && $resultado[0]-> idUser == $idUser || count($resultado)<1) {

                    // Obtengo el 'texto' y la 'fecha' de la 'noticia'.
                    $textoNoticia = $_POST['textModNoticiaAdmin'];
                    $fechaNoticia = $_POST['fechaModNoticiaAdmin'];

                    // Enviar los datos a modificarDatosNoticiaAdmin() para actualizar los datos de la 'noticia' en la base de datos.
                    SQL::modificarDatosNoticiaAdmin($idNoticia, $idUser, $titulo, $textoNoticia, $fechaNoticia);
                }else {
                    return 'el titulo ya existe';
                }
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarModDatosNoticiasAdmin()" . $e->getMessage();
        }
    }

    /*
        Recoger datos del formulario (modificarImgNoticiasAdmin.php), para la imagen (foto) de la 'noticia.'.
        'Validarla e insertarla'.
    */
    public static function validarModImgNoticiasAdmin() {
        try {
            // Comprobar la foto.
            if (isset($_FILES['foto']['name'])) {

                $tipoArchivo = $_FILES['foto']['type'];
                $permitido = array("image/jpeg", "image/jpg", "image/png");

                if(in_array($tipoArchivo, $permitido) == false) {
                    return'no se ha seleccionado ningun archivo o el archivo seleccionado no esta permitido';
                }else {
                    $titulo = $_POST["tituloModImgNoticiaAdmin"];
                    $nombreArchivo = $_FILES['foto']['name'];
                    $tamanoArchivo = $_FILES['foto']['size'];
                    $imagenSubida = fopen($_FILES['foto']['tmp_name'], 'r');
                    $binariosImage = fread($imagenSubida, $tamanoArchivo);
                    
                    // Actualizar la imagen (foto) en la tabla 'noticias'.
                    $conexion = mysqli_connect("127.0.0.1", "root", "", "small_pets");
                    mysqli_set_charset($conexion, "utf8");
                    $binariosImage = mysqli_escape_string($conexion, $binariosImage);
        
                    $sentencia = "UPDATE noticias SET nombre = '$nombreArchivo', imagen = '$binariosImage', tipo = '$tipoArchivo' WHERE titulo = '$titulo'"; 
                    $resultado = mysqli_query($conexion, $sentencia);

                    if($resultado) {
                        /**  Redireccionar al 'usuario' a la página 'noticias_administracion.php'. **/
                        header('location:noticias_administracion.php?msgConfirm=Imagen Actualizada&tareaAdmin=verNoticiasAdmin');
                    }
                    mysqli_close($conexion);      
                }
            }
            else {
                return'no se ha seleccionado ningun archivo';
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarModImgNoticiasAdmin()" . $e->getMessage();
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
                        // Enviar los datos a insertarCita() para su inserción en la base de datos.
                        SQL::insertarCita($idUsuario, $fechaCita, $motivoCita);
                    }

                }else {
                    // Si fecha de la cita es MENOR que la actual.
                    return 'La fecha de la Cita, no puede ser anterior a la de hoy';
                }
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarInsertCita()" . $e->getMessage();
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

                if(count($resultado)>0) {

                    $idUsuario = $resultado[0]-> idUser;

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
                            // Enviar los datos a insertarCita() para su inserción en la base de datos.
                            SQL::insertarCita($idUsuario, $fechaCita, $motivoCita);
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarInsertCitaAdmin()" . $e->getMessage();
        }
    }

    /*
        Recoger datos del formulario (actualizarCita.php) o (modificarCitaAdmin.php).
    */
    public static function ValidarActualizarCita() {
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

                    // Obtengo el 'idUser' del 'usuario' de 'modificarCita.php' o 'modificarCitaAdmin.php'.
                    $idUsuario = $_SESSION['identUser'];

                    // Compruebo si la 'fecha' de la 'cita' ya exite en la tabla 'citas'.
                    $resultado = SQL::comprobarFechaCita($idUsuario, $nuevaFechaCita);

                    // Si no existe. Enviar los datos a modificarCita() para actualizarlos en la tabla 'citas'.
                    if (count($resultado)<1) {
                        SQL::modificarCita($idCita, $nuevaFechaCita, $textActualizarCita);

                    }elseif (count($resultado)>0 && $resultado[0]-> fecha_cita !== $_POST['fechaActualizarCita']) {
                        // Si existe y es distinta a la seleccionada.
                        return 'Ya tienes cita para la fecha '.$resultado[0]-> fecha_cita;
                        
                    }else {
                        // Si existe y es igual a la seleccionada. Enviar los datos a modificarMotivoCita() para actualizarlos en la tabla 'citas'.
                        SQL::modificarMotivoCita($idCita, $textActualizarCita);
                    }

                }else {
                    // Si fecha de la cita es MENOR que la actual.
                    return 'La fecha de la Cita, no puede ser anterior a la de hoy';
                }
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE ValidarActualizarCita()" . $e->getMessage();
        }
    }

    /*
        Recoger datos del formulario (modificarUserAdmin.php).
    */
    public static function validarModUserAdmin() {
        try {
            // Comprobar mediante una expresión regular, el 'email' recibido.
            $expresionEmail = "/\w+@\w+\.+[a-z]/";
        
            // Comprobar mediante una expresión regular, el 'telefono' recibido.
            $expresionTelf = "/^([0-9]{9})$/";
        
            /* Comprobar que los campos obligatorios contienen datos y que no superen la longitud de caracteres especificada. */
            if (empty($_POST['nombre']) || empty($_POST['apellidos']) || empty($_POST['newEmail']) || 
                empty($_POST['telefono']) || empty($_POST['birthday']) || empty($_POST['newUserAdmin']) || 
               empty($_POST['rol'])) {
                
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

            }elseif (strlen($_POST['direccion'])>100) {
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
                    return 'la fecha: no puede ser posterior a la actual';
                }
                else {
                    // Compruebo el 'rol'.
                    if ($_POST['rol'] === 'user' || $_POST['rol'] === 'admin') {

                        // Comprueba si existe 'EMAIL' en la base de datos.
                        $email = $_POST['newEmail'];
                        $resultado = SQL::comprobarEmail($email);
                        if (count($resultado)>0 && $resultado[0]-> email !== $_POST['email']) {
                            return 'el email "'.$email.'" ya existe';
                        }
                        else {
                            // Comprueba si existe 'USUARIO' en la base de datos.
                            $usuario = $_POST['newUserAdmin'];
                            $resultado = SQL::comprobarUsuario($usuario);
                            if (count($resultado)>0 && $resultado[0]-> usuario !== $_POST['usuario']) {
                                return 'el usuario "'.$usuario.'" ya esta registrado';
                            }
                            else {
                                // Introducir todos los datos recogidos en sus respectivas variables.
                                $nombre = htmlspecialchars($_POST['nombre']);
                                $apellidos = htmlspecialchars($_POST['apellidos']);
                                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                                $telefono = htmlspecialchars($_POST['telefono']);
                                $fecha_nacimiento = htmlspecialchars($_POST['birthday']);
                                $direccion = htmlspecialchars($_POST['direccion']);
                                $sexo = htmlspecialchars($_POST['cajaSexoAdmin']);
                                $usuario = htmlspecialchars($_POST['newUserAdmin']);
                                $rol = htmlspecialchars($_POST['rol']);
                            
                                // Enviar los datos a modificarUserAdmin() para su modificación y actualización en la base de datos.
                                SQL::modificarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $rol);
                            }
                        }
                    }
                    else {
                        return 'el rol: debe ser "user" o "admin"';
                    }
                }
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE validarRegistroAdmin()" . $e->getMessage();
        }
    }

    /*
    * Comprueba si un 'email' existe en la tabla 'users_data', y si existe,
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarEmail($email) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_data WHERE email = :email";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":email" => $email));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarEmail()" . $e->getMessage();
        }
    }

    /*
    * Comprueba si el nombre de un 'usuario' existe en la tabla 'users_login', y si existe,
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarUsuario($usuario) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_login WHERE usuario = :usuario";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":usuario" => $usuario));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarUsuario()" . $e->getMessage();
        }
    }

    /*
    * Comprueba si el 'idUser' de un 'usuario' existe en la tabla 'users_login', y si existe,
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarIdUser($idUser) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM users_login WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUser));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarIdUser()" . $e->getMessage();
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
                }
                else {
                    // Si no es correcta. Redireccionar al 'usuario' a la página 'login.php'.
                    header('location:login.php?msgError=la contraseña no es correcta');
                }
            }
            else {
                // Si no existe. Redireccionar al 'usuario' a la página 'login.php'.
                header('location:login.php?msgError=el usuario ( '.$usuarioLogin.' ) no existe');
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarLogin()" . $e->getMessage();
        }
    }

    /*
    * Comprueba si existe el 'titulo' de la noticia en la tabla 'noticias'.
    * devuelve un array de objetos con los datos del registro.
    * @return array.
    */
    public static function comprobarTituloNoticiaAdmin($titulo) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM noticias WHERE titulo = :titulo";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":titulo" => $titulo));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarTituloNoticiaAdmin()" . $e->getMessage();
        }
    }

    /*
    * Comprueba si la 'fecha de la cita a insertar' del 'usuario de la sesión actual' existe en la tabla 'citas', si existe
    * devuelve un array de objetos con los datos del registro.
    * @return array. 
    */
    public static function comprobarFechaCita($idUsuario, $fechaCita) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM citas WHERE idUser = :idUser AND fecha_cita = :fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario, ":fecha_cita" => $fechaCita));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarFechaCita()" . $e->getMessage();
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE comprobarSiHayCitas()" . $e->getMessage();
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerDatosPersonales()" . $e->getMessage();
        }
    }

    /*
    * Obtengo todos los 'usuarios' de la tabla 'users_data' y 'users_login' para 'verUsersAdmin.php'.
    * @return array.
    */
    public static function obtenerUsersAdmin() {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT ud.idUser,ud.nombre,ud.apellidos,ud.email,ud.telefono,ud.fecha_nacimiento,
            ud.direccion,ud.sexo,ul.usuario,ul.rol FROM users_data ud,users_login ul WHERE (ud.idUser = ul.idUser)";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerUsersAdmin()" . $e->getMessage();
        }
    }

    /*
    * Obtengo todos los 'idUser' de la tabla 'users_data' para compararlos con la encryptación en 'modificarUserAdmin.php'.
    * @return array.
    */
    public static function obtenerIdUsersAdmin() {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT idUser FROM users_data";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerUsersAdmin()" . $e->getMessage();
        }
    }

    /*
    * Obtengo el 'usuario' de la tabla 'users_data' y 'users_login' que he seleccionado en 'verUsersAdmin.php'.
    * @return array.
    */
    public static function obtenerUsuarioAdmin($userAdmin) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT ud.idUser,ud.nombre,ud.apellidos,ud.email,ud.telefono,ud.fecha_nacimiento,
            ud.direccion,ud.sexo,ul.usuario,ul.rol FROM users_data ud,users_login ul WHERE (ud.idUser = :idUserdata AND ul.idUser = :idUserlogin)";
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idUserdata", $userAdmin);
            $consulta->bindParam(":idUserlogin", $userAdmin);
            $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerUsersAdmin()" . $e->getMessage();
        }
    }

    /*
    * Obtengo todas las 'noticias' de la tabla 'noticias', para 'noticiasAdmin', 'visit' y 'user'.
    * @return array.
    */
    public static function obtenerNoticiasAdmin() {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM noticias";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerNoticiasAdmin()" . $e->getMessage();
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerEscritorNoticia()" . $e->getMessage();
        }    
    }

    /*
    * Obtengo la 'noticia' de la tabla 'noticias' para modificarla.
    * @return array.
    */
    public static function obtenerNoticia($recogerTitulo) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM noticias WHERE titulo = :titulo";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":titulo" => $recogerTitulo));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerNoticia()" . $e->getMessage();
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerCitas()" . $e->getMessage();
        }
    }

    /*
    * Obtengo todas las 'citas' de la tabla 'citas', para 'citasAdmin'.
    * @return array.
    */
    public static function obtenerCitasAdmin() {
        try {
        $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM citas";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerCitasAdmin()" . $e->getMessage();
        }
    }

    /*
    * Obtengo todos los 'idUser' de la tabla 'citas' y retorno el que coincida con el 'encryptado'.
    * @return array.
    */
    public static function obteneridUsersCitas() {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT idUser FROM citas";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute();
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
            array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obteneridUsersCitas()" . $e->getMessage();
        }
    }

    /*
    * Obtengo la 'cita' de la tabla 'citas' del 'usuario de la sesión actual', a traves de su 'idUser' y la 'fecha_cita', para modificarla.
    * @return array.
    */
    public static function obtenerFechasCita($idUsuario, $mostrarCitas) {
        try {
            $result = [];
            $conexion = DB::conn();
            $sentencia = "SELECT * FROM citas WHERE idUser = :idUser AND fecha_cita = :fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario, ":fecha_cita" => $mostrarCitas));
            while ($fila = $consulta->fetch(PDO::FETCH_OBJ)) {
                array_push($result, $fila);
            }
            $consulta->closeCursor();
            $conexion = null;
            return $result;
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE obtenerFechasCita()" . $e->getMessage();
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
            $rol = "admin"; // para que predeterminadamente todos se registren con el 'rol = user'.
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
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE insertarUsuario()" . $e->getMessage();
        }
    }

    /*
        Inserta un registro en la tabla 'users_data' y 'users_login', desde 'insertarUserAdmin.php'(usuarios_administración.php).
    */
    public static function insertarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $password, $rol) {
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

            /**  Redireccionar al 'usuario' a la página 'usuarios_administracion.php'. **/
            header('location:usuarios_administracion.php?msgConfirm=Registro Realizado&tareaAdmin=verUsersAdmin');
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE insertarUserAdmin()" . $e->getMessage();
        }
    }

    /*
        Inserta un registro en la tabla 'citas'.
    */
    public static function insertarCita($idUsuario, $fechaCita, $motivoCita) {
        try {
            $conexion = DB::conn();
            $sentencia = 'INSERT INTO citas (idUser, fecha_cita, motivo_cita)
            VALUES (:idUser, :fecha_cita, :motivo_cita)';
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idUser", $idUsuario);
            $consulta->bindParam(":fecha_cita", $fechaCita);
            $consulta->bindParam(":motivo_cita", $motivoCita);
            $consulta->execute();
            $consulta->closeCursor();
            $conexion = null;
            if($_SESSION['idUserGo'] === 1) {
                /**  Redireccionar al 'usuario' a la página 'citas_administracion.php'. **/
                header('location:citas_administracion.php?msgConfirm=Cita Agregada&tareaAdmin=verCitasAdmin');
            }else {
                /**  Redireccionar al 'usuario' a la página 'citaciones.php' **/
                header('location:citaciones.php?msgConfirm=Cita Agregada&tarea=verCitas');
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE insertarCita()" . $e->getMessage();
        }
    }

    /*
        Modifica y actualiza un registro en las tablas 'users_data' y 'users_login' (del 'usuario' de la sesión actual, por medio de su perfil).
    */
    public static function modificarPerfil($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $password) {
        try {
            // Obtener el 'idUser' del 'usuario', para actualizar los datos en las dos tablas donde el 'idUser' coincida.
            $idUsuario = $_SESSION['idUser'];

            if($idUsuario) {
                /** Actualizar los datos personales en la tabla users_data **/
                $conexion = DB::conn(); // abrir conexión.
                $sentencia = "UPDATE users_data SET nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono, 
                fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, sexo = :sexo WHERE idUser = :idUser";
                $consulta = $conexion->prepare($sentencia);
                $consulta->bindParam(":nombre", $nombre);
                $consulta->bindParam(":apellidos", $apellidos);
                $consulta->bindParam(":email", $email);
                $consulta->bindParam(":telefono", $telefono);
                $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
                $consulta->bindParam(":direccion", $direccion);
                $consulta->bindParam(":sexo", $sexo);
                $consulta->bindParam(":idUser", $idUsuario);
                $consulta->execute();
                // Liberar la conexión al servidor y poner la conexión a 'null'.
                $consulta->closeCursor();
                $conexion = null;

                /** Actualizar la contraseña en la tabla users_login **/
                $conexion = DB::conn(); // abrir conexión.
                $sentencia = "UPDATE users_login SET password = :password WHERE idUser = :idUser";
                $consulta = $conexion->prepare($sentencia);
                $consulta->bindParam(":password", $password);
                $consulta->bindParam(":idUser", $idUsuario);
                $consulta->execute();
                // Liberar la conexión al servidor y poner la conexión a 'null'.
                $consulta->closeCursor();
                $conexion = null;
        
                /**  Redireccionar al 'usuario' a la página 'perfil.php' **/
                header('location:perfil.php?msgConfirm=Registro Actualizado');
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE modificarPerfil()" . $e->getMessage();
        }
    }

    /*
        Modifica y actualiza un registro en las tablas 'users_data' y 'users_login'.
    */
    public static function modificarUserAdmin($nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $usuario, $rol) {
        try{
            // Obtener el 'idUser' del 'usuario', para actualizar los datos en las dos tablas donde el 'idUser' coincida.
            $idUserAdmin = $_SESSION['identUserAdmin'];

            if($idUserAdmin) {
                /** Actualizar los datos personales en la tabla users_data **/
                $conexion = DB::conn(); // abrir conexión.
                $sentencia = "UPDATE users_data SET nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono, 
                fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, sexo = :sexo WHERE idUser = :idUser";
                $consulta = $conexion->prepare($sentencia);
                $consulta->bindParam(":nombre", $nombre);
                $consulta->bindParam(":apellidos", $apellidos);
                $consulta->bindParam(":email", $email);
                $consulta->bindParam(":telefono", $telefono);
                $consulta->bindParam(":fecha_nacimiento", $fecha_nacimiento);
                $consulta->bindParam(":direccion", $direccion);
                $consulta->bindParam(":sexo", $sexo);
                $consulta->bindParam(":idUser", $idUserAdmin);
                $consulta->execute();
                // Liberar la conexión al servidor y poner la conexión a 'null'.
                $consulta->closeCursor();
                $conexion = null;

                /** Actualizar el 'usuario y rol' en la tabla users_login **/
                $conexion = DB::conn(); // abrir conexión.
                $sentencia = "UPDATE users_login SET usuario = :usuario, rol = :rol WHERE idUser = :idUser";
                $consulta = $conexion->prepare($sentencia);
                $consulta->bindParam(":usuario", $usuario);
                $consulta->bindParam(":rol", $rol);
                $consulta->bindParam(":idUser", $idUserAdmin);
                $consulta->execute();
                // Liberar la conexión al servidor y poner la conexión a 'null'.
                $consulta->closeCursor();
                $conexion = null;
        
                /**  Redireccionar al 'usuario' a la página 'usuarios_administracion.php'. **/
                header('location:usuarios_administracion.php?msgConfirm=Registro Actualizado&tareaAdmin=verUsersAdmin');
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE modificarUserAdmin()" . $e->getMessage();
        }
    }

    /*
        Modifica y actualiza solo 'los datos de la noticia' en la tabla 'noticias'.
    */
    public static function modificarDatosNoticiaAdmin($idNoticia, $idUser, $titulo, $textoNoticia, $fechaNoticia) {
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
            $consulta->closeCursor();
            $conexion = null;
            /**  Redireccionar al 'usuario' a la página 'noticias_administracion.php'. **/
            header('location:noticias_administracion.php?msgConfirm=Noticia Actualizada&tareaAdmin=verNoticiasAdmin');
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE modificarDatosNoticiaAdmin()" . $e->getMessage();
        }
    }

    /*
        Modifica y actualiza un registro en la tabla 'citas'.
    */
    public static function modificarCita($idCita, $nuevaFechaCita, $textActualizarCita) {
        try {
            $conexion = DB::conn();
            $sentencia = "UPDATE citas SET fecha_cita = :fecha_cita, motivo_cita = :motivo_cita WHERE idCita = :idCita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idCita", $idCita);
            $consulta->bindParam(":fecha_cita", $nuevaFechaCita);
            $consulta->bindParam(":motivo_cita", $textActualizarCita);
            $consulta->execute();
            $consulta->closeCursor();
            $conexion = null;
            if($_SESSION['idUserGo'] === 1) {
                /**  Redireccionar al 'usuario' a la página 'citas_administracion.php'. **/
                header('location:citas_administracion.php?msgConfirm=Cita Actualizada&tareaAdmin=verCitasAdmin');
            }else {
                /**  Redireccionar al 'usuario' a la página 'citaciones.php' **/
                header('location:citaciones.php?msgConfirm=Cita Actualizada&tarea=verCitas');
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE modificarCita()" . $e->getMessage();
        }
    }

    /*
        Modifica y actualiza solo 'el motivo de la cita' en la tabla 'citas'.
    */
    public static function modificarMotivoCita($idCita, $textActualizarCita) {
        try {
            $conexion = DB::conn();
            $sentencia = "UPDATE citas SET motivo_cita = :motivo_cita WHERE idCita = :idCita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->bindParam(":idCita", $idCita);
            $consulta->bindParam(":motivo_cita", $textActualizarCita);
            $consulta->execute();
            $consulta->closeCursor();
            $conexion = null;
            if($_SESSION['idUserGo'] === 1) {
                /**  Redireccionar al 'usuario' a la página 'citas_administracion.php'. **/
                header('location:citas_administracion.php?msgConfirm=Cita Actualizada&tareaAdmin=verCitasAdmin');
            }else {
                /**  Redireccionar al 'usuario' a la página 'citaciones.php' **/
                header('location:citaciones.php?msgConfirm=Cita Actualizada&tarea=verCitas');
            }
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE modificarMotivoCita()" . $e->getMessage();
        }
    }

    /*
        Elimina un registro en la tabla 'noticias' desde el rol 'admin'.
    */
    public static function eliminarNoticiaAdmin($recogerDato) {
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM noticias WHERE titulo = :titulo";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":titulo" => $recogerDato));
            $consulta->closeCursor();
            $conexion = null;
            /** Redireccionar al 'usuario' a la página 'noticias_administracion.php'. **/
            header('location:noticias_administracion.php?msgConfirm=Registro Eliminado&tareaAdmin=verNoticiasAdmin');
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE eliminarNoticiaAdmin()" . $e->getMessage();
        }
    }

    /*
        Elimina un registro en la tabla 'citas' desde el rol 'user'.
    */
    public static function eliminarCita($idUsuario, $fechaEliminacion) {
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM citas WHERE idUser = :idUser AND fecha_cita = :fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $idUsuario, ":fecha_cita" => $fechaEliminacion));
            $consulta->closeCursor();
            $conexion = null;
            /** Redireccionar al 'usuario' a la página 'citaciones.php'. **/
            header('location:citaciones.php?msgConfirm=Cita Anulada&tarea=verCitas');
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE eliminarCita()" . $e->getMessage();
        }
    }

    /*
        Elimina un registro en la tabla 'citas' desde el rol 'admin'.
    */
    public static function eliminarCitaAdmin($userCita, $recogerDato) {
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM citas WHERE idUser = :idUser AND fecha_cita = :fecha_cita";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $userCita, ":fecha_cita" => $recogerDato));
            $consulta->closeCursor();
            $conexion = null;
            /** Redireccionar al 'usuario' a la página 'citas_administracion.php'. **/
            header('location:citas_administracion.php?msgConfirm=Registro Eliminado&tareaAdmin=verCitasAdmin');
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE eliminarCitaAdmin()" . $e->getMessage();
        }
    }

    /*
        Elimina un registro en las tablas 'users_data y users_login' desde el rol 'admin'.
    */
    public static function eliminarUserAdmin($userAdmin) {
        try {
            $conexion = DB::conn();
            $sentencia = "DELETE FROM users_data WHERE idUser = :idUser";
            $consulta = $conexion->prepare($sentencia);
            $consulta->execute(array(":idUser" => $userAdmin));
            $consulta->closeCursor();
            $conexion = null;
            /** Redireccionar al 'usuario' a la página 'usuarios_administracion.php'. **/
            header('location:usuarios_administracion.php?msgConfirm=Registro Eliminado&tareaAdmin=verUsersAdmin');
        }catch(Exception $e) {
            echo "HA OCURRIDO UN ERROR EN EL PROCESO DE eliminarUserAdmin()" . $e->getMessage();
        }
    }
}
?>