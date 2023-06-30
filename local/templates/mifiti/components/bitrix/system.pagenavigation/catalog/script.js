
Loadmore = () => {
    let content = document.querySelector('.content__wrap');
    // BindEvent - функция находится в app.js. Слушает клик по body. Для динамичных элементов.
    app.bindEvent('click', '.section__link--button', function(e) {
        let button = this;
        catalog = content.querySelector('.catalog'),
        catalog__block = content.querySelector('.catalog__items .row'),
        pager = content.querySelector('.pager');
        e.preventDefault();
        let url = button.href;
        // Отправим асинхронный fetch для следующей страницы
        button.classList.add('loading');
        fetch(url)
            // Получим text ответа.
            .then(response => response.text())
            .then(html => {
                // Спарсим наш текст с помощью Parser API.
                let parser = new DOMParser();
                // Переведем в document
                let response = parser.parseFromString(html, "text/html");
                return response;
            })
            // Сделаем функцию после парсинга.
            .then(response => {
                // Берем все спаршенные элементы каталога
                let items = response.querySelectorAll('.catalog__item')
                if(items){
                    // Вставляем в текущий каталог.
                    for (i = 0; i < items.length; i++) {
                        let item = items[i].parentElement;
                        catalog__block.append(item);
                    }
                }
                // Берем спаршенную пагинацию 
                new_pager = response.querySelector('.pager');
                if(new_pager){
                // Удаляем старую пагинацию.
                pager.remove();
                // Вставляем
                content.append(new_pager);
                }
            })
            // Обработка ошибки
            .catch(err => {
                console.log('Ошибка получения данных - ', err);
            });
    })

    app.bindEvent('click', '.pager__item a', function(e) {
        let button = this,
        catalog__block = content.querySelector('.catalog__items .row'),
        pager = content.querySelector('.pager');
        if(button.tagName === 'svg'){
            button = button.parentElement;
        }  
        if(button.tagName === 'path'){
            button = button.parentElement;
            button = button.parentElement;
        }
        e.preventDefault();
        let url = button.href;
        document.querySelector('.catalog__items').classList.add('loading');
        fetch(url)
        .then(response => response.text())
        .then(html => {
            // Спарсим наш текст с помощью Parser API.
            let parser = new DOMParser();
            // Переведем в document
            let response = parser.parseFromString(html, "text/html");
            return response;
        })
        .then(response => {
            let catalog__new = response.querySelector('.catalog__items .row'),
            pager__new = response.querySelector('.pager');
            if(catalog__new){
                console.log(catalog__block);
                catalog__block.remove();
                document.querySelector('.catalog__items').append(catalog__new);
                history.pushState(false, false, url);
            }
            if(pager__new){
                pager.remove();
                content.append(pager__new);
            }
            document.querySelector('.catalog__items').classList.remove('loading');
        })
            // Обработка ошибки
            .catch(err => {
                console.log('Ошибка получения данных - ', err);
            });
    })
}
Loadmore();