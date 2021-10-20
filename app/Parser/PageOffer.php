<?php


namespace App\Parser;


class PageOffer
{
    public $name;
    public $price;
    public $image;
    public $url;
    public $priceStr;

    private function __construct(string $name, string $price, string $image, string $url, string $priceStr)
    {
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->url = $url;
        $this->priceStr = $priceStr;
    }

    public static function fromProvider($parserData): self
    {
        return new self(
            data_get($parserData, 'title'),
            data_get($parserData, 'price'),
            data_get($parserData, 'image'),
            data_get($parserData, 'url'),
            data_get($parserData, 'priceStr'),
        );
    }
}
