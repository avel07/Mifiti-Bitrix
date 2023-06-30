        SearchForm = () => {
            let form = document.querySelector('form#catalog_search_form');
            if(form){
                let button = form.querySelector('button[type="submit"].catalog__search__submit');
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (app.FormControl(e.target)) {
                        form.submit();
                    }
                })
            }
        }
        SearchForm();