import { createApp } from 'vue';
import BannerHome from './components/BannerHome.vue';
import BottomNavBar from './components/BottomNavBar.vue';
import NavBar from './components/NavBar.vue';
import NewsHome from './components/NewsHome.vue';

const bottomNavEl = document.getElementById('bottom-navbar-vue');
if (bottomNavEl) {
    createApp(BottomNavBar).mount(bottomNavEl);
}

const navbar = document.getElementById('navbar');
if (navbar) {
    createApp(NavBar).mount(navbar);
}

const bannerHomeEl = document.getElementById('banner-home');
if (bannerHomeEl) {
    createApp(BannerHome).mount(bannerHomeEl);
}

const newsHome = document.getElementById('news-home');
if (newsHome) {
    createApp(NewsHome).mount(newsHome);
}
