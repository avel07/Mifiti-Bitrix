let swiperThumbsParams = {
    direction: 'vertical',
    slidesPerView: 5,
    spaceBetween: 4,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
}

let catalogElementsSwiperThumbs = new Swiper('.catalog__element--gallery__thumbs .swiper', swiperThumbsParams);

let swiperParams = {
    slidesPerView: 1,
    thumbs: {
        swiper: catalogElementsSwiperThumbs,
        slideThumbActiveClass: 'active',
    },
    pagination: {
        el: '.swiper-pagination',
    },
    navigation: { prevEl: '.catalog__element--gallery__prev', nextEl: '.catalog__element--gallery__next', disabledClass: 'disabled' },
}

let catalogElementsSwiper = new Swiper('.catalog__element--gallery__images .swiper', swiperParams);


let count = 0;
// Изменить количество товара 
let ChangeQuantity = () => {
    let minus = document.querySelectorAll('.quantity__minus'),
        plus = document.querySelectorAll('.quantity__plus'),
        input = document.querySelectorAll('.quantity__input'),
        basket = document.querySelector('[data-basket]');
    if (plus && minus) {
        for (i = 0; i < minus.length; i++) {
            minus[i].addEventListener('click', (e) => {
                let input = e.target.nextElementSibling
                let count = parseInt(input.value) - 1
                count = count < 1 ? 1 : count
                input.value = count;
                input.dispatchEvent(new Event('change'));
            })
            plus[i].addEventListener('click', (e) => {
                let input = e.target.previousElementSibling
                let count = parseInt(input.value) + 1
                input.value = count
                input.dispatchEvent(new Event('change'));
            })
            input[i].addEventListener('change', function () {
                basket.dataset.quantity = this.value;
            })
        }
    }
}
ChangeQuantity();


// Анонимная функция для смены ТП.
(function (window) {
    'use strict';

    if (window.JCCatalogElement) return;

    window.JCCatalogElement = function (arParams) {
        this.config = {
            showAbsent: false
        };
        this.errorCode = 0;

        if (typeof arParams === 'object') {
            this.params = arParams;
            this.initConfig();
            this.initOffersData();
        }

        if (this.errorCode === 0) {
            BX.ready(BX.delegate(this.init, this));
        }

        this.params = {};
    };

    window.JCCatalogElement.prototype = {


        getEntity: function (parent, entity, additionalFilter) {
            if (!parent || !entity)
                return null;

            additionalFilter = additionalFilter || '';

            return parent.querySelector(additionalFilter + '[data-entity="' + entity + '"]');
        },

        getEntities: function (parent, entity, additionalFilter) {
            if (!parent || !entity)
                return { length: 0 };

            additionalFilter = additionalFilter || '';

            return parent.querySelectorAll(additionalFilter + '[data-entity="' + entity + '"]');
        },

        setOffer: function (offerNum) {
            this.offerNum = parseInt(offerNum);
            this.setCurrent();
        },
        init: function () {
            var i = 0,
                treeItems = null;

            if (this.productType === 3) {
                if (this.visual.TREE_ID) {
                    this.obTree = BX(this.visual.TREE_ID);
                    if (!this.obTree) {
                        this.errorCode = -256;
                    }
                }
            }

            if (this.errorCode === 0) {
                switch (this.productType) {
                    case 0: // no catalog
                    case 1: // product
                    case 2: // set
                    case 3: // sku
                        if (this.obTree) {
                            treeItems = this.obTree.querySelectorAll('.catalog__element--info__sku--property__item');
                            for (i = 0; i < treeItems.length; i++) {
                                // bind для this.
                                BX.bind(treeItems[i], 'click', BX.delegate(this.selectOfferProp, this));
                            }
                            this.setCurrent();
                            break;
                        }
                }
            }
        },
        // Получаем данные параметров
        initConfig: function () {
            if (this.params.PRODUCT_TYPE) {
                this.productType = parseInt(this.params.PRODUCT_TYPE, 10);
            }
            if (this.params.MAIN_BLOCK_OFFERS_PROPERTY_CODE) {
                this.mainBlockOffersPropertyCode = BX.util.array_keys(this.params.MAIN_BLOCK_OFFERS_PROPERTY_CODE);
            }
            this.visual = this.params.VISUAL;
        },
        // Получаем данные оффера
        initOffersData: function () {
            if (this.params.OFFERS && BX.type.isArray(this.params.OFFERS)) {
                this.offers = this.params.OFFERS;
                this.offerNum = 0;

                if (this.params.OFFER_SELECTED) {
                    this.offerNum = parseInt(this.params.OFFER_SELECTED, 10) || 0;
                }

                if (this.params.TREE_PROPS) {
                    this.treeProps = this.params.TREE_PROPS;
                }
            }
            else {
                this.errorCode = -1;
            }
        },
        selectOfferProp: function () {
            var i = 0,
                strTreeValue = '',
                arTreeItem = [],
                rowItems = null,
                target = BX.proxy_context;

            if (target && target.hasAttribute('data-treevalue')) {
                if (BX.hasClass(target, 'active'))
                    return;

                if (typeof document.activeElement === 'object') {
                    document.activeElement.blur();
                }

                strTreeValue = target.getAttribute('data-treevalue');
                arTreeItem = strTreeValue.split('_');
                this.searchOfferPropIndex(arTreeItem[0], arTreeItem[1]);
                rowItems = BX.findChildren(target.parentNode, { class: 'catalog__element--info__sku--property__item' }, false);

                if (rowItems && rowItems.length) {
                    for (i = 0; i < rowItems.length; i++) {
                        BX.removeClass(rowItems[i], 'active');
                    }
                }
                BX.addClass(target, 'active');
            }
        },
        // Фильтрация по группам.
        searchOfferPropIndex: function (strPropID, strPropValue) {
            var strName = '',
                arShowValues = false,
                arCanBuyValues = [],
                allValues = [],
                index = -1,
                i, j,
                arFilter = {},
                tmpFilter = [];

            for (i = 0; i < this.treeProps.length; i++) {
                if (this.treeProps[i].ID === strPropID) {
                    index = i;
                    break;
                }
            }

            if (index > -1) {
                for (i = 0; i < index; i++) {
                    strName = 'PROP_' + this.treeProps[i].ID;
                    arFilter[strName] = this.selectedValues[strName];
                }

                strName = 'PROP_' + this.treeProps[index].ID;
                arFilter[strName] = strPropValue;

                for (i = index + 1; i < this.treeProps.length; i++) {
                    strName = 'PROP_' + this.treeProps[i].ID;
                    arShowValues = this.getRowValues(arFilter, strName);

                    if (!arShowValues)
                        break;

                    allValues = [];

                    if (this.config.showAbsent) {
                        arCanBuyValues = [];
                        tmpFilter = [];
                        tmpFilter = BX.clone(arFilter, true);

                        for (j = 0; j < arShowValues.length; j++) {
                            tmpFilter[strName] = arShowValues[j];
                            allValues[allValues.length] = arShowValues[j];
                            if (this.getCanBuy(tmpFilter))
                                arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
                        }
                    }
                    else {
                        arCanBuyValues = arShowValues;
                    }

                    if (this.selectedValues[strName] && BX.util.in_array(this.selectedValues[strName], arCanBuyValues)) {
                        arFilter[strName] = this.selectedValues[strName];
                    }
                    else {
                        if (this.config.showAbsent) {
                            arFilter[strName] = (arCanBuyValues.length ? arCanBuyValues[0] : allValues[0]);
                        }
                        else {
                            arFilter[strName] = arCanBuyValues[0];
                        }
                    }

                    this.updateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
                }

                this.selectedValues = arFilter;
                this.changeInfo();
            }
        },
        // Обновить список в группе свойств.
        updateRow: function (intNumber, activeId, showId, canBuyId) {
            var i = 0,
                value = '',
                isCurrent = false,
                rowItems = null;

            var lineContainer = this.getEntities(this.obTree, 'sku-line-block');
            if (intNumber > -1 && intNumber < lineContainer.length) {
                rowItems = lineContainer[intNumber].querySelectorAll('.catalog__element--info__sku--property__item');
                for (i = 0; i < rowItems.length; i++) {
                    value = rowItems[i].getAttribute('data-onevalue');
                    isCurrent = value === activeId;
                    if (isCurrent) {
                        BX.addClass(rowItems[i], 'active');
                    }
                    else {
                        BX.removeClass(rowItems[i], 'active');
                    }

                    if (BX.util.in_array(value, canBuyId)) {
                        BX.removeClass(rowItems[i], 'notallowed');
                    }
                    else {
                        if (rowItems.length == i + 1) {
                            lineContainer[intNumber].parentElement.style.display = 'none';
                        }
                        else {
                            lineContainer[intNumber].parentElement.style.display = '';
                        }
                        BX.addClass(rowItems[i], 'notallowed');
                    }
                    rowItems[i].style.display = BX.util.in_array(value, showId) ? '' : 'none';

                    if (isCurrent) {
                        lineContainer[intNumber].style.display = (value == 0 && canBuyId.length == 1) ? 'none' : '';
                    }
                }
            }
        },
        // Получить список из свойства
        getRowValues: function (arFilter, index) {
            var arValues = [],
                i = 0,
                j = 0,
                boolSearch = false,
                boolOneSearch = true;

            if (arFilter.length === 0) {
                for (i = 0; i < this.offers.length; i++) {
                    if (!BX.util.in_array(this.offers[i].TREE[index], arValues)) {
                        arValues[arValues.length] = this.offers[i].TREE[index];
                    }
                }
                boolSearch = true;
            }
            else {
                for (i = 0; i < this.offers.length; i++) {
                    boolOneSearch = true;

                    for (j in arFilter) {
                        if (arFilter[j] !== this.offers[i].TREE[j]) {
                            boolOneSearch = false;
                            break;
                        }
                    }

                    if (boolOneSearch) {
                        if (!BX.util.in_array(this.offers[i].TREE[index], arValues)) {
                            arValues[arValues.length] = this.offers[i].TREE[index];
                        }

                        boolSearch = true;
                    }
                }
            }

            return (boolSearch ? arValues : false);
        },
        getCanBuy: function (arFilter) {
            var i,
                j = 0,
                boolOneSearch = true,
                boolSearch = false;

            for (i = 0; i < this.offers.length; i++) {
                boolOneSearch = true;

                for (j in arFilter) {
                    if (arFilter[j] !== this.offers[i].TREE[j]) {
                        boolOneSearch = false;
                        break;
                    }
                }

                if (boolOneSearch) {
                    if (this.offers[i].CAN_BUY) {
                        boolSearch = true;
                        break;
                    }
                }
            }

            return boolSearch;
        },
        // Устанавливаем текущий оффер.
        setCurrent: function () {
            var i,
                j = 0,
                strName = '',
                arShowValues = false,
                arCanBuyValues = [],
                arFilter = {},
                tmpFilter = [],
                current = this.offers[this.offerNum].TREE;

            for (i = 0; i < this.treeProps.length; i++) {
                strName = 'PROP_' + this.treeProps[i].ID;
                arShowValues = this.getRowValues(arFilter, strName);

                if (!arShowValues)
                    break;

                if (BX.util.in_array(current[strName], arShowValues)) {
                    arFilter[strName] = current[strName];
                }
                else {
                    arFilter[strName] = arShowValues[0];
                    this.offerNum = 0;
                }

                if (this.config.showAbsent) {
                    arCanBuyValues = [];
                    tmpFilter = [];
                    tmpFilter = BX.clone(arFilter, true);

                    for (j = 0; j < arShowValues.length; j++) {
                        tmpFilter[strName] = arShowValues[j];

                        if (this.getCanBuy(tmpFilter)) {
                            arCanBuyValues[arCanBuyValues.length] = arShowValues[j];
                        }
                    }
                }
                else {
                    arCanBuyValues = arShowValues;
                }

                this.updateRow(i, arFilter[strName], arShowValues, arCanBuyValues);
            }

            this.selectedValues = arFilter;
            this.changeInfo();
        },
        // Что делаем при обновлении оффера.
        updateOfferData: function (offer) {
            if (offer.CAN_BUY) {
                // Переменные
                let id = offer.ID,
                    images = offer.PROPERTIES.MORE_PHOTO.DATA ? offer.PROPERTIES.MORE_PHOTO.DATA : '',
                    thumbs = offer.PROPERTIES.MORE_PHOTO.THUMBS ? offer.PROPERTIES.MORE_PHOTO.THUMBS : '',
                    seo = offer.SEO,
                    basePrice = offer.ITEM_PRICES[0].BASE_PRICE ? offer.ITEM_PRICES[0].BASE_PRICE : '',
                    price = offer.ITEM_PRICES[0].PRICE ? offer.ITEM_PRICES[0].PRICE : '',
                    discount = offer.ITEM_PRICES[0].DISCOUNT ? offer.ITEM_PRICES[0].DISCOUNT : '',
                    showDiscount = discount > 0,
                    // Кнопка
                    basketBtn = document.querySelector('[data-basket]'),
                    // Блок цен
                    priceBlock = document.querySelector('.catalog__element--info__prices'),
                    // Блок галереги
                    galleryBlock = document.querySelector('.catalog__element--gallery__images'),
                    // Блок миниатюр
                    thumbsBlock = document.querySelector('.catalog__element--gallery__thumbs');

                basketBtn.dataset.basket = id;
                if (basketBtn.disabled) {
                    basketBtn.disabled = false;
                }
                // Если в ТП цена со скидкой
                if (showDiscount) {
                    priceBlock.innerHTML = (`
                    <meta itemprop="priceCurrency" content="RUB"/>
                    <div class="catalog__element--info__price price__old">
                        ${basePrice} р.
                    </div>
                    <div class="catalog__element--info__price price__discount" itemprop="price" content="${price}">
                        ${price} р.
                    </div>
                    `)
                }
                else {
                    priceBlock.innerHTML = (`
                    <meta itemprop="priceCurrency" content="RUB"/>
                    <div class="catalog__element--info__price catalog__item--price" itemprop="price" content="${basePrice}">
                        ${basePrice} р.
                    </div>
                    `)
                }
                // Инициализация миниатюр
                if (thumbs.length >= 5) {
                    thumbsBlock.innerHTML = (`
                    <div class="swiper">
                        <div class="swiper-wrapper catalog__element--gallery__thumbs--wrapper">
                            ${thumbs.map(thumb => `
                            <div class="swiper-slide catalog__element--gallery__thumb">
                                <img src="${thumb.SRC}" alt="${seo.ELEMENT_DETAIL_PICTURE_FILE_ALT} title="${seo.ELEMENT_DETAIL_PICTURE_FILE_TITLE}"
                                height="200px" width="133px"
                                >
                            </div>
                            `).join('')}
                        </div>
                    <div class="catalog__element--gallery__prev">
                        <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M28.4286 13L14.7143 1L1.00002 13" stroke="#1D1D1D"/>
                        </svg>
                        <div class="background__gradient"></div>
                    </div>
                    <div class="catalog__element--gallery__next">
                        <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L14.7143 13L28.4286 1" stroke="#1D1D1D"/>
                        </svg>
                        <div class="background__gradient"></div>
                    </div>
                    </div>
                    `)
                    // catalogElementsSwiperThumbs.destroy();
                    catalogElementsSwiperThumbs = new Swiper('.catalog__element--gallery__thumbs .swiper', swiperThumbsParams);
                }
                else if (thumbs.length > 1) {
                    thumbsBlock.innerHTML = (`
                    <div class="swiper">
                        <div class="swiper-wrapper catalog__element--gallery__thumbs--wrapper">
                            ${thumbs.map(thumb => `
                            <div class="swiper-slide catalog__element--gallery__thumb">
                                <img src="${thumb.SRC}" alt="${seo.ELEMENT_DETAIL_PICTURE_FILE_ALT} title="${seo.ELEMENT_DETAIL_PICTURE_FILE_TITLE}"
                                height="200px" width="133px"
                                >
                            </div>
                            `).join('')}
                        </div>
                    </div>
                    `)
                    catalogElementsSwiperThumbs = new Swiper('.catalog__element--gallery__thumbs .swiper', swiperThumbsParams);
                }
                else {
                    thumbsBlock.innerHTML = (``)
                }
                if (images && images.length > 0) {
                    galleryBlock.innerHTML = (`
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            ${images.map(image => `
                                <div class="swiper-slide catalog__element--gallery__image">
                                    <a href="${image.SRC}?>" data-fancybox="gallery">
                                        <img src="${image.SRC}" itemprop="image" alt="${seo.ELEMENT_DETAIL_PICTURE_FILE_ALT} title="${seo.ELEMENT_DETAIL_PICTURE_FILE_TITLE}
                                        width="${image.WIDTH}" height="${image.HEIGHT}"
                                        >
                                    </a>
                                </div>
                                `).join('')}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    `)
                    catalogElementsSwiper.destroy();
                    // Напишем еще раз, потому что в любом случае необходимо будет переопределить параметры для миниатюр.
                    catalogElementsSwiper = new Swiper('.catalog__element--gallery__images .swiper', {
                        slidesPerView: 1,
                        thumbs: {
                            swiper: catalogElementsSwiperThumbs,
                            slideThumbActiveClass: 'active',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                        },
                        navigation: { prevEl: '.catalog__element--gallery__prev', nextEl: '.catalog__element--gallery__next', disabledClass: 'disabled' },
                    });
                }
                else {
                    galleryBlock.innerHTML = (`
                    <div class="swiper-slide catalog__element--gallery__image">
                        <img src="/local/templates/mifiti/img/empty_photo_big.svg" alt="Пустое фото"
                        width="279"
                        height="382"
                        >
                    </div>
                    `)
                }
            }
            else if (!offer.CAN_BUY) {
                // Переменные
                let id = offer.ID,
                    seo = offer.SEO,
                    images = offer.PROPERTIES.MORE_PHOTO.SRC,
                    thumbs = offer.PROPERTIES.MORE_PHOTO.THUMBS,
                    // Кнопка
                    basketBtn = document.querySelector('[data-basket]'),
                    // Блок цен
                    priceBlock = document.querySelector('.catalog__element--info__prices'),
                    // Блок галереги
                    galleryBlock = document.querySelector('.catalog__element--gallery__images'),
                    // Блок миниатюр
                    thumbsBlock = document.querySelector('.catalog__element--gallery__thumbs');
                // Действия
                basketBtn.dataset.basket = id;
                if (!basketBtn.disabled) {
                    basketBtn.disabled = true;
                }
                priceBlock.innerHTML = (`
                    <div class="catalog__element--info__price price__discount">
                    Товар недоступен к покупке
                    </div>
                    `)
                // Инициализация миниатюр
                if (thumbs.length >= 5) {
                    thumbsBlock.innerHTML = (`
                    <div class="swiper">
                        <div class="swiper-wrapper catalog__element--gallery__thumbs--wrapper">
                            ${thumbs.map(thumb => `
                            <div class="swiper-slide catalog__element--gallery__thumb">
                                <img src="${thumb.SRC}" alt="${seo.ELEMENT_DETAIL_PICTURE_FILE_ALT} title="${seo.ELEMENT_DETAIL_PICTURE_FILE_TITLE}
                                height="200px" width="133px"
                                >
                            </div>
                            `).join('')}
                        </div>
                        <div class="catalog__element--gallery__prev">
                        <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M28.4286 13L14.7143 1L1.00002 13" stroke="#1D1D1D"/>
                        </svg>
                        <div class="background__gradient"></div>
                        </div>
                        <div class="catalog__element--gallery__next">
                            <svg width="29" height="14" viewBox="0 0 29 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L14.7143 13L28.4286 1" stroke="#1D1D1D"/>
                            </svg>
                            <div class="background__gradient"></div>
                        </div>
                    </div>
                    `)
                    // catalogElementsSwiperThumbs.destroy();
                    catalogElementsSwiperThumbs = new Swiper('.catalog__element--gallery__thumbs .swiper', swiperThumbsParams);
                }
                else if (thumbs.length > 1) {
                    thumbsBlock.innerHTML = (`
                    <div class="swiper">
                        <div class="swiper-wrapper catalog__element--gallery__thumbs--wrapper">
                            ${thumbs.map(thumb => `
                            <div class="swiper-slide catalog__element--gallery__thumb">
                                <img src="${thumb.SRC}" alt="${seo.ELEMENT_DETAIL_PICTURE_FILE_ALT} title="${seo.ELEMENT_DETAIL_PICTURE_FILE_TITLE}
                                height="200px" width="133px"
                                >
                            </div>
                            `).join('')}
                        </div>
                    </div>
                    `)
                    catalogElementsSwiperThumbs = new Swiper('.catalog__element--gallery__thumbs .swiper', swiperThumbsParams);
                }
                else {
                    thumbsBlock.innerHTML = (``)
                }
                if (images && images.length > 0) {
                    galleryBlock.innerHTML = (`
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            ${images.map(image => `
                                <div class="swiper-slide catalog__element--gallery__image">
                                    <a href="${image.SRC}" data-fancybox="gallery">
                                        <img src="${image.SRC}" alt="${seo.ELEMENT_DETAIL_PICTURE_FILE_ALT} title="${seo.ELEMENT_DETAIL_PICTURE_FILE_TITLE}
                                        width="${image.WIDTH}" height="${image.HEIGHT}"
                                        >
                                    </a>
                                </div>
                                `).join('')}
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    `)
                    catalogElementsSwiper.destroy();
                    // Напишем еще раз, потому что в любом случае необходимо будет переопределить параметры для миниатюр.
                    catalogElementsSwiper = new Swiper('.catalog__element--gallery__images .swiper', {
                        slidesPerView: 1,
                        thumbs: {
                            swiper: catalogElementsSwiperThumbs,
                            slideThumbActiveClass: 'active',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                        },
                        navigation: { prevEl: '.catalog__element--gallery__prev', nextEl: '.catalog__element--gallery__next', disabledClass: 'disabled' },
                    });
                }
                else {
                    galleryBlock.innerHTML = (`
                    <div class="swiper-slide catalog__element--gallery__image">
                        <img src="/local/templates/mifiti/img/empty_photo_big.svg" alt="Пустое фото"
                        width="279"
                        height="382"
                        >
                    </div>
                    `)
                }
            }
            Fancybox.bind('[data-fancybox="gallery"]', {
                loop: false,
            });
        },
        // Изменение информации, согласно офферу
        changeInfo: function () {
            var index = -1,
                j = 0,
                boolOneSearch = true,
                eventData = {
                    currentId: (this.offerNum > -1 ? this.offers[this.offerNum].ID : 0),
                    newId: 0
                };

            var i, offerGroupNode;

            for (i = 0; i < this.offers.length; i++) {
                boolOneSearch = true;

                for (j in this.selectedValues) {
                    if (this.selectedValues[j] !== this.offers[i].TREE[j]) {
                        boolOneSearch = false;
                        break;
                    }
                }

                if (boolOneSearch) {
                    index = i;
                    break;
                }
            }
            this.updateOfferData(this.offers[index]);
        },

    }
})(window);