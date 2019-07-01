<template>
    <v-content class="content">
        <div v-if="loading" class="loading">
            <img src="/img/loading-ripple.svg"/>
        </div>
        <v-container grid-list-lg v-else>
            <v-layout row>
                <v-flex xs3>
                    <v-card>
                        <v-card-text>
                            <img :src="image(detail.image)" width="100%" class="mb-3"/>
                            <h3 class="pink--text">{{ detail.title }} {{ detail.year }}</h3>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex xs9>
                    <v-card class="mb-4">
                        <v-card-text>
                            <h5>Synopsis</h5>
                            <div v-html="detail.description"></div>
                            <p class="mb-1">
                                Resource :
                                <span v-for="(item, i) in detail.resource">
                                    <router-link :to="item.resource.link" _target="blank">{{ item.resource.name }}</router-link>
                                    <span v-if="i+1 < detail.category.length">, </span>
                                </span>
                            </p>
                            <p class="mb-1">Country : {{ detail.country.name }}</p>
                            <p class="mb-1">Genre :
                                <span v-for="(item, i) in detail.category">
                                    {{ item.category.name }}
                                    <span v-if="i+1 < detail.category.length">, </span>
                                </span>
                            </p>
                        </v-card-text>
                    </v-card>
                    <v-card class="mb-4" v-if="videoEmbed !== ''">
                        <v-card-text>
                            <div class="video-play" v-html="videoEmbed">
                                <img src="/img/loading2.svg"/>
                            </div>
                            <h5 class="mt-2 text-center">{{ videoTitle }}</h5>
                        </v-card-text>
                    </v-card>
                    <v-card>
                        <v-toolbar color="grey darken-3" dark>
                            <v-toolbar-title>Watch {{ detail.title }}</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <infinite-loading @distance="1" @infinite="infiniteHandler"></infinite-loading>
                            <v-list two-line>
                                <template v-for="(item, index) in items">
                                    <v-list-tile :key="index" avatar ripple @click="">
                                        <img v-if="item.thumbnail_120_url" class="thumbnail-video" :src="item.thumbnail_120_url"/>
                                        <v-list-tile-content>
                                            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                        </v-list-tile-content>
                                        <v-list-tile-action>
                                            <v-btn color="pink accent-3" dark @click="video(item.id)">Play</v-btn>
                                        </v-list-tile-action>
                                    </v-list-tile>
                                    <v-divider v-if="index + 1 < items.length" :key="`divider-${index}`"></v-divider>
                                </template>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
    import homepage from '../../service/homepage';
    import series from '../../service/series';
    export default {
        name: "DetailPage",
        props: {
            slug: String
        },
        data() {
            return {
                items: [],
                detail: [],
                title: '',
                country: '',
                genre: [],
                description: '',
                resources: [],
                loading: true,
                videoEmbed: '',
                page: 1
            }
        },
        mounted: function () {
            console.log(this.$route.params.slug);
            this.fetch();
        },
        methods: {
            async fetch() {
                let response = await homepage.detail(this.$route.params.slug);
                console.log(response);
                let video = [];
                if (response.type === 'dailymotion') {
                    video = response.data.original;
                } else {
                    video = response.data;
                }
                this.detail = response.detail;
                this.items  = video;
                this.title = response.detail.title;
                this.country = response.detail.country.name;
                this.genre = response.detail.category;
                this.description = response.detail.description;
                this.resources = response.detail.resource;
                this.loading = false;
            },
            async infiniteHandler($state) {
                let vm = this;
                let response = await homepage.detail(this.$route.params.slug);
                this.$http.get('/posts?page='+this.page)
                    .then(response => {
                        return response.json();
                    }).then(data => {
                    $.each(data.data, function(key, value) {
                        vm.list.push(value);
                    });
                    $state.loaded();
                });

                this.page = this.page + 1;
            },
            image(name) {
                return '/uploads/series/'+name;
            },
            video(id){
                let videoEmbed = '', videoTitle = '';
                this.items.forEach(function (item, i) {
                    if (id === item.id) {
                        videoEmbed = item.embed_html;
                        videoTitle = item.title;
                    }
                });
                this.videoEmbed = videoEmbed;
                this.videoTitle = videoTitle;
            },
            loadMore: function () {
                var self = this;
                self.busy = true;
                console.log('loading... ' + new Date());
                setTimeout(function () {
                    var app = document.querySelector('.app')
                    var height = app.clientHeight;
                    app.style.height = height + 300 + 'px';
                    console.log('end... ' + new Date());
                    self.busy = false
                }, 1000)
            }
        }
    }
</script>

<style scoped>

</style>