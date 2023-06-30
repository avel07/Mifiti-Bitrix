        // Форма аутентификации
        AuthForm = () => {
            let form = document.querySelector('form#auth');
            if(form){
                let button = form.querySelector('button[type="submit"].header__personal--auth__submit');
                let form_result = form.querySelector('.form__result');
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (app.FormControl(button)) {
                        button.classList.add('loading');
                        button.setAttribute('disabled', '');
                        app.FetchRequest('/local/ajax/auth.php', new FormData(form))
                        .then(data => {
                            button.classList.remove('loading');
                            form_result.classList.add('show');
                            button.removeAttribute('disabled');
                            form_result.textContent = data.data;
                            if(data.status){
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
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
        AuthForm();