<template>
    <div>
        <v-content class="app-content loader" v-if="loading">
            <img src="/img/loading-ripple.svg"/>
        </v-content>
        <v-content class="app-content">
            <AppSubheaderComponent title="Resource" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
            <div class="content">
                <v-layout>
                    <v-flex xs12>
                        <v-card class="card-blue">
                            <v-toolbar class="card-header">
                                <v-toolbar-title class="white--text">Resources</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-btn @click="openModal()" flat icon color="pink">
                                    <v-icon>add</v-icon>
                                </v-btn>
                            </v-toolbar>
                            <v-dialog v-model="dialog" width="500" class="mb-4">
                                <v-card class="card-blue" dark>
                                    <v-card-title class="transparent">
                                        Add New Resource
                                    </v-card-title>

                                    <v-card-text>
                                        <v-form>
                                            <v-text-field
                                                    v-model="form.name"
                                                    label="Name"
                                                    required
                                            ></v-text-field>
                                            <v-text-field
                                                    v-model="form.link"
                                                    label="Link"
                                                    required
                                            ></v-text-field>
                                        </v-form>
                                    </v-card-text>

                                    <v-divider></v-divider>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn :disabled="disableSubmit" color="red lighten-4" flat @click="submit">Submit</v-btn>
                                        <v-btn :disabled="disableSubmit" color="grey" flat @click="dialog = false">Cancel</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-card-text>
                                <v-data-table
                                        :headers="headers"
                                        :items="items"
                                        class="elevation-0 app-table"
                                        dark
                                >
                                    <template slot="items" slot-scope="props">
                                        <td>{{ props.item.name }}</td>
                                        <td>
                                            <div class="form-btn">
                                                <v-btn flat icon :disabled="disableSubmit" @click="openModal(props.item.id)" color="lime darken-2" dark>
                                                    <v-icon>edit</v-icon>
                                                </v-btn>
                                                <v-btn flat icon :disabled="disableSubmit" @click="openDeleteModal(props.item.id)" color="red darken-2" dark>
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
        </v-content>s
    </div>
</template>

<script>
    import AppSubheaderComponent from "../../component/AppSubheaderComponent";
    import resource from '../../service/resource';
    import AppDrawerComponent from "../../component/AppDrawerComponent";
    export default {
        name: "ResourcePage",
        components: {AppSubheaderComponent},
        data() {
            return {
                loading: true,
                dialog: false,
                deleteModal: false,
                headers: [
                    { text: 'Name' },
                    { text: 'Action', sortable: false, width: 300 },
                ],
                items: [],
                form: {},
                disableSubmit: false,
                disableDelete: false
            }
        },
        mounted: async function () {
            this.fetch();
        },
        methods: {
            async fetch() {
                let response = await resource.index();
                this.items  = response.data;
                console.log(response.data);
                this.loading    = false;
            },

            async openModal(id) {
                console.log('ID '+id);
                this.form = {};
                if (id) {
                    let response = await resource.edit(id);
                    console.log('Response Edit ', response);
                    this.form = response;
                    this.dialog = true;
                }
                this.dialog = true;
            },

            async submit() {
                this.disableSubmit = true;
                let response = [];
                if (this.form.id) {
                    response = await resource.update(this.form.id, this.form)
                } else {
                    response = await resource.store(this.form)
                }
                console.log(response);
                if (response.data.status) {
                    this.dialog = false;
                    this.fetch();
                }
                this.disableSubmit = false;
            },

            async openDeleteModal(id) {
                this.deleteModal = true;
                this.delete_id  = id;
            },

            async remove(id) {
                this.disableDelete = true;
                let response = await resource.delete(id);
                console.log(response);
                if (response.data.status) {
                    this.deleteModal = false;
                    this.fetch();
                }
                this.disableDelete = false;
            },
        }
    }
</script>

<style scoped>

</style>