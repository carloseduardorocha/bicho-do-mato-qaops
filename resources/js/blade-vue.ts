import { createApp } from 'vue';
import BottomNavBar from './components/BottomNavBar.vue';
import NavBar from './components/NavBar.vue';

const bottomNavEl = document.getElementById('bottom-navbar-vue');
if (bottomNavEl) {
  createApp(BottomNavBar).mount(bottomNavEl);
}

const navbar = document.getElementById('navbar');
if (navbar) {
  createApp(NavBar).mount(navbar);
}
