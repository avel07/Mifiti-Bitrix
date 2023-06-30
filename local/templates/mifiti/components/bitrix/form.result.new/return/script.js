ReturnForm = () => {
    let form = document.querySelector('.return form');
    if(form){
        let button = form.querySelector('button[type="submit"].return__submit');
        let form_result = form.querySelector('.form__result');
        button.addEventListener('click', (e) => {
            e.preventDefault();
            if (app.FormControl(e.target)) {
                button.classList.add('loading');
                button.setAttribute('disabled', '');
                app.FetchRequest('/local/ajax/forms/form_return.php', new FormData(form))
                .then(data => {
                    button.classList.remove('loading');
                    form_result.classList.add('show');
                    button.removeAttribute('disabled');
                    form_result.textContent = data.text;
                    if(data.status){
                        let inputs = form.querySelectorAll('input.form__input:not([type="checkbox"])');
                        for(i=0;i<inputs.length;i++){
                            let input = inputs[i];
                            input.value = '';
                        }
                    }
                })
                .catch(error => {
                    button.classList.remove('loading');
                    button.removeAttribute('disabled');
                    form_result.classList.add('show');
                    form_result.textContent = `Ошибка в обработчике - ${error}`;
                })
            }
        })
    }
}
ReturnForm();