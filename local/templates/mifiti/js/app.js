const body = document.body;
let captchaLoad = false;
const app = function () {
    return {
        init: () => {
            // Тут подключаются функции
            app?.Submenu(),
                app?.MobMenu(),
                app?.arrowTop(),
                app?.Basket(),
                app?.AddBasket(),
                app?.DeleteBasket(),
                app?.Personal(),
                app?.Search(),
                app?.ClickOutside(),
                app?.SearchForm(),
                app?.ReadMore(),
                app?.Favorites(),
                app?.Scrolled(),
                app?.ScrolltoObject(),
                app?.Collapse(),
                app?.Captcha?.render()
        },
        // Показать BackGround
        BackgroundShow: () => {
            body.classList.add('popup__show');
        },
        // Скрыть Background
        BackgroundHide: () => {
            body.classList.remove('popup__show');
        },
        arrowTop: () => {
            window.addEventListener('scroll', app.Throttle(() => {
                window.scrollY > 500
                    ? body.classList.add('show__arrow')
                    : body.classList.remove('show__arrow')
            }, 300))
        },
        // Работа с Background при вызове SubMenu
        Submenu: () => {
            let items = Array.from(document.querySelectorAll(".header__submenu")).map(i => i.parentNode);
            if (items) {
                for (i = 0; i < items.length; i++) {
                    items[i].addEventListener('mouseenter', () => {
                        app.BackgroundShow();
                    })
                    items[i].addEventListener('mouseleave', () => {
                        app.BackgroundHide();
                    })
                }
            }
        },
        // Работа с мобильным меню
        MobMenu: () => {
            let item__open = document.querySelector('.header__panel__mobile--navbar');
            let item__close = document.querySelector('.header__menu--mob__close');
            if (item__open) {
                item__open.addEventListener('click', app.MobMenuOpen);
            }
            if (item__close) {
                item__close.addEventListener('click', app.MobMenuClose);
            }
        },
        // Открываем мобильное меню
        MobMenuOpen: () => {
            body.classList.add('show__navbar');
            app.LockScreen();
        },
        // Закрываем мобильное меню
        MobMenuClose: () => {
            body.classList.remove('show__navbar');
            app.UnlockScreen();
        },
        // Работа с корзиной
        Basket: () => {
            // Закрываем открываем
            let item__open = document.querySelector('.header__panel__basket');
            let item__close = document.querySelector('.header__basket--close');
            if (item__open) {
                item__open.addEventListener('click', app.BasketOpen);
            }
            if (item__close) {
                item__close.addEventListener('click', app.BasketClose);
            }
        },
        // Открываем корзину
        BasketOpen: () => {
            body.classList.add('show__basket');
            app.LockScreen();
        },
        // Закрываем корзину
        BasketClose: () => {
            body.classList.remove('show__basket');
            app.UnlockScreen();
        },
        // Работа с пользователем.
        Personal: () => {
            let item__open = document.querySelector('.header__panel__personal:not(.active)');
            let item__close = document.querySelector('.header__personal--close');
            if (item__open) {
                item__open.addEventListener('click', app.PersonalOpen);
            }
            if (item__close) {
                item__close.addEventListener('click', app.PersonalClose);
            }
        },
        // Открываем пользователя.
        PersonalOpen: () => {
            body.classList.add('show__personal');
            app.LockScreen();
        },
        // Закрываем пользователя.
        PersonalClose: () => {
            body.classList.remove('show__personal');
            app.UnlockScreen();
        },
        // Работа с поиском
        Search: () => {
            let item__open = document.querySelector('.header__panel__search');
            let item__close = document.querySelector('.header__search--close');
            if (item__open) {
                item__open.addEventListener('click', app.SearchOpen);
            }
            if (item__close) {
                item__close.addEventListener('click', app.SearchClose);
            }
        },
        // Открываем поиск
        SearchOpen: () => {
            body.classList.add('show__search')
            app.LockScreen();
        },
        // Закрываем поиск
        SearchClose: () => {
            body.classList.remove('show__search');
            app.UnlockScreen();
        },
        // Блочим скролл 
        LockScreen: () => {
            body.style.paddingRight = window.innerWidth - document.getElementsByTagName('html')[0].clientWidth + 'px';
            body.classList.add('lock__screen');
        },
        // Разлочим скролл
        UnlockScreen: () => {
            body.style.paddingRight = null;
            body.classList.remove('lock__screen');
        },
        // Клик вне блока.
        ClickOutside: () => {
            let overlay = document.querySelector('.overlay__blur');
            if (overlay) {
                overlay.addEventListener('click', () => {
                    app.MobMenuClose();
                    app.BasketClose();
                    app.PersonalClose();
                    app.SearchClose();
                })
            }
        },
        // Форма поиска
        SearchForm: () => {
            let form = document.querySelector('form#search_form')
            let button = document.querySelector('button[type="submit"].header__search__submit');
            if (button) {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (app.FormControl(e.target)) {
                        form.submit();
                    }
                })
            }
        },
        //  Работа с избранными товарами.
        Favorites: () => {
            let favorites = document.querySelector('.header__panel__favorites');
            let count = document.querySelector('.favorites__quantity');
            app.bindEvent('click', '[data-favorite]', function () {
                let button = this;
                let id = button.dataset.favorite
                if (!button.classList.contains('active')) {
                    button.classList.add('active');
                    app.FetchRequest('/local/ajax/favorites.php', { 'action': 'add', 'id': id })
                        .then(data => {
                            if (!data.status) {
                                alert(data.text);
                                return false;
                            }
                            if (!favorites.classList.contains('active')) {
                                favorites.classList.add('active');
                            }
                            if (data.items !== 0) {
                                count.textContent = data.items;
                            }
                        });
                }
                else {
                    button.classList.remove('active');
                    app.FetchRequest('/local/ajax/favorites.php', { 'action': 'delete', 'id': id })
                        .then(data => {
                            if (!data.status) {
                                alert(data.text);
                                return false;
                            }
                            if (data.items === 0) {
                                favorites.classList.remove('active');
                                count.textContent = '';
                            }
                            else {
                                count.textContent = data.items;
                            }
                        });
                }
            })
        },
        // Для проверки форм (Если обратить внимание, то он находит родителей кнопки). Семантика обязательно должна быть соблюдена!!!
        FormControl: (item__submit) => {
            let result = [],
                find__error = false
            let children = Array.from(item__submit.parentElement);
            for (i = 0; i < children.length; i++) {
                if (children[i].hasAttribute('data-required')) {
                    if (children[i].value === '') {
                        children[i].classList.add('error');
                        result += false;
                    }
                    else if (children[i].type === 'checkbox' && !children[i].checked) {
                        children[i].classList.add('error');
                        result += false;
                    }
                    else {
                        children[i].classList.remove('error');
                        result += true;
                    }
                }
            }
            for (i = 0; i < children.length; i++) {
                if (children[i].classList.contains('error')) {
                    children[i].parentElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    return false;
                }
            }
            find__error = result.match(/false/);
            if (find__error === null) {
                find__error = true
            }
            else {
                find__error = false
            }
            return find__error;
        },
        // Читать полностью
        ReadMore: () => {
            let item = document.querySelectorAll('[data-readmore]');
            for (i = 0; i < item.length; i++) {
                item[i].addEventListener('click', (e) => {
                    if (e.target.textContent === e.target.dataset.readmore) {
                        e.target.textContent = 'Скрыть';
                    }
                    else if (e.target.classList.contains('collapsed')) {
                        e.target.textContent = e.target.dataset.readmore;
                    }
                })
            }
        },
        // Добавление элемента в корзину
        AddBasket: () => {
            app.bindEvent('click', '[data-basket]', function () {
                let item = this;
                let id = item.dataset.basket;
                let quantity = item.dataset.quantity;
                item.classList.toggle('loading');
                item.setAttribute('disabled', '');
                app.FetchRequest('/local/ajax/basket.php', { action: 'add', id: id, quantity: quantity })
                    .then(data => {
                        if (!data.status) {
                            alert(data.text);
                            return false;
                        }
                        else {
                            if (item.classList.contains('loading')) {
                                item.classList.toggle('loading');
                                item.removeAttribute('disabled');
                            }
                            else {
                                return false;
                            }
                        }
                        return data;
                    })
                    .then(data => {
                        data = data.BASKET
                        let order__value = document.querySelector('.header__basket--order__value');
                        order__value.innerHTML = (`${data.PRICE} р.`)
                        let header__panel__basket = document.querySelector('.header__panel__basket');
                        document.querySelector('.basket__quantity').innerHTML = (`${data.QUANTITY}`);
                        if (!header__panel__basket.classList.contains('active')) {
                            header__panel__basket.classList.add('active');
                        }
                        let order__block = document.querySelector('.header__basket--order');
                        if (data.QUANTITY > 0 && order__block.classList.contains('hide')) {
                            order__block.classList.remove('hide');
                        }
                        let basket = document.querySelector('.header__basket--items');
                        basket.innerHTML = ('');
                        for (i = 0; i < data.ITEMS.length; i++) {
                            let item = data.ITEMS[i];
                            basket.innerHTML += (`
                            <div class="header__basket--item show">
                            <div class="header__basket--item__image">
                                <img src="${item.PICTURE ? item.PICTURE : '/local/templates/mifiti/img/empty_photo.svg'}" alt="${item.NAME}">
                            </div>
                            <div class="header__basket--item__body">
                                <div class="header__basket--item__body--title">
                                    <div class="header__basket--item__body--name">
                                        <a href="${item.URL}"><span>${item.NAME}</span></a>
                                    </div>
                                    <div class="header__basket--item__body--delete" data-id="${item.ID}">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.00007 10.9997L10.9998 1" stroke="#1D1D1D" stroke-linecap="round"></path>
                                            <path d="M1.00007 1.00031L10.9998 11" stroke="#1D1D1D" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="header__basket--item__body--properties">
                                ${item.PROPERTIES.map(property =>
                                `<div class="header__basket--item__body--property">
                                <div class="header__basket--item__body--property__name">${property.NAME}</div>
                                <div class="header__basket--item__body--property__value">${property.VALUE}</div>                                    
                                </div>`
                            ).join('')}
                                </div>
                                <div class="header__basket--item__body--prices">
                                    <div class="header__basket--item__body--price ${item.SALE ? 'price__old' : ''}">
                                    ${item.BASE_PRICE} р.
                                    </div>
                                    ${item.SALE ? '<div class="header__basket--item__body--price price__discount">' + item.PRICE + ' р.</div>' : ''}
                                </div>
                            </div>
                        </div>`)
                        }
                    })
            })
        },
        // Удаление элемента из корзины
        DeleteBasket: () => {
            app.bindEvent('click', '.header__basket--item__body--delete', function () {
                let item = app.FindParent(this, document.querySelectorAll('.header__basket--item'));
                let collapse = new Collapse(item)
                collapse.hide();
                let id = this.dataset.id;
                app.FetchRequest('/local/ajax/basket.php', { action: 'delete', id: id })
                    .then(data => {
                        if (!data.status) {
                            collapse.show();
                            alert(data.text);
                            return false;
                        }
                        else {
                            let basket = document.querySelector('.header__basket--items');
                            let order__value = document.querySelector('.header__basket--order__value');
                            order__value.innerHTML = (`${data.BASKET.PRICE} р.`)
                            let header__panel__basket = document.querySelector('.header__panel__basket');
                            let order__block = document.querySelector('.header__basket--order');
                            if (data.BASKET.QUANTITY > 0) {
                                document.querySelector('.basket__quantity').innerHTML = (`${data.BASKET.QUANTITY}`);
                            }
                            else {
                                document.querySelector('.basket__quantity').innerHTML = ('');
                                if (header__panel__basket.classList.contains('active')) {
                                    header__panel__basket.classList.remove('active');
                                }
                                if (!order__block.classList.contains('hide')) {
                                    order__block.classList.add('hide')
                                }
                                basket.innerHTML = (`<h3>Ваша корзина пуста</h3>`)
                            }
                            // Убираем элемент из DOM
                            setTimeout(() => {
                                item.remove();
                            }, 350);
                        }
                    })
            })
        },
        // Проверим, мобилка ли
        IsMobile: () => {
            let check = false;
            (function (a) { if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true; })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        },
        // Если есть overflow в селекторе
        Scrolled: () => {
            let items = document.querySelectorAll('[data-scrolled]');
            Element.prototype.isOverflowing = function () {
                return this.scrollHeight > this.clientHeight || this.scrollWidth > this.clientWidth;
            }
            Element.prototype.isScrolled = function () {
                return this.scrollHeight - this.scrollTop === this.clientHeight
            }
            if (items.length > 0) {
                // Динамичный ResizeObserver для Корзины
                let observer = new ResizeObserver(app.Throttle((entries) => {
                    if (entries) {
                        for (let entry of entries) {
                            let position = entry.target.dataset.scrolled;
                            if (entry.target.scrollHeight > entry.target.clientHeight || entry.target.scrollWidth > entry.target.clientWidth) {
                                entry.target.nextElementSibling.dataset.scroll = position
                                entry.target.nextElementSibling.setAttribute('data-scroll', position)
                            }
                            else {
                                entry.target.nextElementSibling.dataset.scroll = ''
                            }
                        }
                    }
                }, 500));
                for (i = 0; i < items.length; i++) {
                    let item = items[i];
                    observer.observe(item);
                    item.addEventListener('scroll', app.Throttle(function () {
                        let position = item.dataset.scrolled
                        if (item.isScrolled()) {
                            item.nextElementSibling.dataset.scroll = ''
                        }
                        else {
                            item.nextElementSibling.dataset.scroll = position
                        }
                    }, 300))
                }
            }
        },
        // стандартный smooth скролл до объекта.
        ScrolltoObject: () => {
            let items = document.querySelectorAll('[data-scroll]');
            for (i = 0; i < items.length; i++) {
                let item = items[i];
                item.addEventListener('click', (e) => {
                    let link = item.dataset.scroll;
                    if (link === 'this') {
                        e.target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                    else {
                        document.querySelector(link).scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }

                })
            }
        },
        // Функция для Fetch запросов. Ошибки нужно рендерить через .error запроса, либо вызывать try/catch при запросе
        FetchRequest: (url, data) => {
            // Если это FormData.
            if (data.constructor.name === 'FormData') {
                let FormData = Object.fromEntries(data.entries());
                data = JSON.stringify(FormData);
            }
            else {
                data = JSON.stringify(data);
            }
            let RequestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: data,
            }
            return fetch(url, RequestOptions)
                .then(response => response.json())
        },
        // Игнорирует вызовы передаваемой функции пока не пройдет определенное ожидание
        Throttle: (func, ms) => {
            let locked = false
            return function () {
                if (locked) return
                const context = this
                const args = arguments
                locked = true
                setTimeout(() => {
                    func.apply(context, args)
                    locked = false
                }, ms)

            }
        },
        // Игнорирование вызовов передаваемой функции (resize, scroll, keydown)
        Debounce: function (func, ms, now) {
            let onLast
            return function () {
                const context = this
                const args = arguments
                const onFirst = now && !onLast
                clearTimeout(onLast)
                onLast = setTimeout(() => {
                    onLast = null
                    if (!now) func.apply(context, args)
                }, ms)
                if (onFirst) func.apply(context, args)
            }
        },
        // Находит родителя 
        // elem - сам элемент. Узел или Элемент Коллекции.
        // parents - NODE или COLLECTION родителей.
        FindParent: (elem, parents) => {
            for (i = 0; i < parents.length; i++) {
                let parent = parents[i];
                if (parent.contains(elem)) {
                    return parent;
                }
            }
            return false;
        },
        // Collapse как в Bootstrap
        Collapse: () => {
            let togglebuttons = document.querySelectorAll('[data-toggle="collapse"]');
            for (i = 0; i < togglebuttons.length; i++) {
                let target = togglebuttons[i];
                let toggletarget = togglebuttons[i].dataset.target;
                target.addEventListener('click', (e) => {
                    if (target.dataset.target === 'next') {
                        target.classList.toggle('collapsed');
                        let collapsed_block = target.nextElementSibling;
                        let collapse = new Collapse(collapsed_block);
                        collapse.toggle();
                    }
                    else {
                        target.classList.toggle('collapsed');
                        let collapsed_block = document.querySelector(toggletarget);
                        let collapse = new Collapse(collapsed_block);
                        collapse.toggle();
                    }
                })
            }
        },
        // Биндим event для динамичных селекторов.
        bindEvent: (eventNames, selector, handler) => {
            eventNames.split(' ').forEach((eventName) => {
                body.addEventListener(eventName, function (event) {
                    if (event.target.matches(selector + ', ' + selector + ' *')) {
                        handler.apply(event.target.closest(selector), arguments)
                    }
                }, false)
            })
        },
        // Добавляем скрипт через js. (для капчи)
        addScript: (src) => {
            let script = document.createElement('script');
            script.src = src;
            script.async = false; // Гарантируем порядок. 
            document.body.appendChild(script);
        },
        // Объект капчи. Тут собрана вся инфа про капчу
        Captcha: {
            Load: false,
            // Ссылка на капчу
            Link: 'https://www.google.com/recaptcha/api.js?onload=captchaRender&render=explicit',
            // Публичный ключ
            PublicKey: '6LfQzMImAAAAAL5NZPFToTfSoycOcyjIIlLOr2n1',
            // Callback после ввода капчи
            WordCallback: (response, selector) => {
                let formBlock = selector.parentElement;
                let input = formBlock.querySelector('[data-required]');
                input ? input.value = response : '';
            },
            // Массив объектов капчи. Просто добавляем сюда элемент. Даем ему ID, остальное само срендерится.
            Elements: [
                document.querySelector('#recaptcha__register'),
                document.querySelector('#recaptcha__changepass')
            ],
            // Функция рендера капчи только тогда, когда она попадает в область видимости)
            render: () => {
                if(app.Captcha.Elements.length > 0){
                // Создаем новый observer. 
                let observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting && !app.Captcha.Load) {
                            // Добавляем script капчи при показе формы.
                            app.addScript(app.Captcha.Link)
                            // Ставим флажок загрузки скрипта.
                            app.Captcha.Load = true;
                        }
                    });
                });
                for (i = 0; i < app.Captcha.Elements.length; i++) {
                    if(app.Captcha.Elements[i]){
                        observer.observe(app.Captcha.Elements[i]);
                    }
                }
                }
            }
        },
    }
}();

// Функция вызывается при рендере капч. Сразу снизу рендерится инфа о ID капчи и о ее заполнении, чтобы пропускать через formControl.
captchaRender = function () {
    if(app.Captcha.Elements.length > 0){
        for (i = 0; i < app.Captcha.Elements.length; i++) {
            if (app.Captcha.Elements[i]) {
                let item = app.Captcha.Elements[i];
                window.item = grecaptcha.render(item, {
                    'sitekey': app.Captcha.PublicKey,
                    'callback': function (response) {
                        app.Captcha.WordCallback(response, item)
                    },
                    'theme': 'light'
                });
                item.dataset.captchaid = window.item;
                item.insertAdjacentHTML('afterend', `
                <input class="form__input" data-captchaid="${window.item}" type="hidden" data-required required>
                <span class="form__error">Подтвердите, что вы не робот</span>
                `)
            }
        }
    }
};
// Вызываем функцию в строгом режиме.
document.addEventListener('DOMContentLoaded', () => {
    'use strict';
    app.init();
})
// HomeSlider
const homeSlider = new Swiper('.main__slider .swiper', {
    speed: 600, autoHeight: true, slidesPerView: 1, spaceBetween: 0, slideActiveClass: 'active',
    navigation: { nextEl: '.main__slider .main__slider--next', prevEl: '.main__slider .main__slider--prev' },
    autoplay: { delay: 6000 }
});
// Slider для списка разделов каталога.
const homeSection = new Swiper('.catalog__section .swiper', {
    speed: 600, slidesPerView: 3, spaceBetween: 7, slideActiveClass: 'active', freeMode: true,
    navigation: { nextEl: '.catalog__section .catalog__section__slider--next', prevEl: '.catalog__section .catalog__section__slider--prev', disabledClass: 'disabled' },
    breakpoints: {
        0: {
            slidesPerView: 'auto',
            spaceBetween: 5,
        },
        576: {
            slidesPerView: 2,
            spaceBetween: 5,
        },
        992: {
            slidesPerView: 3,
            spaceBetween: 7
        }
    }
});
// // ScreenLock Для iPhone, но надо потестировать.
// let screen__lock = false;
// let bodyScrollTop = null;
// // Открываем
// if (!screen__lock) {
//     bodyScrollTop = (typeof window.scrollY !== 'undefined') ? window.scrollY : (document.documentElement || body.parentNode || body).scrollTop;
//     body.classList.add('lock__screen');
//     body.style.top = `-${bodyScrollTop}px`;
//     body.style.paddingRight = window.innerWidth - document.getElementsByTagName('html')[0].clientWidth + 'px';
//     screen__lock = true;
// };
// // Закрываем
// if (screen__lock) {
//     body.classList.remove('lock__screen');
//     body.style.top = null;
//     window.scrollTo(0, bodyScrollTop);
//     body.style.paddingRight = null;
//     screen__lock = false;
// }