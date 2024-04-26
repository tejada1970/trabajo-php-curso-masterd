/*
    CAMBIAR EL COLOR DE LOS HIPERVINCULOS (ENLACES INTERNOS), SEGÚN EN LA SECCIÓN QUE
    ME ENCUENTRE A MEDIDA QUE VOY ESCROLEANDO, O CADA VEZ QUE HAGA 'CLICK' EN UNO DE ELLOS.
*/

/* Aquí obtengo todos los hipervinculos (enlaces internos) cuyo atributo 'href' empiece por '#' */
let hipervinculos = document.querySelectorAll('#hipervinculos a[href^="#"]');

/*
    Uso la api 'IntersectionObserver' de javascript para el codigo del 'scroll'.
    Esto es para que al hecer 'scroll', me cambie automaticamente el color de los
    hipervinculos (enlaces internos), según en la sección en la que me encuentre.
*/
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {

        /* Aquí obtengo el valor de los atributos 'id' las secciones */
        const identificador = entry.target.getAttribute('id');

        /* Y aquí obtengo el valor el atributo 'href' del hipervinculo (enlace interno actual), mediante una interpolación */
        const hipervinculo = document.querySelector(`#hipervinculos a[href="#${identificador}"]`);

        /*
            Si la sección esta en el campo visual (viewport), añade al hipervinculo (enlace)
            correspondiente de la sección, la clase 'colorSelect'. Esta 'clase' la tengo en el (index.css).

            Cuando se intercepte una nueva sección, eliminará la clase 'colorSelect' al hipervinculo (enlace) anterior y se la dará
            al nuevo hipervinculo (enlace), en la sección que estemos ahora. Esto lo hará según bajemos o subamos el scroll.
        */
        if(entry.isIntersecting){
            document.querySelector('#hipervinculos a.colorSelect').classList.add('colorSelect');
            document.querySelector('#hipervinculos a.colorSelect').classList.remove('colorSelect');
            hipervinculo.classList.add('colorSelect');
        }
    });
}, {rootMargin: '-20% 0px -80% 0px'});
/*
    El 'rootMargin', es para no interceptar más de una sección al mismo tiempo.
    Crea una linea divisoria (que divide la raiz de la intersección por la mitad horizontalmente),
    en la que el 'color' del hipervinculo (enlace) no se cambiará hasta que se sobrepase esta linea.
*/

/* Aquí obtengo y selecciono el hipervinculo (enlace), al cual le quiero aplicar el 'observer' */
hipervinculos.forEach(hipervinculo => {

    /*
        Primero añado un evento 'click' a cada enlace interno, para eliminar la clase
        'colorSelect' a todos y darsela solo al hipervinculo (enlace) actual.
    */
    hipervinculo.addEventListener('click', function() {
        document.querySelector('#hipervinculos a.colorSelect').classList.remove('colorSelect');
        hipervinculo.classList.add('colorSelect');
    });

    const hash = hipervinculo.getAttribute('href');
    const target = document.querySelector(hash);
    
    if(target){
        observer.observe(target);
    }
});