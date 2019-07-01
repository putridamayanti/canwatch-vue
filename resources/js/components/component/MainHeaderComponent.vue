<template>
    <v-toolbar color="transparent" dark class="main-header">
        <v-toolbar-title>
            <router-link to="/" class="white--text">CANWATCH</router-link>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
            <v-btn flat>Home</v-btn>
            <v-btn flat :to="{ name: 'List', params: { type: 'drama' }}">Drama</v-btn>
            <v-btn flat>Movie</v-btn>
        </v-toolbar-items>
    </v-toolbar>
</template>

<script>
    export default {
        name: "MainHeaderComponent"
    }
</script>

<style scoped>

</style>