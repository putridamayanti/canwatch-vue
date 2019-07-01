<template>
    <v-content class="app-content loader" v-if="loading">
        <img src="/img/loading-ripple.svg"/>
    </v-content>
    <v-content class="content" v-else>
        <swiper :options="swiperOption">
            <swiper-slide v-for="item in items" :key="item.id">
                <div class="swiper-zoom-container">
                    <v-card @click.native="detail(item.slug)" color="grey lighten-3" style="cursor: pointer;">
                        <img v-bind:src="image(item.image)">
                        <v-card-title  primary-title style="height: 40px; padding-top: 16px; justify-content: center;">
                            {{ getTitle(item.title+' '+item.year)}}
                        </v-card-title>
                    </v-card>
                </div>
            </swiper-slide>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
        </swiper>

        <v-card class="elevation-0 transparent">
            <v-toolbar class="mt-3 elevation-0 transparent section-header">
                <v-toolbar-title class="white--text">Latest Drama</v-toolbar-title>
            </v-toolbar>
            <v-container grid-list-lg text-xs-center style="max-width: 100%">
                <v-layout row wrap>
                    <v-flex v-for="item in latest" :key="item.id" xs2>
                        <v-card @click.native="detail(item.slug)">
                            <img width="100%" height="270" v-bind:src="image(item.image)">
                            <v-card-title primary-title>
                                {{ getTitle(item.title+' '+item.year)}}
                            </v-card-title>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>

        <v-card class="elevation-0 transparent">
            <v-toolbar class="mt-3 elevation-0 transparent section-header">
                <v-toolbar-title class="white--text">Korean Drama</v-toolbar-title>
            </v-toolbar>
            <v-container grid-list-lg text-xs-center style="max-width: 100%">
                <v-layout row wrap>
                    <v-flex v-for="item in korean" :key="item.id" xs2>
                        <v-card @click.native="detail(item.slug)">
                            <img width="100%" height="270" v-bind:src="image(item.image)">
                            <v-card-title primary-title>
                                {{ getTitle(item.title+' '+item.year)}}
                            </v-card-title>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>

        <v-card class="elevation-0 transparent">
            <v-toolbar class="mt-3 elevation-0 transparent section-header">
                <v-toolbar-title class="white--text">Chinese Drama</v-toolbar-title>
            </v-toolbar>
            <v-container grid-list-lg text-xs-center style="max-width: 100%">
                <v-layout row wrap>
                    <v-flex v-for="item in chinese" :key="item.id" xs2>
                        <v-card @click.native="detail(item.slug)">
                            <img width="100%" height="270" v-bind:src="image(item.image)">
                            <v-card-title primary-title>
                                {{ getTitle(item.title+' '+item.year)}}
                            </v-card-title>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-content>
</template>

<script>
    import homepage from '../../service/homepage';
    export default {
        name: "HomePage",
        data() {
            return {
                swiperOption: {
                    slidesPerView: 6,
                    spaceBetween: 30,
                    centeredSlides: false,
                    loop: true,
                    preloadImages: true,
                    autoplay: {
                        delay: 8000,
                        disableOnInteraction: false
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    },
                    breakpoints: {
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 20
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30
                        },
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20
                        },
                        320: {
                            slidesPerView: 1,
                            spaceBetween: 10
                        }
                    }
                },
                items: [],
                latest: [],
                korean: [],
                chinese: [],
                loading: true,
            }
        },
        mounted : function () {
            this.fetchTop();
        },
        methods: {
            async fetchTop() {
                let response = await homepage.index();
                this.items = response.top;
                this.latest = response.latest;
                this.korean = response.korean;
                this.chinese = response.chinese;
                console.log(this.items);
                this.loading = false;
            },
            getTitle (post) {
                let body = post.replace(/(<([^>]+)>)/ig, '');
                return body.length > 35 ? body.substring(0, 35) + '...' : body;
            },
            image(name) {
                return '/uploads/series/'+name;
            },
            detail(slug) {
                console.log(slug);
                this.$router.push({ name: 'Detail', params: { slug: slug }});
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>