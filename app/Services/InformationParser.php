<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class InformationParser
{
    protected $html, $link, $data;

    public function __construct($link)
    {
        $this->link = $link;
        $this->data = [
            "title" => null,
            "price" => null,
            "main-thumbnail" => null,
            "sub-thumbnail" => null
        ];
    }

    public function amazonProductInformation()
    {
        $this->buildHtml();

        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);

        $xpath = new DOMXPath($dom);

        $this->data["title"] = trim($xpath->query('//span[@id="productTitle"]')->item(0)->nodeValue);
        $this->data["price"] = $xpath->query('//span[@class="a-offscreen"]')->item(0)->nodeValue;
        $this->data["main-thumbnail"] = $xpath->query('//img[@data-a-image-name="landingImage"]')->item(0)->attributes->getNamedItem('src')->nodeValue;

        return $this->data;
    }

    public function ebayProductInformation()
    {
        $this->buildHtml();

        $dom = new DOMDocument();
        @$dom->loadHTML($this->html);
        $xpath = new DOMXPath($dom);

        $this->data["title"] = $dom->getElementById("LeftSummaryPanel")->getElementsByTagName("span")->item(0)->textContent;
        $this->data["price"] = $xpath->query('//span[@class="ux-textspans"]')->item(12)->textContent;

        $this->data["main-thumbnail"] = $xpath->query('//div[@class="ux-image-carousel-item active image"]/img')->item(0)->attributes->getNamedItem('src')->nodeValue;
        foreach ($xpath->query('//div[@class="ux-image-carousel-item image"]/img') as $key => $value) {
            $this->data["sub-thumbnail"][$key + 1] = $value->getAttribute('data-src');
        }

        return $this->data;
    }

    protected function buildHtml(){
        $headers = [
            "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36",
            "Accept-Language" => "en-US, en;q=0.5"
        ];

        $client = new Client();
        $response = $client->request('GET', $this->link, array(
            "headers" => $headers
        ));

        $this->html = (string)$response->getBody();
    }
}
