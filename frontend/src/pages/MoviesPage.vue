<script setup>
import { ref, onMounted } from 'vue'
import Swal from 'sweetalert2'
import NavMovies from '@/components/NavMovies.vue';
import MoviesList from '@/components/MoviesList.vue';
import FooterMovies from '@/components/FooterMovies.vue';
import movieService from '@/api/movieService';

const movies = ref([])
const favorites = ref([])
const isSearching = ref(false)
const isLoading = ref(false)

const fetchAll = async () => {
  isLoading.value = true

  try {
    const [ moviesResponse, favoritesResponse ] = await Promise.all([
      movieService.getAllMovies(),
      movieService.getAllFavorites()
    ])

    // Normaliza os dados independentemente da estrutura da resposta
    const allMovies = moviesResponse.data?.data || moviesResponse.data || []
    favorites.value = favoritesResponse.data || favoritesResponse

    const favoritedIds = new Set(favorites.value.map(fav => fav.id_tmdb))

    movies.value = allMovies.map(movie => ({
      ...movie,
      is_favorited: favoritedIds.has(movie.id)
    }))

  } catch (error) {
     console.error('Erro ao carregar filmes:', error)
    await Swal.fire({
      title: 'Erro!',
      text: 'Não foi possível carregar os filmes',
      icon: 'error'
    })
  } finally {
    isLoading.value = false
  }
}

const searchMovies = async (query) => {
  if (!query?.trim()) {
    await fetchAll()
    return
  }

  isSearching.value = true

  try {
    const response = await movieService.getMovieByName(query)
    const favoritedIds = new Set(favorites.value.map(fav => fav.id_tmdb)) // remoção de duplicidade
    movies.value = (response.data.results || []).map(movie => ({
      ...movie,
      is_favorited: favoritedIds.has(movie.id) // substituicao do include melhor desempenho
    }))
  } catch (error) {
      console.error('Erro na busca:', error)
      movies.value = []
      await Swal.fire({
        title: 'Erro na busca',
        text: 'Tente novamente mais tarde',
        icon: 'error'
      })
  } finally {
    isSearching.value = false
  }
}

const handleAddFavorito = async(movie) => {
  try {
    await movieService.addToFavorites(movie.id)
    movie.is_favorited = true
    favorites.value = [...favorites.value, {id_tmdb:movie.id}]

      await Swal.fire({
      title: 'Sucesso!',
      text: 'Filme adicionado aos favoritos!',
      icon: 'success',
      confirmButtonText: 'OK'
    })
  } catch (error) {
    console.error('Erro ao favoritar:', error)
    await Swal.fire({
      title: 'Erro!',
      text: 'Não foi possível favoritar o filme',
      icon: 'error'
    })
  }
}

onMounted(() => {
  fetchAll()
})
</script>

<template>
    <NavMovies @search="searchMovies"/>
    <MoviesList :movies="movies" @add-favorito="handleAddFavorito"/>
    <FooterMovies/>
</template>