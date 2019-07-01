<template>
    <v-content class="app-content">
        <AppSubheaderComponent title="Series" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header">
                            <v-toolbar-title class="white--text">Series</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn :to="{name: 'Form Series', params: { id: 'create' }}" flat icon color="pink">
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
                                    <td>{{ props.item.title }}</td>
                                    <td>
                                        <div class="form-btn">
                                            <v-btn flat icon :to="{ name: 'Form Series', params: { id: props.item.id}}" color="lime darken-2" dark>
                                                <v-icon>edit</v-icon>
                                            </v-btn>
                                            <v-btn flat icon @click="openDeleteModal(props.item.id)" color="red darken-2" dark>
                                                <v-icon>delete</v-icon>
                                            </v-btn>
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
    import series from '../../../service/series';
    export default {
        name: "SeriesPage",
        components: {AppSubheaderComponent},
        data() {
            return {
                dialog: false,
                deleteModal: false,
                headers: [
                    { text: 'Name' },
                    { text: 'Action', sortable: false, width: 300 },
                ],
                items: [],
                form: {}
            }
        },
        mounted: async function () {
            this.fetch();
        },
        methods: {
            async fetch() {
                let response = await series.index();
                this.items  = response.data;
            },

            async openModal(id) {
                if (id) {
                    let response = await series.edit(id);
                    console.log('Response Edit ', response);
                    this.form = response;
                    this.dialog = true;
                }
                this.dialog = true;
            },

            async submit() {
                let response = [];
                if (this.form.id) {
                    response = await series.update(this.form.id, this.form)
                } else {
                    response = await series.store(this.form)
                }
                if (response.data.status) {
                    this.dialog = false;
                    this.fetch();
                }
            },

            async openDeleteModal(id) {
                this.deleteModal = true;
                this.delete_id  = id;
            },

            async remove(id) {
                let response = await series.delete(id);
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