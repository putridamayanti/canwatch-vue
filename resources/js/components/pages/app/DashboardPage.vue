<template>
    <div>
        <v-content class="app-content loader" v-if="loading">
            <img src="/img/loading-ripple.svg"/>
        </v-content>
        <v-content class="app-content" v-else>
            <AppSubheaderComponent title="Dashboard" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
            <div class="content white--text">
                <h1>DASHBOARD</h1>
                <h1>DASHBOARD</h1>
                <h1>DASHBOARD</h1>
                <h1>DASHBOARD</h1>
                <h1>DASHdBOARD</h1>
                <h1>DASHdBOARD</h1>
                <h1>DASHdBOARD</h1>
                <h1>DASHdBOARD</h1>
                <h1>DASHddBOARD</h1>
                <h1>DASHddBOARD</h1>
                <h1>DASHddBOARD</h1>
                <h1>DASHddBOARD</h1>
                <h1>DASHddBOARD</h1>
                <h1>DASHddBOARD</h1>
                <h1>DASHddBOARD 11</h1>
            </div>
        </v-content>
    </div>
</template>

<script>
    import AppSubheaderComponent from "../../component/AppSubheaderComponent";
    import AppDrawerComponent from "../../component/AppDrawerComponent";
    export default {
        name: "DashboardPage",
        components: {AppSubheaderComponent},
        data() {
            return {
                loading: true,
                items: []
            }
        },
        mounted: function () {
            this.items = this.$route.meta.breadcrumbs;
            this.loading    = false;
        },
        methods: {
            getBreadcrumb(breadcrumbs) {
                this.items = breadcrumbs;
            }
        }
    }
</script>

<style scoped>

</style>