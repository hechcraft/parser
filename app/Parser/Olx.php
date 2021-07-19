<?php

namespace App\Parser;

class Olx extends marketPlaceParser
{
    private $single = "{
                        price: document.querySelector('[data-testid=ad-price-container] h3').innerText,
                        url: document.URL,
                        image: document.querySelector('.swiper-zoom-container > img').getAttribute('src'),
                        title: document.querySelector('[data-cy=ad_title]').innerText
                        }";
    private $group = "Array.from(document.querySelectorAll('#offers_table .offer-wrapper')).
                        map(node => ({ name: node.querySelector('h3 >a[class$=detailsLink]').innerText,
                            url: node.querySelector('h3>a[class$=detailsLink]').getAttribute('href'),
                            price: node.querySelector('p.price > strong').innerText,
                            img: node.querySelector('a[class^=thumb] > img') ? node.querySelector('a[class^=thumb] > img').getAttribute('src') : 'Без фото'}))";

    public function dataFromPage(): array
    {
        return $this->parser($this->group, $this->single);
    }
}
