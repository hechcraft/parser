<?php


namespace App\Parser;


class PageOffer
{
    public $name;
    public $price;
    public $image;
    public $url;

    private function __construct($name, $price, $image, $url)
    {
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->url = $url;
    }

    public static function fromProvider($parserData){
        $pageOffer = collect();
        if (count($parserData) === 4){
            return new self(
                data_get($parserData, 'name'),
                data_get($parserData, 'price'),
                data_get($parserData, 'image'),
                data_get($parserData, 'url')
            );
        }

        foreach ($parserData as $item){
            $pageOffer->push(
                new self(
                    data_get($item, 'name'),
                    data_get($item, 'price'),
                    data_get($item, 'image'),
                    data_get($item, 'url')
                )
            );
        }
        
        return $pageOffer;
    }
}
