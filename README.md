# trabajo-php-curso-masterd
Este proyecto es un trabajo obligatorio que realizé en 'Curso Superior en programación de páginas Web' matriculado en Febrero de 2022 en: Centro MasterD Valencia, perteneciente a (Instituto Tecnológico de MasterD / Zaragoza). Representa una clínica veterinaria ficticia y fue entregado el: 19/02/2023.

##Enunciado del Trabajo
Puedes encontrar el enunciado completo del trabajo [aquí](Enunciado PHP.pdf).
Es importante tener en cuenta que se trata de un proyecto ficticio utilizado con propósitos educativos y de práctica.

##Características
Utiliza base de datos:
Es importante destacar que este proyecto cuenta con una base de datos. Para garantizar el correcto funcionamiento del trabajo de PHP, se proporciona dicha base de datos en formato SQL (small_pets.sql) que contiene los datos necesarios para su funcionamiento. Esta base de datos se puede descargar junto al resto de archivos del proyecto desde [haciendo clic aquí](Code/Download ZIP).

'Es importante destacar que esta base de datos está diseñada exclusivamente para respaldar el funcionamiento del trabajo de PHP y no debe ser utilizada para ningún otro fin'

Requerimientos del servidor:
Para su correcto funcionamiento, el proyecto debe ser ejecutado desde un servidor. Por ejemplo, se recomienda utilizar XAMPP u otro servidor local para alojar la aplicación.

##Configuración del Entorno Local
Antes de ejecutar el proyecto en tu entorno local, necesitarás configurar tu servidor web y la base de datos. Sigue los pasos a continuación:

1. Asegúrate de tener XAMPP o un servidor web similar instalado en tu computadora.

2. Inicia el servidor de base de datos (MySQL) en XAMPP.

3. Completa las siguientes variables con la información de tu entorno local en el archivo .env.php del proyecto:

<?php
   const SERVIDOR = "localhost"; #// Manten 'localhost' si es local o cambialo por la dirección del servidor de tu base de datos.
   const BD = "small_pets"; #// Manten este 'nombre_base_de_datos' proporcionado en el repositorio para su correcta importación y funcionamiento.
   const USUARIO = "nombre_usuario"; #// Cambia 'nombre_usuario' por el nombre de usuario de tu base de datos.
   const PASSWORD = "contraseña"; #// Cambia 'contraseña' por la contraseña de tu base de datos.
?>

IMPORTANTE:
"La seguridad de las credenciales en un proyecto en producción es de suma importancia para proteger la integridad de los datos y la privacidad de los usuarios. Las credenciales, como nombres de usuario y contraseñas, proporcionan acceso privilegiado a sistemas y bases de datos críticas. La exposición inadvertida de estas credenciales puede resultar en brechas de seguridad devastadoras, comprometiendo la confidencialidad y la disponibilidad de la información. Por lo tanto, es fundamental implementar prácticas de seguridad robustas, como el almacenamiento seguro de credenciales, el uso de políticas de acceso adecuadas y la gestión cuidadosa de permisos. Además, es importante educar a todo el equipo sobre la importancia de mantener las credenciales confidenciales y evitar compartir información sensible en entornos no seguros. Proteger las credenciales es un componente esencial de cualquier estrategia de seguridad en el desarrollo y despliegue de aplicaciones en producción."
