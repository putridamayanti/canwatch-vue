<template>
    <v-card color="transparent" dark row style="box-shadow: none; margin: 0 20px; padding-top: 15px">
        <v-card-text style="width: 50%; float: left; font-size: 16px;">{{ title }}</v-card-text>
        <v-spacer></v-spacer>
        <v-breadcrumbs class="ml-auto" style="display: block; text-align: right" :items="breadcrumbs" divider=">"></v-breadcrumbs>
    </v-card>
</template>

<script>
    export default {
        name: "AppSubheaderComponent",
        props: {
            title: String,
            breadcrumbs: { type: Array }
        }
    }
</script>

<style scoped>

</style>