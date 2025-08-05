<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use Illuminate\Http\Request;

use App\Services\TmdbService;


class MovieController extends Controller
{
    protected $tmdb;

    public function __construct(TmdbService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Busca todos os filmes
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movies = $this->tmdb->getAllMovies();
        return response()->json($movies);
    }

    /**
     * Summary of searchTitle
     * Busca pelo nome do Filme|Título
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchTitle(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, digite um termo para busca',
                'results' => []
            ], 404); // Bad Request
        }

        $results = $this->tmdb->searchMoviesByTitle($query);

        if (empty($results)) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhum filme encontrado',
                'query' => $query,
                'results' => []
            ], 404); // Not Found
        }

        return response()->json([
            'success' => true,
            'query' => $query,
            'results' => $results['results']
        ]);
    }
}
