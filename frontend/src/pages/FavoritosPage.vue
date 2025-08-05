<script setup>
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2'
import movieService from '@/api/movieService';
import FooterMovies from '@/components/FooterMovies.vue';
import NavMovies from '@/components/NavMovies.vue';
import MoviesFavorites from '@/components/MoviesFavorites.vue';

const favorites = ref([])
const genres = ref([])
const allFavorites = ref([])
const selectedGenre = ref('')

const filterFavorites = () => {
    if (!selectedGenre.value) {
        favorites.value = [...allFavorites.value]
    } else { 
      favorites.value = allFavorites.value.filter(f =>
          f.genres?.split(', ').some(genre => genre.trim() === selectedGenre.value)
      )
    }
}

const setSelectedGenre = (genre) => {
    selectedGenre.value = genre
    filterFavorites()
}

const handleRemoveFavorite = async (id) => {
  const result = await Swal.fire({
    title: 'Remover favorito?',
    text: 'Você tem certeza que deseja remover este filme?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sim, remover',
    cancelButtonText: 'Cancelar'
  })

  if (result.isConfirmed) {
    try {
      await movieService.removeFavorites(id)
      allFavorites.value = allFavorites.value.filter(f => f.id !== id)
      filterFavorites()
      Swal.fire('Removido!', 'O filme foi removido.', 'success')
    } catch (error) {
      await Swal.fire('Erro!', 'Não foi possível remover o filme.', 'error')
      console.error('Error removing favorite:', error)
    }
  }
}

onMounted(async()=>{
   try {
      const [genresResponse, favoritesResponse] = await Promise.all([
        movieService.getGender(),
        movieService.getAllFavorites()
      ])
    
      genres.value = genresResponse
      allFavorites.value = favoritesResponse.data || favoritesResponse
      favorites.value = [...allFavorites.value]
   } catch (error) {
      console.error('Error fetching data:', error)
      await Swal.fire('Erro!', 'Não foi possível carregar os dados.', 'error')
   }
})

</script>

<template>
   <NavMovies :genres="genres" @filter="setSelectedGenre"/>
   <MoviesFavorites :favorites="favorites" @remove-favorito="handleRemoveFavorite"/>
   <FooterMovies/>
</template>