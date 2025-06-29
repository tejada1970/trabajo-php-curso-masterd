<?php
    ob_start();
    session_start();

    // para la barra de navegación según inicie sesión USUARIO o ADMIN
    $_SESSION['header'] = null;

    // para el nombre de 'usuario' y darle la 'Bienvenida' en caso de que inicie sesión
    $_SESSION['nameUser'] = null;

    // compruebo si hay 'usuario'
    if (!isset($_SESSION['usuario'])) {
        // si no hay 'usuario', asigno la barra de navegación para VISITANTE.
        $_SESSION['header'] = 'headerVisit';
    }
    else {
        // si hay 'usuario', también compruebo su 'rol'.
        if (isset($_SESSION['usuario'])) {
            if(isset($_GET['msgConfirm'])) {
                if ($_GET['msgConfirm'] === 'okk') {
                    $_SESSION['nameUser'] = 'Bienvenid@ '.'<span class="spanBienvenida">'.$_SESSION["usuario"].'</span>'.'<br>'.' Has iniciado sesión en '.'<span class="spanBienvenida2">'.'Small Pets'.'</span>';
                }
            }
            // compruebo el 'rol'.
            if(isset($_SESSION['rol'])){
                switch($_SESSION['rol']){
                    case 'admin':
                        // asigno la barra de navegación para ADMIN.
                        $_SESSION['header'] = 'headerAdmin';
                    break;
        
                    case 'user':
                        // asigno la barra de navegación para USUARIO.
                        $_SESSION['header'] = 'headerUser';
                    break;
        
                    default;
                        // redirecciono al usuario a la página login.php para VISITANTES.
                        header('location: ./views/login.php');
                    break;
                }
            }
        }
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
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./assets/archivosHTML/footerHTML/footer.css">
</head>
<body id="bodyHiper">
    <?php
        // aquí incluyo la barra de navegación según sea (administrador, usuario o visitante).
        if ($_SESSION['header'] === 'headerAdmin') {
            include('./assets/archivosPHP/headerPHP/headerAdmin.php');
        }
        elseif ($_SESSION['header'] === 'headerUser') {
            include('./assets/archivosPHP/headerPHP/headerUser.php');
        }else {
            include('./assets/archivosPHP/headerPHP/headerVisit.php');
        }

        // aquí incluyo el contenedor de bienvenida.php, sea 'usuario' o 'administrador'.
        if ($_SESSION['header'] === 'headerAdmin' || $_SESSION['header'] === 'headerUser') {
            
            if(isset($_GET['msgConfirm'])) {
                if ($_GET['msgConfirm'] === 'okk') {
                    include('./assets/archivosPHP/bienvenida.php');
                }
            }
        }
    ?>
    <main>
        <div class="hipervinculos" id="hipervinculos">
            <div class="flex flexHiper">
                <div class="flex gap5">
                    <img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="#clinicas" class="linkHiper colorSelect">Clínicas</a>
                </div>
                <div class="flex gap5">
                    <img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="#tecnologia" class="linkHiper">Tecnología</a>
                </div>
                <div class="flex gap5">
                    <img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="#cirugia" class="linkHiper">Cirugía</a>
                </div>
                <div class="flex gap5">
                    <img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="#articulos" class="linkHiper">Articulos</a>
                </div>
                <div class="flex gap5">
                    <img src="./assets/icons/paw-solid.ico" alt="icono_huella" class="icon"><a href="#nosotros" class="linkHiper">Nosotros</a>
                </div>
                <div class="flex subir">
                    <a href="#bodyHiper" title="subir"><img src="./assets/icons/subir.png" alt="imagen_subir" class="icon"></a>
                </div>
            </div>
        </div>
        <div class="flex">
            <div class="section sectionClinicas w100" id="clinicas">
                <div class="separadorHipervinculo"></div>
                <article class="articulo flex mrgAuto pd20 gap20">
                    <div class="contenedor_thumbnail flex w100">
                        <div class="skewY"><img src="./assets/images/images_index/mapa_spain.png" alt="img_mapa_spain" width="640" height="458"></div>
                    </div>
                    <div class="contenedor_texto flex w100 pd20 gap20">
                        <p class="titulo w100">Nuestras Clínicas</p>
                        <p class="texto w100">Disponemos de más de 1.000 clínicas repartidas por todo nuestro país.</p>
                    </div>
                </article>
            </div>
            <hr>
            <div class="section sectionTecnologia w100" id="tecnologia">
                <div class="separadorHipervinculo"></div>
                <article class="articulo flex mrgAuto pd20 gap20">
                    <div class="contenedor_thumbnail flex w100 pd20">
                        <div class="skewY"><img src="./assets/images/images_index/pet_7.jpg" alt="img_radiografia_perro" width="1280" height="1111"></div>
                    </div>
                    <div class="contenedor_texto flex w100 pd20 gap20">
                        <p class="titulo w100">Nuestra Tecnología</p>
                        <p class="texto w100">Disponemos de los equipos más avanzados. Innovando cada día más, para estar a la altura.</p>
                    </div>
                </article>
            </div>
            <hr>
            <div class="section sectionCirugia w100" id="cirugia">
                <div class="separadorHipervinculo"></div>
                <article class="articulo flex mrgAuto pd20 gap20">
                    <div class="contenedor_thumbnail flex w100 pd20">
                        <div class="skewY"><img src="./assets/images/images_index/pet_5.jpg" alt="img_quirofano_gato" width="1280" height="854"></div>
                    </div>
                    <div class="contenedor_texto flex w100 pd20 gap20">
                        <p class="titulo w100">Cirugía</p>
                        <p class="texto w100">Disponemos de los mejores expertos cirujanos de todo el país, para nuestros animales.</p>
                    </div>
                </article>
            </div>
            <hr>
            <div class="sectionPetArticles" id="articulos">
                <div class="separadorHipervinculo"></div>
                <div class="flex">
                    <?php include('./assets/archivosPHP/articulosSmallPets.php') ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="section sectionPersonal" id="nosotros">
            <div class="separadorHipervinculo"></div>
            <article class="articulo flex gap20 mrgAuto lastArticle">
                <div class="contenedor_texto flex wh100 pd10">
                    <div>
                        <p class="titulo wh100 pd5">Nuestro Personal</p>
                        <p class="texto wh100 txtCenter"><br>Somos más de 3000 profesionales<br>dándolo todo en cada momento para el cuidado de tu mascota.</p>
                    </div>
                </div>
                <div class="contenedor_thumbnail flex">
                    <div><img src="./assets/images/images_index/pet_6.jpg" alt="img_veterinarios" width="1280" height="853" class="veterinarios skewY"></div>
                    <div><img src="./assets/images/images_index/pet_4.jpg" alt="img_veterinarios" width="1280" height="1135" class="veterinarios skewY"></div>
                    <div><img src="./assets/images/images_index/pet_8.jpg" alt="img_veterinarios" width="1280" height="1024" class="veterinarios skewY"></div>
                    <div><img src="./assets/images/images_index/pet_9.jpg" alt="img_veterinarios" width="1280" height="853" class="veterinarios skewY"></div>
                </div>
            </article>
        </div>
    </main>
    <!-- footer -->
    <footer class="footer">
        <div class="contenedor_img">
            <a href="#"><img src="./assets/archivosHTML/footerHTML/images/ilustracion_pajaro.png" alt="ilustracion_pajaro" width="1280" height="983"></a>
        </div>
        <div class="contenedor_texto">
            <div class="titulo">
                <span class="typed"></span>
            </div> 
            <div class="titulo cadenas_texto">
                <p>Trae a Small Pets <br> a tu <i class="mascota">Perro</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Gato</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Pez</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Conejo</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Tortuga</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Hámster</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Iguana</i></p>
                <p>Trae a Small Pets <br> a tu <i class="mascota">Pájaro</i></p>
            </div> 
            <p>Pídenos <span class="color_span">información</span> sin compromiso.<br>Nuestra mejor atención, <span class="color_span">a tu alcance</span>...</p>
            <p class="btnAvisoLegal"><a href="#">Aviso Legal</a></p>
            <div class="socials">
                <div>
                    <p>Visita nuestras redes sociales</p>
                    <a href="https://es-es.facebook.com/" target="_blank" title="enlace a facebook">
                        <img src="./assets/archivosHTML/footerHTML/images/facebook.png" alt="facebook" width="64" height="64">
                    </a>
                    <a href="https://www.instagram.com/?hl=es" target="_blank" title="enlace a instagram">
                        <img src="./assets/archivosHTML/footerHTML/images/instagram.png" alt="instagram" width="64" height="64">
                    </a>
                    <a href="https://www.youtube.com/" target="_blank" title="enlace a youtube">
                        <img src="./assets/archivosHTML/footerHTML/images/youtube.png" alt="youtube" width="64" height="64">
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <!-- scripts -->
    <script src="./scripts/scroll.js"></script>
    <script src="./scripts/burguer.js"></script>
    <script src="./scripts/avatarIndex.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
    <script src="./assets/archivosHTML/footerHTML/footer.js"></script>
</body>
</html>