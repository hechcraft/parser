<?php

namespace App\Parser;

class Dns extends marketPlaceParser
{
    private $single = "{
                        name: document.querySelector('.product-card-top__title').innerText,
                        price: document.querySelector('.product-buy__price').innerText,
                        image: document.querySelector('img[class^=product-images-slider__img]').getAttribute('src'),
                        url: document.URL,
                        }";
    private $group = "Array.from(document.querySelectorAll('div[data-id=product]'))
                        .map(node => ({name: node.querySelector('a[class^=catalog-product__name]').innerText,
                        url: 'https://www.dns-shop.ru' + node.querySelector('a[class^=catalog-product__name]').getAttribute('href'),
                        image: node.querySelector('.catalog-product__image-link img').getAttribute('src'),
                        price: node.querySelector('.product-buy__price').innerText}))";


    public function dataFromPage(): array
    {
        return $this->parser($this->group, $this->single);
    }
}
