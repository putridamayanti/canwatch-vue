<template>
    <v-content class="app-content">
        <AppSubheaderComponent v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header" dark>
                            <v-toolbar-title class="subheading">Playlists</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-data-table
                                    :headers="headers"
                                    :items="items"
                                    hide-actions
                                    class="elevation-0 app-table"
                                    dark
                            >
                                <template slot="items" slot-scope="props">
                                    <td>
                                        <img class="thumbnail-video" :src="props.item.thumbnail_120_url"/>
                                        <strong>{{ props.item.title }}</strong>
                                    </td>
                                    <td>
                                        <div class="form-btn">
                                            <v-btn color="pink darken-1" dark @click="openVideo(props.item.id)">
                                                Open
                                            </v-btn>
                                        </div>
                                    </td>
                                </template>
                            </v-data-table>
                        </v-card-text>
                        <v-dialog
                                v-model="videoModal"
                                fullscreen
                                hide-overlay transition="dialog-bottom-transition"
                        >
                            <v-card>
                                <v-toolbar dark color="pink darken-1">
                                    <v-toolbar-title>{{ videoTitle }}</v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn icon dark @click="closeVideo()">
                                        <v-icon>close</v-icon>
                                    </v-btn>
                                </v-toolbar>
                                <div class="video" v-html="video"></div>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>
            </v-layout>
        </div>
    </v-content>
</template>

<script>
    import AppSubheaderComponent from "../../../component/AppSubheaderComponent";
    import playlist from '../../../service/playlist';
    export default {
        name: "DetailPlaylistPage",
        components: {AppSubheaderComponent},
        props: {
            id: String
        },
        data() {
            return {
                videoModal: false,
                headers: [
                    { text: 'Name' },
                    { text: 'Action', sortable: false, width: 300 },
                ],
                items: [],
                form: {},
                video: '',
                videoTitle: ''
            }
        },
        mounted: async function () {
            this.fetch();
            // console.log(this.$route.meta.breadcrumbs);
        },
        methods: {
            async fetch() {
                let response = await playlist.show(this.$route.params.id);
                this.items  = response.original;
                console.log(response.original);
            },
            openVideo(id) {
                let videoEmbed = '', videoTitle = '';
                this.items.forEach(function (item, i) {
                    if (id === item.id) {
                        videoEmbed = item.embed_html;
                        videoTitle = item.title;
                    }
                });
                this.video = videoEmbed;
                this.videoTitle = videoTitle;
                this.videoModal = true;
            },
            closeVideo() {
                this.video = '';
                this.videoModal = false;
            }
        },
    }
</script>

<style scoped>

</style>