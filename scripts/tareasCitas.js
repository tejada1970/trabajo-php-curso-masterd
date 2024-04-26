/* CONTAINER TAREAS CITACIONES */
const btnCerrar = document.querySelectorAll('.btnCerrar');
btnCerrar.forEach(element => {
    element.addEventListener('click', () => {
        location.href = "../wiews/citaciones.php?tarea=tareas";
    });
});