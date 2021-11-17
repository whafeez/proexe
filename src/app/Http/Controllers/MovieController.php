<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repository\MovieRepositoryInterface;
use App\Jobs\GetMovieTitles;

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
        //GetMovieTitles::dispatch($validatedData);
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
        if(empty($fooTitles) || empty($bazTitles) || empty($barTitles)) {
            $combinedTitles = [   "status" =>  "failure"];
        }
        return response()->json([$combinedTitles]);
    }
}
