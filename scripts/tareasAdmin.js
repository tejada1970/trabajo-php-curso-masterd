/* TAREAS ADMIN NOTICIAS */
const btnCerrarNoticias = document.querySelectorAll('.btnCerrarNoticias');
btnCerrarNoticias.forEach(element => {
    element.addEventListener('click', () => {
        location.href = "../wiews/noticias_administracion.php?tareaAdmin=verNoticiasAdmin";
    });
});

/* TAREAS ADMIN CITAS */
const btnCerrarCitas = document.querySelectorAll('.btnCerrarCitas');
btnCerrarCitas.forEach(element => {
    element.addEventListener('click', () => {
        location.href = "../wiews/citas_administracion.php?tareaAdmin=verCitasAdmin";
    });
});

/* TAREAS ADMIN USERS */
const btnCerrarUsers = document.querySelectorAll('.btnCerrarUsers');
btnCerrarUsers.forEach(element => {
    element.addEventListener('click', () => {
        location.href = "../wiews/usuarios_administracion.php?tareaAdmin=verUsersAdmin";
    });
});