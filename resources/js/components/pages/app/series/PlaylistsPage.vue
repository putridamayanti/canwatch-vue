<template>
    <v-content class="app-content">
        <AppSubheaderComponent title="Playlist" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header" dark>
                            <v-toolbar-title class="subheading">Playlists</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn :to="{name: 'Form Playlist', params: { id: 'create' }}" flat icon color="pink">
                                <v-icon>add</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-data-table
                                    :headers="headers"
                                    :items="items"
                                    class="elevation-0 app-table"
                                    dark
                            >
                                <template slot="items" slot-scope="props">
                                    <td>{{ props.item.series.title }}</td>
                                    <td>
                                        <div class="form-btn">
                                            <v-btn flat icon :to="{ name: 'Form Playlist', params: { id: props.item.id }}" color="lime darken-2" dark><v-icon>edit</v-icon></v-btn>
                                            <v-btn flat icon :to="{ name: 'Detail Playlist', params: { id: props.item.id }}" color="amber darken-2" dark><v-icon>visibility</v-icon></v-btn>
                                            <v-btn flat icon @click="openDeleteModal(props.item.id)" color="red darken-2" dark><v-icon>delete</v-icon></v-btn>
                                        </div>
                                    </td>
                                </template>
                            </v-data-table>
                            <v-dialog v-model="deleteModal" width="500">
                                <v-card class="card-blue" dark>
                                    <v-card-text>
                                        Are you sure want to delete data?
                                    </v-card-text>

                                    <v-divider></v-divider>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn :disabled="disableDelete" color="red lighten-4" flat @click="remove(delete_id)">Yes</v-btn>
                                        <v-btn :disabled="disableDelete" color="grey" flat @click="deleteModal = false">Cancel</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </v-card-text>
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
        name: "PlaylistsPage",
        components: {AppSubheaderComponent},
        data() {
            return {
                dialog: false,
                deleteModal: false,
                headers: [
                    { text: 'Name' },
                    { text: 'Action', sortable: false, width: 400 },
                ],
                items: [],
                form: {},
                disableDelete: false
            }
        },
        mounted: async function () {
            this.fetch();
            // console.log(this.$route.meta.breadcrumbs);
        },
        methods: {
            async fetch() {
                let response = await playlist.index();
                this.items  = response.data;
                console.log(response.data);
            },

            async openDeleteModal(id) {
                this.deleteModal = true;
                this.delete_id  = id;
            },

            async remove(id) {
                let response = await playlist.delete(id);
                if (response.data.status) {
                    this.deleteModal = false;
                    this.fetch();
                }
            },
        }
    }
</script>

<style scoped>

</style>