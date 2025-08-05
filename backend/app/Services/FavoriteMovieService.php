<?php

namespace App\Services;

use App\Models\FavoriteMovie;
use Exception;

class FavoriteMovieService
{
    private $tmdbService;

    public function __construct(TmdbService $tmdbService){
        $this->tmdbService = $tmdbService;
    }

     /**
     * Pega Todos os Filmes
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllFavoriteMovies(){
        return FavoriteMovie::latest()->get();
    }

    /**
     * Summary of addFavorite
     * Adiciona Favorito buscando os dados da API TMDB,
     * pela instancia do TmdbService
     * @param array $validateData
     * @throws \Exception
     * @return array{favorite: FavoriteMovie, success: bool}
     */
    public function addFavorite(array $validateData){
        try {
            $movieData = $this->tmdbService->getMovieDetails($validateData["id"]);
            $favorite = FavoriteMovie::create($movieData);
            return [
                'success' => true,
                'favorite' => $favorite
            ];
        } catch (Exception $e) {
            throw new Exception('Failed to add favorite: ' . $e->getMessage());
        }
    }

    /**
     * Summary of removeFavorite
     * @param mixed $id
     * @throws \Exception
     * @return array{success: bool}
     */
    public function removeFavorite($id){

        $deleted = FavoriteMovie::where('id', $id)->delete();

        if (!$deleted) {
            throw new Exception('Favorite movie not found.');
        }

        return ['success'=> true];
    }

     /**
     * Obtém todos os gêneros únicos dos filmes favoritos
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getUniqueGenres()
    {
        return FavoriteMovie::pluck('genres')
            ->flatMap(function ($item) {
                return collect(explode(',', $item))
                    ->map(fn($g) => trim($g));
            })
            ->unique()
            ->sort()
            ->values();
    }
}