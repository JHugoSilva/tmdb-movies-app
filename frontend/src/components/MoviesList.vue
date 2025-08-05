<script setup>
const props = defineProps(["movies"]);

const emit = defineEmits(["add-favorito"]);

const addFavorito = async (id) => {
  emit("add-favorito", id);
};
</script>
<template>
  <div
    class="container mx-auto mt-5 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4"
  >
    <div
      v-for="movie in props.movies"
      :key="movie.id"
      class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition-shadow dark:border-gray-700 dark:bg-gray-800"
    >
      <!-- Imagem com aspecto ratio fixo -->
      <div class="aspect-[2/3] relative overflow-hidden rounded-t-lg">
        <img
          class="w-full h-full object-cover"
          :src="
            movie.poster_path
              ? 'https://image.tmdb.org/t/p/w300' + movie.poster_path
              : '/placeholder-movie.jpg'
          "
          :alt="'Poster: ' + movie.title"
          loading="lazy"
        />
        <!-- Nota em overlay -->
        <div
          class="absolute bottom-2 left-2 bg-black bg-opacity-70 text-white text-xs font-bold px-2 py-1 rounded flex items-center"
        >
          <svg class="w-3 h-3 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            />
          </svg>
          {{ movie.vote_average?.toFixed(1) || "N/A" }}
        </div>
      </div>

      <!-- Conteúdo compacto -->
      <div class="p-3">
        <h3
          class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-1 mb-1"
          :title="movie.title"
        >
          {{ movie.title }}
        </h3>

        <div
          class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-2"
        >
          <span>{{ movie.release_date?.split("-")[0] || "----" }}</span>
          <span class="uppercase">{{ movie.original_language }}</span>
        </div>

        <!-- Botão compacto -->
        <button
          @click="addFavorito(movie)"
          :disabled="movie.is_favorited"
          class="flex items-center justify-center w-full py-1.5 px-3 text-xs rounded-md transition-colors"
          :class="{
            'bg-cyan-600 hover:bg-cyan-700 text-white cursor-pointer': !movie.is_favorited,
            'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed':
              movie.is_favorited,
          }"
        >
          <svg
            v-if="movie.is_favorited"
            class="w-3 h-3 mr-1"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
              clip-rule="evenodd"
            />
          </svg>
          {{ movie.is_favorited ? "Favoritado" : "Favoritar" }}
        </button>
      </div>
    </div>
  </div>
</template>
