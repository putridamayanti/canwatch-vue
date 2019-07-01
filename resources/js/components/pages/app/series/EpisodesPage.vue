<template>
    <v-content class="app-content loader" v-if="loading">
        <img src="/img/loading-ripple.svg"/>
    </v-content>
    <v-content class="app-content" v-else>
        <AppSubheaderComponent title="Episodes" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header">
                            <v-toolbar-title class="white--text">Episodes</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn :to="{name: 'Form Episode'}" flat icon color="pink">
                                <v-icon>add</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-data-table
                                    :headers="headers"
                                    :items="items"
                                    class="app-table elevation-0"
                                    dark
                            >
                                <template slot="items" slot-scope="props">
                                    <td>{{ props.item.series.title }} {{ props.item.series.year }} ( {{ props.item.title }} )</td>
                                    <td>
                                        <div class="form-btn">
                                            <v-btn small :to="{ name: 'Form Episode', params: { id: props.item.id }}" flat icon color="lime darken-2" dark>
                                                <v-icon small>edit</v-icon>
                                            </v-btn>
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
    import episode from '../../../service/episodes';
    export default {
        name: "EpisodesPage",
        components: {AppSubheaderComponent},
        data() {
            return {
                loading: true,
                dialog: false,
                deleteModal: false,
                headers: [
                    { text: 'Name' },
                    { text: 'Action', sortable: false, width: 200 },
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
                let response = await episode.index();
                this.items  = response.data;
                console.log(response.data);
                this.loading = false;
            },

            async openDeleteModal(id) {
                this.deleteModal = true;
                this.delete_id  = id;
            },

            async remove(id) {
                let response = await episode.delete(id);
                if (response.data.status) {
                    this.deleteModal = false;
                    this.fetch();
                    this.disableDelete = false;
                }
            },
        }
    }
</script>

<style scoped>

</style>