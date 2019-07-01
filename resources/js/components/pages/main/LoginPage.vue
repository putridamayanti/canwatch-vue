<template>
    <v-layout>
        <v-flex xs12 sm4 offset-sm4>
            <v-card class="elevation-0 transparent border-light">
                <v-toolbar dark class="mt-5 transparent elevation-0">
                    <v-toolbar-title class="m-auto">LOGIN</v-toolbar-title>
                </v-toolbar>
                <v-card-text primary-title dark>
                    <v-alert
                            :value="true"
                            color="red darken-3 mb-4"
                            transition="scale-transition"
                            v-if="error"
                    >
                        <p class="m-0" v-for="item in errors">{{ item[0] }}</p>
                    </v-alert>
                    <v-form>
                        <v-text-field
                                color="grey lighten-3"
                                v-model="form.email"
                                label="E-mail"
                                required
                                autofocus
                                dark
                        ></v-text-field>
                        <v-text-field
                                color="grey lighten-3"
                                v-model="form.password"
                                label="Password"
                                required
                                type="password"
                                autofocus
                                dark
                        ></v-text-field>
                    </v-form>
                </v-card-text>

                <v-card-actions>
                    <v-btn @click="login" type="submit" dark color="pink lighten-1">
                        <span v-if="!loadingPost">LOGIN</span>
                        <img v-else src="/img/loading-rolling-white.svg"/>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import auth from '../../service/auth';
    export default {
        name: "LoginPage",
        data() {
            return {
                loading: true,
                loadingPost: false,
                form : {},
                error: false,
                errors: []
            }
        },
        methods: {
            async login() {
                this.errors = [];
                console.log(this.form);
                let response = await auth.login(this.form);
                console.log('Response', response.errors);
                if (response.status === 'success') {
                    window.localStorage.setItem('user', JSON.stringify(response.data));
                    this.$router.push({name: 'Dashboard'});
                } else {
                    this.error = true;
                    if (response.status === 'error') {
                        this.errors = response.errors;
                        console.log(this.errors);
                    } else {
                        this.errors.push([response.error.response.data.message]);
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>