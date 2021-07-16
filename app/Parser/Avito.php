<?php

namespace App\Parser;

class Avito extends marketPlaceParser
{
    private $single = "document.querySelector('span[class^=price-value-string]').innerText";
    private $group = "Array.from(document.querySelectorAll(\"div[class^=iva-item-content]\"))
                        .map(node => ({name: node.querySelector('h3[itemprop=\"name\"]').innerText,
                        url: 'https://www.avito.ru' + node.querySelector('div[class^=iva-item] a').getAttribute('href'),
                        price: node.querySelector('span[class^=price-text]').innerText,
                        image: node.querySelector('img[class^=photo-slider-image]').getAttribute('src')}))";


    public function dataFromPage(): array
    {
        return $this->parser($this->group, $this->single);
    }
}
