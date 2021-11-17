<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repository\MovieRepositoryInterface;

class MovieController extends Controller
{


    private $movieRepository;
    /**
     * Create a new movieController instance.
     *
     * @return void
     */
    public function __construct(MovieRepositoryInterface $movieRepository) {

        $this->movieRepository = $movieRepository;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getTitles(Request $request): JsonResponse
    {
        // TODO
        $fooTitles = $this->movieRepository->getFooTitles();

        $combinedTitles = $fooTitles;
        $barTitles = $this->movieRepository->getBarTitles();
        if(!empty($barTitles)){
            foreach ($barTitles['titles'] as $key => $value) {
                $combinedTitles[] = $value['title'];
            }
        }
        $bazTitles = $this->movieRepository->getBazTitles();
        if(!empty($bazTitles)){
            foreach ($bazTitles['titles'] as $key => $value) {
                $combinedTitles[] = $value;
            }
        }
        return response()->json([$combinedTitles]);
    }
}
