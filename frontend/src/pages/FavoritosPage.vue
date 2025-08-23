<script setup>
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
import movieService from "@/api/movieService";
import FooterMovies from "@/components/FooterMovies.vue";
import NavMovies from "@/components/NavMovies.vue";
import MoviesFavorites from "@/components/MoviesFavorites.vue";
import Loading from "@/component-base/Loading.vue";

const favorites = ref([]); // Armazena os favoritos
const genres = ref([]); // Armazena os generos
const allFavorites = ref([]); // Pega o retorno do banco
const selectedGenre = ref(""); // Seleciona o genero
const isLoading = ref(false);

const fetchAll = async () => {
  isLoading.value = true;
  try {
    const [genresResponse, favoritesResponse] = await Promise.all([
      movieService.getGender(),
      movieService.getAllFavorites(),
    ]);

    genres.value = genresResponse;
    allFavorites.value = favoritesResponse.data || favoritesResponse;
    favorites.value = [...allFavorites.value];
  } catch (error) {
    console.error("Error fetching data:", error);
    await Swal.fire("Erro!", "Não foi possível carregar os dados.", "error");
  } finally {
    isLoading.value = false;
  }
};

const filterFavorites = () => {
  //Seleciona por filtro de genero
  if (!selectedGenre.value) {
    favorites.value = [...allFavorites.value];
  } else {
    favorites.value = allFavorites.value.filter((f) =>
      f.genres?.split(", ").some((genre) => genre.trim() === selectedGenre.value)
    );
  }
};

const setSelectedGenre = (genre) => {
  selectedGenre.value = genre;
  filterFavorites();
};

const handleRemoveFavorite = async (id) => {
  const result = await Swal.fire({
    title: "Remover favorito?",
    text: "Você tem certeza que deseja remover este filme?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sim, remover",
    cancelButtonText: "Cancelar",
    scrollbarPadding: false,
    willOpen: () => {
      document.body.style.overflow = "auto"; // força scroll normal
    },
  });

  if (result.isConfirmed) {
    try {
      await movieService.removeFavorites(id);
      allFavorites.value = allFavorites.value.filter((f) => f.id !== id);
      filterFavorites();
      Swal.fire({
        title: "Removido!",
        text: "O filme foi removido.",
        icon: "success",
        scrollbarPadding: false,
        willOpen: () => {
          document.body.style.overflow = "auto"; // força scroll normal
        },
      });
    } catch (error) {
      await Swal.fire("Erro!", "Não foi possível remover o filme.", "error");
      console.error("Error removing favorite:", error);
    }
  }
};

onMounted(() => {
  fetchAll();
});
</script>

<template>
  <Loading :loading="isLoading" />
  <div v-if="!isLoading">
    <NavMovies :genres="genres" @filter="setSelectedGenre" />
    <MoviesFavorites :favorites="favorites" @remove-favorito="handleRemoveFavorite" />
  </div>
  <FooterMovies />
</template>
