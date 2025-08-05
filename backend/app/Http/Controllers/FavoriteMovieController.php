<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Models\FavoriteMovie;
use App\Services\FavoriteMovieService;

class FavoriteMovieController extends Controller
{
    private $favoriteService;

    public function __construct(FavoriteMovieService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    // Listar favoritos do usuário
    public function index()
    {
        $favorites = $this->favoriteService->getAllFavoriteMovies();
        return response()->json($favorites);
    }

    // Adicionar filme aos favoritos
    public function store(StoreMovieRequest $request)
    {
        $request->validated();
        try {
            $data = $this->favoriteService->addFavorite($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Filme adicionado aos favoritos',
                'favorite' => $data['favorite']
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Falha ao criar favorito',
                'details' => $e->getMessage()
            ], 500);
        }

    }

    // Remover filme dos favoritos
    public function destroy($id)
    {
        try {
            $this->favoriteService->removeFavorite($id);

            return response()->json([
                'success' => true,
                'message' => 'Filme removido dos favoritos'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

   /**
     * Obtém a lista de gêneros únicos
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGenres()
    {
        $genres = $this->favoriteService->getUniqueGenres();
        return response()->json($genres);
    }
}
