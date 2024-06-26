
document.addEventListener("DOMContentLoaded", function () {

    const confirmar_intento_modal = document.getElementById('confirmar_intento_modal');
    const comenzar_btn = document.getElementById('comenzar_btn');
    const close_intento_modal = document.getElementById('close_intento_modal');


    comenzar_btn.addEventListener('click', ()=>{
        confirmar_intento_modal.classList.remove('hidden');
    });
    
    close_intento_modal.addEventListener('click', () => {
        confirmar_intento_modal.classList.add('hidden');
    });
});

