"use strict";
document.addEventListener('DOMContentLoaded', () => {
    console.log('ts');
    let count_questions = 0;
    var actualContainer = document.getElementById('container-0');
    var csrfToken = document.getElementById('container-0');
    actualContainer.classList.remove('hidden');
    let nextBtn = document.getElementById('next-' + count_questions);
    nextBtn.addEventListener('click', (event) => {
        let dataxValue = event.target.getAttribute('datax');
        if (dataxValue !== null) {
            console.log(dataxValue);
        }
        actualContainer.classList.add('hidden');
        let data = {
            'respuesta_id': dataxValue,
        };
        fetch('/examenes/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.value
            },
            body: JSON.stringify(data)
        })
            .then(response => {
            if (!response.ok) {
                throw new Error('Error al enviar los datos');
            }
            return response.json();
        })
            .then(responseData => {
            if (responseData['msg'] == 'ok') {
                window.location.href = '/examenes';
            }
            console.log(responseData);
        });
        count_questions++;
    });
});
