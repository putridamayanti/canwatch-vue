import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import HomePage from './components/pages/main/HomePage';
import LoginPage from './components/pages/main/LoginPage';
import DetailPage from './components/pages/main/DetailPage';
import ListPage from './components/pages/main/ListPage';
import DramaPage from './components/pages/main/DramaPage';

import DashboardPage from './components/pages/app/DashboardPage';
import CategoryPage from './components/pages/app/CategoryPage';
import ResourcePage from './components/pages/app/ResourcePage';
import CountryPage from './components/pages/app/CountryPage';
import SeriesPage from './components/pages/app/series/SeriesPage';
import FormSeriesPage from './components/pages/app/series/FormSeriesPage';
import PlaylistsPage from './components/pages/app/series/PlaylistsPage';
import FormPlaylistPage from './components/pages/app/series/FormPlaylistPage';
import DetailPlaylistPage from './components/pages/app/series/DetailPlaylistPage';
import EpisodesPage from './components/pages/app/series/EpisodesPage';
import FormEpisodePage from './components/pages/app/series/FormEpisodePage';

const routes = [
    { name: 'Home', path: '/', component: HomePage },
    { name: 'Login', path: '/login', component: LoginPage },
    { name: 'List', path: '/list/:type', component: ListPage },
    { name: 'Drama', path: '/drama', component: DramaPage },
    { name: 'Detail', path: '/:slug', component: DetailPage },
    { name: 'Dashboard', path: '/admin/dashboard', component: DashboardPage, meta: { requireAuth: true, breadcrumbs: [ { text: 'Dashboard', disabled: true }] } },
    {
        name: 'Category',
        path: '/admin/category',
        component: CategoryPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Category', disabled: true, to: 'dashboard' }
            ]
        }
    },
    {
        name: 'Resource',
        path: '/admin/resource',
        component: ResourcePage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: 'dashboard' },
                { text: 'Resource', disabled: true }
            ]
        }
    },
    {
        name: 'Country',
        path: '/admin/country',
        component: CountryPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: 'dashboard' },
                { text: 'Country', disabled: true }
            ]
        }
    },
    {
        name: 'Series',
        path: '/admin/series',
        component: SeriesPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: 'dashboard' },
                { text: 'Series', disabled: true }
            ]
        }
    },
    {
        name: 'Form Series',
        path: '/admin/series/form/:id',
        component: FormSeriesPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Series', disabled: false, to: '/admin/series' },
                { text: 'Form', disabled: true }
            ]
        }
    },
    {
        name: 'Playlists',
        path: '/admin/series/playlists',
        component: PlaylistsPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Series', disabled: false, to: '/admin/series' },
                { text: 'Playlist', disabled: true },
            ]
        }
    },
    {
        name: 'Form Playlist',
        path: '/admin/series/playlist/form/:id',
        component: FormPlaylistPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Series', disabled: false, to: '/admin/series' },
                { text: 'Playlist', disabled: false, to: '/admin/series/playlists' },
                { text: 'Form', disabled: true },
            ]
        }
    },
    {
        name: 'Detail Playlist',
        path: '/admin/series/playlist/detail/:id',
        component: DetailPlaylistPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Series', disabled: false, to: '/admin/series' },
                { text: 'Playlist', disabled: false, to: '/admin/series/playlists' },
                { text: 'Detail', disabled: true },
            ]
        }
    },
    {
        name: 'Episodes',
        path: '/admin/series/episodes',
        component: EpisodesPage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Series', disabled: false, to: '/admin/series' },
                { text: 'Episodes', disabled: true },
            ]
        }
    },
    {
        name: 'Form Episode',
        path: '/admin/series/episode/form/:id',
        component: FormEpisodePage,
        props: true,
        meta: {
            requireAuth: true,
            breadcrumbs: [
                { text: 'Dashboard', disabled: false, to: '/admin/dashboard' },
                { text: 'Series', disabled: false, to: '/admin/series' },
                { text: 'Episodes', disabled: false, to: '/admin/series/episodes' },
                { text: 'Form Episode', disabled: true },
            ]
        }
    },
];

const router = new VueRouter({ mode: 'history', routes: routes });
router.beforeEach((to, from, next) => {
    if(to.meta.requireAuth) {
        if (window.localStorage.getItem('user') === true) {
            next('/admin/dashboard');
        } else {
            next();
        }
    } else {
        next()
    }
});

export default router;