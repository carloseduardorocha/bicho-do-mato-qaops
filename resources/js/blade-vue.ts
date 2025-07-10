import { createApp } from 'vue';
import BannerHome from './components/BannerHome.vue';
import BottomNavBar from './components/BottomNavBar.vue';
import NavBar from './components/NavBar.vue';
import NewsHome from './components/NewsHome.vue';
import TestimonialsHome from './components/TestimonialsHome.vue';
import PartnersHome from './components/PartnersHome.vue';
import SocialMediaHome from './components/SocialMediaHome.vue';
import InfoFooter from './components/InfoFooter.vue';
import Institutional from './components/Institutional.vue';

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

const testimonialsHome = document.getElementById('testimonials-home');
if (testimonialsHome) {
    createApp(TestimonialsHome).mount(testimonialsHome);
}

const partnersHome = document.getElementById('partners-home');
if (partnersHome) {
    createApp(PartnersHome).mount(partnersHome);
}

const socialMediaHome = document.getElementById('social-media-home');
if (socialMediaHome) {
    createApp(SocialMediaHome).mount(socialMediaHome);
}

const infoFooter = document.getElementById('info-footer');
if (infoFooter) {
    createApp(InfoFooter).mount(infoFooter);
}

const institutional = document.getElementById('institutional');
if (institutional) {
    createApp(Institutional).mount(institutional);
}

