<template>
    <v-content class="app-content loader" v-if="loading">
        <img src="/img/loading-ripple.svg"/>
    </v-content>
    <v-content class="app-content" v-else>
        <AppSubheaderComponent title="Form Episode" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header">
                            <v-toolbar-title class="white--text">Form Episode</v-toolbar-title>
                        </v-toolbar>
                        <v-container fluid  grid-list-lg>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-label dark>Series</v-label>
                                    <multiselect v-model="form.seriesSelected" :options="seriesItems"
                                                 label="title" track-by="id" placeholder="Select Series"></multiselect>
                                </v-flex>
                                <v-flex xs12>
                                    <v-label dark>Title</v-label>
                                    <v-text-field solo placeholder="Series Episode" v-model="form.title"></v-text-field>
                                </v-flex>
                                <!--<v-flex xs6>-->
                                    <!--<v-label>Resource</v-label>-->
                                    <!--<multiselect v-model="form.resourceSelected" placeholder="Select Resource"-->
                                                 <!--label="name" track-by="id" :options="resourceItems">-->
                                    <!--</multiselect>-->
                                <!--</v-flex>-->
                                <v-flex xs12>
                                    <v-label dark>Link Source</v-label>
                                    <v-textarea
                                            solo
                                            name="input-7-4"
                                            label="http://"
                                            v-model="form.source"
                                    ></v-textarea>
                                    <!--<v-text-field solo placeholder="http://" v-model="form.source"></v-text-field>-->
                                </v-flex>
                                <v-flex xs12 row>
                                    <v-spacer></v-spacer>
                                    <v-btn color="pink darken-3" dark @click="submit">Submit</v-btn>
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
    import episode from '../../../service/episodes';
    export default {
        name: "FormEpisodePage",
        components: {AppSubheaderComponent, Multiselect},
        data() {
            return {
                loading: true,
                form: {},
                imageName: '',
                editorOption: {},
                seriesItems: [],
                resourceItems: [],
                errors: []
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
                    let response = await episode.edit(this.$route.params.id);
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
                if (this.$route.params.id !== 'create') {
                    response = await episode.update(this.$route.params.id, this.form);
                } else {
                    response = await episode.store(this.form);
                }

                console.log('Result', response);
                if (response.status === 'success') {
                    this.$router.push({ name: 'Episodes' });
                } else {

                }
            },
        }
    }
</script>

<style scoped>

</style>