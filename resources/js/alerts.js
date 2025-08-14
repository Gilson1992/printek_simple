const alertaSucesso = (message) => {
    Swal.fire({
        icon: 'success',
        html: message,
        toast: true,
        position: 'top-end',
        timer: 2500,
        timerProgressBar: true,
        showConfirmButton: false,
    });
};

const alertaFalha = (message) => {
    Swal.fire({
        icon: 'error',
        html: message,
        toast: true,
        position: 'top-end',
        timer: 2500,
        timerProgressBar: true,
        showConfirmButton: false,
    });
};

const alertaDelete = (id, message, eventName = 'deleteRow') => {
    Swal.fire({
        icon: 'warning',
        html: message,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sim',
        focusCancel: true,
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch(eventName, { id });
        }
    });
};

export { alertaSucesso, alertaFalha, alertaDelete };
