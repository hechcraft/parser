<?php

namespace App\Parser;

class Avito extends marketPlaceParser
{
    private $single = "{
                            price: document.querySelector('span[class^=price-value-string]').innerText,
                            title: document.querySelector('span[class=title-info-title-text]').innerText,
                            image: document.querySelector('div[class^=gallery-img-frame] > img').getAttribute('src'),
                            url: document.url
                        }";
    private $group = "Array.from(document.querySelectorAll('div[class^=iva-item-content]'))
                        .map(node => ({title: node.querySelector('h3[itemprop=name]').innerText,
                        url: 'https://www.avito.ru' + node.querySelector('div[class^=iva-item] a').getAttribute('href'),
                        price: node.querySelector('span[class^=price-text]').innerText,
                        image: node.querySelector('img[class^=photo-slider-image]') ? node.querySelector('img[class^=photo-slider-image]').getAttribute('src') : 'null'}))";


    public function dataFromPage(): array
    {
        return $this->parser($this->group, $this->single);
    }
}
