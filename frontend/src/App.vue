<template>
  <main class="pt-16"> 
     <transition name="fade" mode="out-in">
       <router-view></router-view>
     </transition>
  </main>
</template>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>