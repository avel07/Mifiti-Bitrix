//  Умный фильтр в каталоге.
filters = () => {
    const form = body.querySelector('.catalog__filter--form');
    let items = document.querySelectorAll('.catalog__filter--item__title');
    let open__filter = document.querySelector('.catalog__filter--open');
    let close__filter = document.querySelector('.catalog__filter--mob__close');
    if (items.length > 0) {
        for (i = 0; i < items.length; i++) {
            let item = items[i];
            let item__body = item.nextElementSibling;
            item.addEventListener('click', function (e) {
                if (window.innerWidth > 768) {
                    if (item__body.classList.contains('show') && this.classList.contains('show')) {
                        this.classList.remove('show')
                        item__body.classList.remove('show')
                        return false
                    }
                    for (j = 0; j < items.length; j++) {
                        if (items[j].nextElementSibling.classList.contains('show')) {
                            items[j].classList.remove('show');
                            items[j].nextElementSibling.classList.remove('show')
                        }
                    }
                    this.classList.add('show')
                    item__body.classList.add('show');
                }
                else if (window.innerWidth < 768) {
                    this.classList.toggle('collapsed');
                    let collapsed_block = this.nextElementSibling;
                    let collapse = new Collapse(collapsed_block);
                    collapse.toggle();
                }
            })
            document.addEventListener('click', (e) => {
                if (!e.composedPath().includes(document.querySelector('.catalog__filter--items') || !e.composedPath().includes(document.querySelector('.catalog__filter--mob')))) {
                    for (i = 0; i < items.length; i++) {
                        if (items[i].classList.contains('show') && items[i].nextElementSibling.classList.contains('show')) {
                            items[i].nextElementSibling.classList.remove('show');
                            items[i].classList.remove('show');
                        }
                    }
                }
            })
        }
    }
    if (open__filter) {
        open__filter.addEventListener('click', () => {
            body.classList.add('show__filter');
            app.LockScreen();
        })
    }
    if (close__filter) {
        close__filter.addEventListener('click', () => {
            for (i = 0; i < items.length; i++) {
                if (items[i].classList.contains('collapsed') && items[i].nextElementSibling.classList.contains('show')) {
                    items[i].nextElementSibling.classList.remove('show');
                    items[i].classList.remove('collapsed');
                }
            }
            body.classList.remove('show__filter');
            app.UnlockScreen();
        })
    }
    let selectedProperties = body.querySelectorAll('.catalog__filter--selected__item[data-filter]');
    if(selectedProperties){
        for(i = 0; i < selectedProperties.length; i++) {
            let item = selectedProperties[i];
            item.addEventListener('click', function() {
                let input = body.querySelector(`.catalog__filter--item__body--item input[name=${this.dataset.filter}]`);
                input.checked ? 
                (
                this.remove(),
                input.removeAttribute('checked'),
                body.querySelector('.catalog__filter--item__body--submit input[type="submit"]').click()
                )
                : console.log(`Ошибка - ${input} не checked!`)
            })
        }
    }
    let priceFilter = body.querySelector('.catalog__filter--selected__item[data-price-min][data-price-max]'),
    minPriceInput = body.querySelector('.catalog__filter--item__body--item__price input[data-min-price]'),
    maxPriceInput = body.querySelector('.catalog__filter--item__body--item__price input[data-max-price]');
    if(priceFilter){
        priceFilter.addEventListener('click', function(){
            this.remove();
            minPriceInput.value = minPriceInput.getAttribute('data-price-min');
            maxPriceInput.value = maxPriceInput.getAttribute('data-price-max');
            body.querySelector('.catalog__filter--item__body--submit input[type="submit"]').click();
        })

    }
}
filters();