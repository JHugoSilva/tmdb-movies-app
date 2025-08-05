<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    /**
     * A chave da API utilizada para autenticação nas requisições à API do TMDB.
     *
     * Definida a partir do valor de configuração 'services.tmdb.api_key'.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * A URL base da API do TMDB.
     *
     * Utilizada como ponto de partida para todas as requisições à API.
     * Definida a partir do valor de configuração 'services.tmdb.base_url'.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Construtor da classe.
     *
     * Inicializa a instância com a chave da API e a URL base da API do TMDB,
     * utilizando as configurações definidas no arquivo config/services.php.
     *
     * As configurações são normalmente carregadas via função config(), 
     * disponível no framework Laravel.
     *
     * Propriedades inicializadas:
     * - $this->apiKey: chave de acesso à API TMDB.
     * - $this->baseUrl: URL base para requisições à API.
     *
     * @return void
     */
    public function __construct()
    {
        $this->apiKey = config('services.tmdb.api_key');
        $this->baseUrl = config('services.tmdb.base_url');
    }

    public function getAllMovies()
    {
        $response = Http::get("{$this->baseUrl}/discover/movie", [
            'api_key' => $this->apiKey,
            'language' => 'pt-BR',
            'sort_by' => 'popularity.desc',
        ]);

        return $response->json()['results'] ?? [];
    }

    /**
     * Busca filme pelo titulo
     * @param mixed $title
     */
    public function searchMoviesByTitle($title)
    {
        $response = Http::get("{$this->baseUrl}/search/movie", [
            'api_key' => $this->apiKey,
            'language' => 'pt-BR',
            'query' => $title,
        ]);

        return $response->successful() ? $response->json() : null;
    }

    /**
     * Filtra e formata dados para serem salvos no banco de dados
     * 
     */

    public function getMovieDetails($movieId)
    {
        $response = Http::get("{$this->baseUrl}/movie/{$movieId}", [
            'api_key' => $this->apiKey,
            'append_to_response' => 'videos',
            'language' => 'pt-BR',
        ]);

        if ($response->successful()) {
            $data = $response->json();

            $newData = [];
            $newData['id_tmdb'] = $data['id'];
            $newData['title'] = $data['title'];
            $newData['homepage'] = $data['homepage'];
            $newData['overview'] = $data['overview'];
            $newData['popularity'] = $data['popularity'];
            $newData['poster_path'] = $this->getMoviePosterUrl($movieId);
            $newData['release_date'] = $data['release_date'];
            $newData['runtime'] = $data['runtime'];
            $newData['status'] = $data['status'];
            $newData['tagline'] = $data['tagline'];
            $newData['vote_count'] = $data['vote_count'];

            $newTrailer = [];

            foreach ($data['videos']['results'] as $traile) {
                $newTrailer['language'] = $traile['iso_639_1'] . '-' . $traile['iso_3166_1'];
                if ($newTrailer['language'] == 'pt-BR') {
                    $newTrailer['name'] = $traile['name'];
                    $newTrailer['key'] = "https://www.youtube.com/watch?v=" . $traile['key'];
                    $newTrailer['site'] = $traile['site'];
                    $newTrailer['type'] = $traile['type'];
                }
                break;
            }

            $newData['trailer'] = json_encode($newTrailer, JSON_UNESCAPED_UNICODE);
            // Extrai apenas os nomes dos gêneros
            $genreNames = array_column($data['genres'], 'name');
            // Junta com vírgulas
            $newData['genres'] = implode(', ', $genreNames);

            $nameCountry = [];
            foreach ($data['production_countries'] as $country) {
                $nameCountry[] = $country['name'];
            }

            $newData['production_countries'] = implode(', ', $nameCountry);
            unset($data);
            return $newData;
        }

        return [];
    }

    /**
     * Pega a imagem do filme se não tiver retorna null
     * @param int $movieId
     * @param string $size
     * @return string|null
     */
    private function getMoviePosterUrl(int $movieId, string $size = 'w500'): ?string
    {
        $response = Http::get("{$this->baseUrl}/movie/{$movieId}", [
            'api_key' => $this->apiKey,
            'language' => 'pt-BR'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['poster_path']
                ? "https://image.tmdb.org/t/p/{$size}{$data['poster_path']}"
                : null;
        }
        return null;
    }
}