<template>
    <v-content class="content">
        <v-container grid-list-lg class="p-0">
            <v-layout>
                <v-flex xs5>
                    <v-text-field
                            label="Search Title"
                            v-model="form.keyword"
                            dark
                            color="pink darken-2"
                    ></v-text-field>
                </v-flex>
                <v-flex xs4>
                    <v-text-field
                            label="Year"
                            v-model="form.year"
                            dark
                            color="pink darken-2"
                    ></v-text-field>
                </v-flex>
                <v-flex xs4>
                    <v-select
                            class="select"
                            :items="categoryItems"
                            item-text="name"
                            item-value="id"
                            label="Standard"
                            v-model="form.category"
                            dark
                            color="pink darken-2"
                    ></v-select>
                </v-flex>
                <v-flex xs1>
                    <v-btn color="blue lighten-5" flat icon class="mt-3" @click="search"><v-icon>search</v-icon></v-btn>
                </v-flex>
            </v-layout>
        </v-container>
        <v-container grid-list-lg text-xs-center style="max-width: 100%">
            <p class="text-center text-white mt-4" v-if="empty">No Data</p>
            <v-layout row wrap>
                <v-flex v-for="(item, i) in series" :key="i" xs2>
                    <v-card @click.native="detail(item.slug)" color="grey lighten-3" style="cursor: pointer;">
                        <img v-bind:src="image(item.image)" width="100%" height="270px">
                        <v-card-title  primary-title style="height: 70px; padding-top: 16px; justify-content: center;">
                            {{ getTitle(item.title+' '+item.year)}}
                        </v-card-title>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
    import list from '../../service/list';
    import category from '../../service/category';
    import Multiselect from 'vue-multiselect'
    export default {
        name: "ListPage",
        components: {Multiselect},
        props: {
            type: String
        },
        data() {
            return {
                empty: false,
                series: [],
                form: {},
                loading: true,
                categoryItems: []
            }
        },
        mounted: async function () {
            this.drama();
            let categoryResult = await category.index();
            this.categoryItems = categoryResult.data;
            console.log(this.categoryItems);
        },
        methods: {
            async drama() {
                let response = await list.drama(this.form);
                this.series  = response;
                console.log(this.items);
            },
            async search() {
                this.loading = true;
                let response  = await list.drama(this.form);
                console.log('Result search', response.length);
                if (response.length > 0) {
                    this.empty = false;
                    this.series = response;
                } else {
                    this.series = [];
                    this.empty = true;
                }
                this.loading = false;
            },
            image(name) {
                return '/uploads/series/'+name;
            },
            getTitle (post) {
                let body = post.replace(/(<([^>]+)>)/ig, '');
                return body.length > 35 ? body.substring(0, 35) + '...' : body;
            },
            detail(slug) {
                console.log(slug);
                this.$router.push({ name: 'Detail', params: { slug: slug }});
            }
        }
    }
</script>

<style scoped>
    .v-menu__content {
        top: 30px;
        left: -260px;
    }
</style>