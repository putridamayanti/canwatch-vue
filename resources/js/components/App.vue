<template>
    <div>
        <v-app>
            <MainHeaderComponent v-if="isMainPage"/>
            <AppDrawerComponent v-else/>
            <transition name="fade">
                <router-view></router-view>
            </transition>
        </v-app>
    </div>
</template>

<script>
    import MainHeaderComponent from "./component/MainHeaderComponent";
    import AppDrawerComponent from "./component/AppDrawerComponent";
    import AppHeaderComponent from "./component/AppHeaderComponent";
    export default {
        name: "App",
        components: {AppHeaderComponent, AppDrawerComponent, MainHeaderComponent },
        data() {
            return {
                isMainPage: true,
                isAuthenticated: false,
                drawer: true,
            }
        },
        computed: {
            getFullPath () {
                console.log('Router : '+this.$route.name);
                if (window.localStorage.getItem('user')){
                    this.isAuthenticated = true;
                }
                let url = this.$route.path;
                console.log('Path '+url);
                if (url.search('admin') !== -1) {
                    if (this.isAuthenticated) {
                        this.isMainPage = false;
                    } else {
                        this.isMainPage = true;
                        this.$router.push({name: 'Login'});
                    }
                } else {
                    this.isMainPage   = true;
                }
                return this.$route.path
            }
        },
        watch: {
            getFullPath () {

            }
        },
        mounted: function () {

            let url = window.location.pathname;
            if (url.search('admin') !== -1) {
                if (this.isAuthenticated) {
                    this.isMainPage = false;
                } else {
                    this.isMainPage = true;
                    this.$router.push({name: 'Login'});
                }
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>