let datoSeleccionado = null;
let origen = null;
let destino = null;

const modalDelete = document.getElementById('modalDelete');

function abrirModalDelete() {
    modalDelete.style.display = 'block';
    modalDelete.showModal();
}

document.querySelectorAll('.btnEliminar').forEach(btn => {
    btn.addEventListener('click', (event) => {
        event.preventDefault();
        // Guarda los datos del botón pulsado
        datoSeleccionado = btn.getAttribute('data-dato');
        origen = btn.getAttribute('data-from');
        destino = btn.getAttribute('data-redirect');
        abrirModalDelete();
    });
});

document.getElementById('btnConfirmDelete').addEventListener('click', () => {
    fetch('../assets/admin/deleteAdmin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            eliminar: true,
            from: origen,
            dato: datoSeleccionado,
            csrf_token: CSRF_TOKEN // 🔐 aquí va el token
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = `${destino}?msgConfirm=Registro Eliminado&tareaAdmin=${origen}`;
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error de red: ' + error);
    });
});

// Botón cancelar: cierra modal
document.getElementById('btnCancel').addEventListener('click', () => {
    modalDelete.close();
    modalDelete.style.display = 'none';
});
