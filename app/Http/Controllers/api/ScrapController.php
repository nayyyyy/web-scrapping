<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Scrap\GetWebsiteContentRequest;
use App\Interfaces\ScrapRepositoryInterface;

class ScrapController extends Controller
{
    private ScrapRepositoryInterface $scrapRepository;

    public function __construct(ScrapRepositoryInterface $scrapRepository)
    {
        $this->scrapRepository = $scrapRepository;
    }

    public function show(GetWebsiteContentRequest $request)
    {
        $information = $this->scrapRepository->getInformation($request->link);

        if (is_null($information)) {
            return $this->badRequestResponse([
                "service" => "System fetching for this URL not available"
            ], "Data failed to fetch");
        }


        return $this->successResponse([
            "status" => "success",
            "message" => "Information successfully retrieve",
            "data" => $information
        ]);
    }
}
