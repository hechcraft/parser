<?php


namespace App\Parser;


class PageOffer
{
    public $name;
    public $price;
    public $image;
    public $url;

    private function __construct(string $name,  string $price,string $image,string $url)
    {
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->url = $url;
    }

    public static function fromProvider($parserData): object
    {
        return new self(
            data_get($parserData, 'name'),
            data_get($parserData, 'price'),
            data_get($parserData, 'image'),
            data_get($parserData, 'url')
        );
    }
}
