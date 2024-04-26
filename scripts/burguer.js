/* BURGUER */
const abrirCerrar_menu = document.querySelector('.abrirCerrar_menu');
const navigator = document.querySelector('.nav');

abrirCerrar_menu.addEventListener('click', () => {
    abrirCerrar_menu.classList.toggle('close');
    navigator.classList.toggle('show');
});