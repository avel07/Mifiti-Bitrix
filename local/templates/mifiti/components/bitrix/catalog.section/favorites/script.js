favorites = () => {
    let catalog = document.querySelector('.catalog__items .row');
    if (catalog) {
        app.bindEvent('click', '.catalog__item--favorite', function () {
            let button = this;
            if (button.classList.contains('active')) {
                let parent = app.FindParent(button, document.querySelectorAll('.catalog__item'));
                parent.classList.add('hide');
                setTimeout(() => {
                    parent.parentElement.remove();
                }, 300);
            }
        })
        let observer = new MutationObserver(callback => {
            for (let mutation of callback) {
                if (mutation.target.children.length === 0) {
                    let empty = document.createElement('div');
                    empty.classList.add('catalog__empty');
                    let empty__body = `
                            <div class="container">
                                <div class="row">
                                    <h3>Товаров не найдено.</h3>
                                </div>
                            </div>`
                    document.querySelector('.catalog').remove();
                    document.querySelector('.content__wrap').appendChild(empty);
                    empty.innerHTML = empty__body;
                }
            }
        });
        observer.observe(catalog, {
            childList: true,
            subtree: true,
        });
    }
}
favorites();