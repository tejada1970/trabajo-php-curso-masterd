# trabajo-php-curso-masterd
Este proyecto es un trabajo obligatorio que realizé en 'Curso Superior en programación de páginas Web' matriculado en Febrero de 2022 en: Centro MasterD Valencia, perteneciente a (Instituto Tecnológico de MasterD / Zaragoza). Representa una clínica veterinaria ficticia y fue entregado el: 19/02/2023.

## Enunciado del Trabajo
Puedes encontrar el enunciado completo del trabajo [aquí](Enunciado PHP.pdf).

Es importante tener en cuenta que se trata de un proyecto ficticio utilizado con propósitos educativos y de práctica.

## Características
Utiliza base de datos:
Es importante destacar que este proyecto cuenta con una base de datos. Para garantizar el correcto funcionamiento del trabajo de PHP, se proporciona dicha base de datos en formato SQL (small_pets.sql) que contiene los datos necesarios para su funcionamiento. Esta base de datos se puede descargar junto al resto de archivos del proyecto desde [haciendo clic aquí](Code/Download ZIP).

'Es importante destacar que esta base de datos está diseñada exclusivamente para respaldar el funcionamiento del trabajo de PHP y no debe ser utilizada para ningún otro fin'

Requerimientos del servidor:
Para su correcto funcionamiento, el proyecto debe ser ejecutado desde un servidor. Por ejemplo, se recomienda utilizar XAMPP u otro servidor local para alojar la aplicación.

## Configuración del Entorno Local
Antes de ejecutar el proyecto en tu entorno local, necesitarás configurar tu servidor local y la base de datos. Sigue los pasos a continuación:

1. **Asegúrate de tener XAMPP o un servidor web similar instalado en tu computadora**.

2. **Proceso de Importación de la Base de Datos:**

    Para garantizar el funcionamiento correcto de la aplicación, es necesario importar la base de datos proporcionada. Sigue estos pasos detallados para realizar la importación correctamente:

    1. En Windows, accede al Panel de Control de XAMPP desde el menú de inicio (Inicio > XAMPP > XAMPP Control Panel) y ejecútalo como administrador para asegurarte de tener los permisos necesarios.

    2. Inicia tanto Apache como MySQL desde el panel de control. Estos son servicios esenciales para el servidor web y la base de datos, respectivamente.

    3. Después de iniciar MySQL, haz clic en el botón "Admin" junto a él para abrir la interfaz de phpMyAdmin en tu navegador web predeterminado.

    4. Dentro de phpMyAdmin, selecciona la opción "Base de datos" en la parte superior y crea una nueva base de datos con el nombre 'small_pets'.

    5. Regresa a la página principal de phpMyAdmin y selecciona la pestaña 'Importar'. Aquí, carga el archivo SQL proporcionado junto con los archivos del proyecto.

    6. Una vez cargado el archivo, haz clic en el botón 'Importar' para iniciar el proceso de importación. Este paso puede tomar un tiempo dependiendo del tamaño de la base de datos.

    7. Después de que la importación se complete con éxito, recibirás una confirmación en pantalla. Ahora la base de datos está lista para ser utilizada por la aplicación.

3. **Completa las siguientes variables con la información de tu entorno local en el archivo .env.php del proyecto:**
   
    - `SERVIDOR`: Mantén 'localhost' si es local o cámbialo por la dirección del servidor de tu base de datos.
    - `BD`: Mantén el nombre 'small_pets' proporcionado en el repositorio para su correcta importación y funcionamiento.
    - `USUARIO`: Cambia 'nombre_usuario' por el nombre de usuario de tu base de datos.
    - `PASSWORD`: Cambia 'contraseña' por la contraseña de tu base de datos.

    **Siguiendo estos pasos, habrás configurado correctamente tu entorno local y habrás importado la base de datos necesaria para el funcionamiento de la aplicación.**

4. **Visualización del Proyecto:** Abre tu navegador web y navega a (localhost/pon aquí el nombre de la carpeta del proyecto extraido), esto cargará el proyecto en tu navegador y podrás interactuar con él localmente. 

5. **IMPORTANTE:**
"La seguridad de las credenciales en un proyecto en producción es de suma importancia para proteger la integridad de los datos y la privacidad de los usuarios. Las credenciales, como nombres de usuario y contraseñas, proporcionan acceso privilegiado a sistemas y bases de datos críticas. La exposición inadvertida de estas credenciales puede resultar en brechas de seguridad devastadoras, comprometiendo la confidencialidad y la disponibilidad de la información. Por lo tanto, es fundamental implementar prácticas de seguridad robustas, como el almacenamiento seguro de credenciales, el uso de políticas de acceso adecuadas y la gestión cuidadosa de permisos. Además, es importante educar a todo el equipo sobre la importancia de mantener las credenciales confidenciales y evitar compartir información sensible en entornos no seguros. Proteger las credenciales es un componente esencial de cualquier estrategia de seguridad en el desarrollo y despliegue de aplicaciones en producción."
