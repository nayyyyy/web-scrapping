<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ScrapTest extends TestCase
{
    /** @test */
    public function foundInformation()
    {
        $this->json('post','api/scrap', ["link" => "https://www.ebay.com/itm/295412450991?_trkparms=pageci%3A20b5dc44-be6f-11ed-81f8-e66889c11931%7Cparentrq%3Ac62bc11e1860ad39081dbb55ffff8fb6%7Ciid%3A1"])
            ->assertJson([
                "status" => "success",
                "message" => "Information successfully retrieve",
                "data" => [
                    "title" => "Xbox Series S 512GB SSD Console + Watch Dogs: Legion (Email Delivery)",
                    "price" => "New",
                    "main-thumbnail" => "https://i.ebayimg.com/images/g/mr0AAOSw82BjmMqS/s-l500.jpg",
                    "sub-thumbnail" => [
                        "1" => "https://i.ebayimg.com/images/g/SGwAAOSwuk1jmMqT/s-l500.jpg",
                        "2" => "https://i.ebayimg.com/images/g/USYAAOSwnB1jmMqT/s-l500.jpg",
                        "3" => "https://i.ebayimg.com/images/g/xbgAAOSwe5BjohaJ/s-l500.jpg",
                        "4" => "https://i.ebayimg.com/images/g/pCIAAOSwEfpjohaJ/s-l500.jpg",
                        "5" => "https://i.ebayimg.com/images/g/5xMAAOSweVhjohaJ/s-l500.jpg",
                        "6" => "https://i.ebayimg.com/images/g/5-wAAOSwgJFjohaJ/s-l500.jpg",
                        "7" => "https://i.ebayimg.com/images/g/AtYAAOSw-PtjohaJ/s-l500.jpg",
                        "8" => "https://i.ebayimg.com/images/g/CrcAAOSw3X5johaJ/s-l500.jpg"
                    ]
                ]
            ])
            ->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function notAvailableMethod()
    {
        $this->json('post','api/scrap', ["link" => "https://www.tokopedia.com/bagusmartid/twin-pack-bagus-anti-bau-mobil-100-gr?src=topads"])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    /** @test */
    public function urlInvalid()
    {
        $this->json('post','api/scrap', ["link" => "https://www.ebay.com/itm/275703423/DITM%26aid%3D777008%26algo%3DPERSONAL.TOPIC%26ao%3D1%26asc%3D20221102144041%26meid%3Debaaa20aa04642a4b015e1addfc492ca%26pid%3D101251%26rk%3D1%26rkt%3D1%26itm%3D275703420255%26pmt%3D0%26noa%3D1%26pg%3D2380057%26algv%3DPersonalizedTopicsV2WithWatchlistFeaturesAndTopicMLR%26brand%3Dadidas&_trksid=p2380057.c101251.m47269&_trkparms=pageci%3A55a86127-be76-11ed-9b18-4a0ff29629e1%7Cparentrq%3Ac65afc381860aaecdda11998ffffa4be%7Ciid%3A1"])
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function wrongInput()
    {
        $this->json('post','api/scrap', ["links" => "https://www.ebay.com/itm/275703423/DITM%26aid%3D777008%26algo%3DPERSONAL.TOPIC%26ao%3D1%26asc%3D20221102144041%26meid%3Debaaa20aa04642a4b015e1addfc492ca%26pid%3D101251%26rk%3D1%26rkt%3D1%26itm%3D275703420255%26pmt%3D0%26noa%3D1%26pg%3D2380057%26algv%3DPersonalizedTopicsV2WithWatchlistFeaturesAndTopicMLR%26brand%3Dadidas&_trksid=p2380057.c101251.m47269&_trkparms=pageci%3A55a86127-be76-11ed-9b18-4a0ff29629e1%7Cparentrq%3Ac65afc381860aaecdda11998ffffa4be%7Ciid%3A1"])
            ->assertStatus(Response::HTTP_NOT_ACCEPTABLE);
    }
}
