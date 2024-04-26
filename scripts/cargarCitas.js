/*
    Función para obtener el objeto 'ajax' según el navegador que se este utilizando.
*/
function getHTTPObject(){
    if (window.ActiveXObject) 
        return new ActiveXObject("Microsoft.XMLHTTP");
    else if (window.XMLHttpRequest) 
        return new XMLHttpRequest();
    else {
        alert("Objeto no soportado");
        return null;
    }
}

// Función para obtener los datos de las citas.
function cargarCitas(){

    const tdCita = document.getElementById('tdCita');
    var misCitas = [];

    var httpObject = false;

    // Recoger el objeto 'ajax' de la función getHTTPObject().
    httpObject = getHTTPObject();

    if (httpObject != null) {

        // Abrir la conexión con el servidor, especificando 'el metodo del envio, la ubicación del archivo y de forma asincrona=true'.
        httpObject.open("GET", "../assets/archivosPHP/obtenerCitasAjax.php", true);

        // Función de espera para la carga del archivo.
        httpObject.onreadystatechange = function() {

            // Compruebar que la carga esta completada.
            if(httpObject.readyState == 4) {

                // Utilizo 'split' y un 'separador' llamado 'separador' para dividir las citas que voy obteniendo en 'obtenerCitas.php'.
                misCitas = httpObject.responseText.split('separador');

                // Recorro el array de las citas, y utilizo un 'substring' para extraer por separado la 'fecha_cita' y el 'motivo_cita'.
                for(k=0;k<misCitas.length;k++) {
                    tdCita.innerHTML += '<br><br>' + misCitas[k].substring(0, 10) + '<br>' + misCitas[k].substring(10, misCitas[k].length) + '<br>';
                }
            }    
        }
        // Enviar petición al servidor.
        httpObject.send(null);
    }
}