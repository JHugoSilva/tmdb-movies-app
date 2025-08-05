import apiClient from './apiClient'

const movieService = {
  // Buscar todos os filmes
  getAllMovies() {
    return apiClient.get('/movies')
  },
  //Buscar Por nome
  getMovieByName(name) {
    return apiClient.get(`/movies/search?query=${name}`)
  },
  //Busca todos os favoritos
  getAllFavorites() {
    return apiClient.get('/favorites')
  },
  // Adicionar Favorito
  addToFavorites(id) {    
    return apiClient.post('/favorites', {id:id})
  },
  // Remove favorito
  removeFavorites(id) { 
    return apiClient.delete(`/favorites/${id}`)
  },
  // Buscar generos dos filmes
  getGender() {
    return apiClient.get(`/favorites/genres`)
  }
}

export default movieService