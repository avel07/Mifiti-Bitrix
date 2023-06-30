// Форма регистрации
ChangePasswordForm = () => {
    const form = document.querySelector('form#change_password');
    if (form) {
        let form_result = form.querySelector('.form__result');
        let loginBlock = form.querySelector('.form__block[data-login]');
        app.bindEvent('click', 'form#change_password [type="submit"]', function (e) {
            e.preventDefault();
            let button = this;
            if (app.FormControl(button)) {
                button.classList.add('loading');
                button.setAttribute('disabled', '');

                let sendData = new FormData(form);
                sendData.append('action', form.dataset.action);

                app.FetchRequest('/local/ajax/change_password.php', sendData)
                    .then(data => {
                        button.classList.remove('loading');
                        button.removeAttribute('disabled');
                        form_result.classList.add('show');
                        // Reset капчи.
                        let captchaEl = document.querySelector('#recaptcha__changepass');
                        captchaEl
                            ? (grecaptcha.reset(captchaEl.dataset.captchaid), captchaEl.nextElementSibling.value = '')
                            : '';
                        if (data.status) {
                            form_result.innerHTML = data.data;
                            form.dataset.action = data.action;
                            form.querySelector('.g-recaptcha') ? form.querySelector('.g-recaptcha').parentElement.remove() : '';
                            if (data.action === 'checksms') {
                                loginBlock.querySelector('input[name="login"]').setAttribute('readonly', '');
                                loginBlock.insertAdjacentHTML('afterend', `
                            <div class="form__block" data-smscode>
                                <label class="form__label" for="change_smscode">Код из SMS</label>
                                    <input class="form__input" name="smscode" type="text" id="change_smscode" aria-required required>
                                <span class="form__error">Заполните обязательные поля</span>
                            </div>
                            `)
                                button.textContent = `Проверить код`;
                            }
                            else if (data.action === 'action') {
                                form.querySelector('[data-smscode]').remove();
                                loginBlock.insertAdjacentHTML('afterend', `
                            <div class="form__block">
                                <label class="form__label" for="change__password">Пароль</label>
                                <input class="form__input" type="password" name="password" id="change__password" aria-required
                                    placeholder="" required>
                                <span class="form__error">Заполните обязательные поля</span>
                            </div>
                            <div class="form__block">
                                <label class="form__label" for="change__confirm_password">Подтверждение пароля</label>
                                <input class="form__input" type="password" name="confirm_password" id="change__confirm_password" aria-required
                                    placeholder="" required>
                                <span class="form__error">Заполните обязательные поля</span>
                            </div>
                            `)
                                button.textContent = `Изменить пароль`;
                            }
                            else if (data.action === 'update') {
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                        }
                        form_result.innerHTML = data.data;
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
ChangePasswordForm();