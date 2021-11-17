<?php

namespace App\Repository\Eloquent;

use App\Models\Movie;
use App\Repository\MovieRepositoryInterface;
use External\Foo\Movies\MovieService as FooMovieService;
use External\Bar\Movies\MovieService as BarMovieService;
use External\Baz\Movies\MovieService as BazMovieService;
class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    public function getFooTitles()
    {
        try {
            $fooMovies = new FooMovieService();
            $titles = $fooMovies->getTitles();
        } catch (\Exception $e) {
                        

            if($e->getMessage() == "Service unavailable") {
                //ddd
                $titles = [];
            }
        }
        
        return $titles;
    }

    public function getBarTitles()
    {
        try {
            $barMovies = new BarMovieService();
            $titles = $barMovies->getTitles();
        } catch (\Exception $e) {
            
            if($e->getMessage() == "Service unavailable") {
                //ddd
                $titles = [];
            }
        }
        
        return $titles;
    }

    public function getBazTitles()
    {
        try {
            $bazMovies = new BazMovieService();
            $titles = $bazMovies->getTitles();
        } catch (\Exception $e) {
                            

            if($e->getMessage() == "Service unavailable") {
                //ddd
                $titles = [];
            }
        }
        
        return $titles;
    }
}