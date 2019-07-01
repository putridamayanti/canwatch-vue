<template>
    <v-content class="app-content loader" v-if="loading">
        <img src="/img/loading-ripple.svg"/>
    </v-content>
    <v-content class="app-content" v-else>
        <AppSubheaderComponent title="Series" v-bind:breadcrumbs="this.$route.meta.breadcrumbs"/>
        <div class="content">
            <v-layout>
                <v-flex xs12>
                    <v-card class="card-blue">
                        <v-toolbar class="card-header">
                            <v-toolbar-title class="white--text">Series</v-toolbar-title>
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
                                <v-flex xl2 lg3 md3 sm3 xs12>
                                    <img v-bind:src="image(form.image)" width="100%" v-if="this.$route.params.id !== 'create'"/>
                                    <img :src="imageView" width="100%" v-else/>
                                    <v-text-field solo placeholder="Browse" @click='pickFile' v-model='imageName' append-icon='attach_file'></v-text-field>
                                    <input
                                            type="file"
                                            style="display: none"
                                            ref="image"
                                            accept="image/*"
                                            @change="onImageChange"
                                    >
                                </v-flex>
                                <v-flex xl10 lg9 md9 sm9 xs12 grid-list-lg>
                                    <v-layout row wrap>
                                        <v-flex xs12>
                                            <label class="text-white">Title</label>
                                            <v-text-field solo placeholder="Series Title" v-model="form.title"></v-text-field>
                                        </v-flex>
                                        <v-flex xs6>
                                            <label class="text-white">Year</label>
                                            <v-text-field solo placeholder="Release Year" v-model="form.year"></v-text-field>
                                        </v-flex>
                                        <v-flex xs6>
                                            <label class="text-white">Country</label>
                                            <multiselect v-model="form.country_id" placeholder="Select Country" label="name"
                                                         track-by="id" :options="countryItems">
                                            </multiselect>
                                        </v-flex>
                                        <v-flex xs6>
                                            <label class="text-white">Category</label>
                                            <multiselect multiple v-model="form.categorySelected" :options="categoryItems"
                                                         label="name" track-by="id" placeholder="Select Category"></multiselect>
                                        </v-flex>
                                        <v-flex xs6>
                                            <label class="text-white">Resource</label>
                                            <multiselect v-model="form.resourceSelected" placeholder="Select Resource"
                                                         label="name" track-by="id" :options="resourceItems" :multiple="true">
                                            </multiselect>
                                        </v-flex>
                                    </v-layout>

                                </v-flex>
                                <v-flex xs12>
                                    <label class="text-white">Description</label>
                                    <quill-editor
                                            class="quill"
                                            v-model="form.description"
                                            :content="form.description"
                                            :options="editorOption"
                                    >
                                    </quill-editor>
                                </v-flex>
                                <v-flex xs12 row>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="submit" color="red lighten-2" dark>Submit</v-btn>
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
    import series from '../../../service/series';
    import resource from '../../../service/resource';
    import country from '../../../service/country';
    import category from '../../../service/category';
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import { quillEditor } from 'vue-quill-editor';
    import Multiselect from 'vue-multiselect'
    export default {
        name: "FormSeriesPage",
        components: {AppSubheaderComponent, quillEditor, Multiselect},
        props: {
            id: String
        },
        data() {
            return {
                loading: true,
                form: {},
                imageName: '',
                imageView: '',
                editorOption: {},
                categoryItems: [],
                countryItems: [],
                resourceItems: [],
                error: false
            }
        },
        mounted: async function () {
            this.imageView      = 'https://dummyimage.com/250x310/d6d6d6/ffffff.jpg&text=No+Image';
            let categoryResult = await category.index();
            this.categoryItems = categoryResult.data;
            let countryResult = await country.index();
            this.countryItems = countryResult.data;
            let resourceResult = await resource.index();
            this.resourceItems = resourceResult.data;

            let response = '';
            if (this.$route.params.id !== 'create') {
                response = await series.edit(this.$route.params.id);
                this.form = response.data;
                let categories = [];
                response.data.category.forEach(function (item, i) {
                    categories.push(item.category);
                });
                this.form.categorySelected = categories;
                console.log(this.form.categorySelected);
                this.form.country_id = response.data.country;
                let resources = [];
                response.data.resource.forEach(function (item) {
                    resources.push(item.resource);
                });
                this.form.resourceSelected = resources;
                console.log('Form ', this.form);
            }

            this.loading    = false;
            console.log('Response ', response);
        },
        methods: {
            pickFile () {
                this.$refs.image.click ()
            },

            onFilePicked (e) {
                const files = e.target.files;
                console.log('File: ', files);
                if(files[0] !== undefined) {
                    this.imageName = files[0].name;
                    if(this.imageName.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader ();
                    fr.readAsDataURL(files[0]);
                    fr.addEventListener('load', () => {
                        this.imageUrl = fr.result;
                        this.form.imageFile = files[0]; // this is an image file that can be sent to server...
                        this.form.image = this.imageName;
                    })
                } else {
                    this.imageName = '';
                    this.form.imageFile = '';
                    this.imageUrl = '';
                    this.form.image = '';
                }
            },
            image(name) {
                return '/uploads/series/'+name;
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.imageName = files[0].name;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.image = e.target.result;
                    this.imageView  = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            async submit() {
                console.log('Form', this.form);
                let response = [];
                if (this.$route.params.id !== 'create') {
                    response= await series.update(this.$route.params.id, this.form);
                    console.log('Store');
                } else {
                    response= await series.store(this.form);
                    console.log('Update');
                }

                console.log('Result', response);
                if (response.status === 'success') {
                    this.$router.push({ name: 'Series' });
                } else {
                    this.error  = true;
                }
            },
        }
    }
</script>

<style scoped>

</style>