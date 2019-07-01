<template>
    <v-content class="app-content">
        <AppSubheaderComponent title="Playlist" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header">
                            <v-toolbar-title class="white--text">Form Playlist</v-toolbar-title>
                        </v-toolbar>
                        <v-container fluid  grid-list-lg>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-alert
                                            :value="true"
                                            color="red darken-3 mb-4"
                                            transition="scale-transition"
                                            v-if="error"
                                    >
                                        Terjadi Kesalahan
                                    </v-alert>
                                </v-flex>
                                <v-flex xs6>
                                    <v-label dark>Series</v-label>
                                    <multiselect v-model="form.seriesSelected" :options="seriesItems"
                                                 label="title" track-by="id" placeholder="Select Series"></multiselect>
                                </v-flex>
                                <v-flex xs6>
                                    <v-label dark>Resource</v-label>
                                    <multiselect v-model="form.resourceSelected" placeholder="Select Resource"
                                                 label="name" track-by="id" :options="resourceItems">
                                    </multiselect>
                                </v-flex>
                                <v-flex xs12>
                                    <v-label dark>Link Playlist</v-label>
                                    <v-text-field solo placeholder="http://" v-model="form.link"></v-text-field>
                                </v-flex>
                                <v-flex xs12 row>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="submit" class="pink darken-3" dark>Submit</v-btn>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>
            </v-layout>
        </div>
    </v-content>
</template>

<script>
    import AppSubheaderComponent from "../../../component/AppSubheaderComponent";
    import Multiselect from 'vue-multiselect'
    import resource from '../../../service/resource';
    import series from '../../../service/series';
    import playlist from '../../../service/playlist';
    export default {
        name: "FormPlaylistPage",
        components: {AppSubheaderComponent, Multiselect},
        data() {
            return {
                loading: true,
                form: {},
                imageName: '',
                editorOption: {},
                seriesItems: [],
                resourceItems: [],
                error: false
            }
        },
        mounted: async function () {
            let seriesResult = await series.index();
            this.seriesItems = seriesResult.data;
            let resourceResult = await resource.index();
            this.resourceItems = resourceResult.data;
            this.fetch();
        },
        methods: {
            async fetch() {
                if (this.$route.params.id !== 'create') {
                    let response = await playlist.edit(this.$route.params.id);
                    console.log(response);
                    this.form   = response;
                    this.form.seriesSelected = response.series;
                    this.form.resourceSelected = response.resources;
                }
                this.loading = false;
            },

            async submit() {
                console.log('Form', this.form);
                let response = [];
                if(this.$route.params.id !== 'create') {
                    response = await playlist.update(this.$route.params.id, this.form);
                } else {
                    response = await playlist.store(this.form);
                }
                console.log('Result', response);
                if (response.data.status === 'success') {
                    this.$router.push({ name: 'Playlists' });
                } else {
                    this.error = true;
                }
            },
        }
    }
</script>

<style scoped>

</style>