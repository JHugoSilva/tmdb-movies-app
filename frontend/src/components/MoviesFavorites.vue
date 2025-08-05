<script setup>
import { ref } from "vue";
import Swal from 'sweetalert2'

const props = defineProps(["favorites"]);

const emit = defineEmits(["remove-favorito"]);

const removerFavorito = async (id) => {
  emit("remove-favorito", id);
};

// Estado do componente
const trailerAtivo = ref(false);
const trailerSelecionado = ref("");
const filmeSelecionado = ref(null);

// Métodos
const abrirTrailer = (filme) => {
   if (!filme?.trailer || !filme.trailer.includes('v=')) {
    Swal.fire('Erro!', 'Trailer inválido ou ausente.', 'error')
    return;
  }
  try {
    const trailer = JSON.parse(filme.trailer);
    const videoId = trailer.key.split("v=")[1]?.split("&")[0] || trailer.key;

    filmeSelecionado.value = filme;
    trailerSelecionado.value = videoId;
    trailerAtivo.value = true;
  } catch (error) {
    console.error("Erro ao parsear trailer:", error);
  }
};

const fecharTrailer = () => {
  trailerAtivo.value = false;
};
</script>
<template>
  <div class="container mx-auto mt-5">
    <!-- Aumentei o mt para acomodar a navbar fixa -->
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
      v-if="props.favorites.length > 0"
    >
      <div
        v-for="favorite in props.favorites"
        :key="favorite.id"
        class="relative bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow dark:border-gray-700 dark:bg-gray-800 group overflow-hidden"
      >
        <!-- Imagem com overlay hover -->
        <div class="relative aspect-[2/3] overflow-hidden">
          <img
            class="w-full h-full object-cover rounded-t-lg"
            :src="
              favorite.poster_path
                ? 'https://image.tmdb.org/t/p/w500' + favorite.poster_path
                : 'https://placehold.co/600x400'
            "
            :alt="'Poster do filme ' + favorite.title"
            loading="lazy"
          />

          <!-- Overlay hover para sinopse -->
          <div
            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-70 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100 p-4"
          >
            <p class="text-white text-sm line-clamp-5">
              {{ favorite.overview || "Sinopse não disponível" }}
            </p>
          </div>
        </div>

        <!-- Conteúdo do card -->
        <div class="p-4">
          <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-1">
            {{ favorite.title }}
          </h3>
          <!-- Tagline -->
          <p
            class="italic text-sm text-gray-600 dark:text-gray-400 mb-1 line-clamp-1"
          >
            "{{ favorite.tagline || "Slogan não localizada" }}"
          </p>

          <div class="flex justify-between">
            <!-- Runtime -->
            <p v-if="favorite.runtime" class="text-sm text-gray-700 dark:text-gray-300 mb-1">
              🕒 {{ favorite.runtime }} min
            </p>

            <!-- Homepage -->
            <p v-if="favorite.homepage" class="text-sm">
              <a
                :href="favorite.homepage"
                target="_blank"
                rel="noopener noreferrer"
                class="text-blue-600 hover:underline"
              >
                Página oficial 🔗
              </a>
              <!-- Botão de trailer e remover -->
            </p>
          </div>

          <div class="flex flex-wrap gap-2 mt-4">
            <button
              v-if="favorite.trailer"
              @click="abrirTrailer(favorite)"
              class="flex items-center cursor-pointer px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              Trailer
            </button>

            <button
              @click="removerFavorito(favorite.id)"
              class="flex-1 min-w-[120px] cursor-pointer flex items-center justify-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded transition-colors"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
              Remover
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 min-h-[300px] place-items-center"
      v-else
    >
      <h1 class="text-center text-xl text-gray-500 font-semibold">Nenhum favorito selecionado.</h1>
    </div>
    <div
      v-if="trailerAtivo"
      class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center"
      @click.self="fecharTrailer"
    >
      <div class="relative w-full max-w-4xl">
        <button @click="fecharTrailer" class="absolute -top-10 right-0 text-white text-2xl">
          ×
        </button>
        <iframe
          :src="`https://www.youtube.com/embed/${trailerSelecionado}?autoplay=1`"
          class="w-full aspect-video"
          allowfullscreen
        ></iframe>
      </div>
    </div>
  </div>
</template>
