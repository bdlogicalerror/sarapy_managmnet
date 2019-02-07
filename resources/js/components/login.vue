<template>
    <v-app id="inspire">
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-12">
                            <v-toolbar dark color="primary">
                                <v-toolbar-title>Login</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-tooltip bottom>
                                    <span>Source</span>
                                </v-tooltip>
                                <v-tooltip right>

                                </v-tooltip>
                            </v-toolbar>
                            <v-card-text>
                                <v-form>
                                    <v-text-field
                                            v-model="username"
                                            :rules="nameRules"
                                            :counter="10"
                                            label="Username"
                                            required
                                            prepend-icon="person" name="login" type="text"></v-text-field>
                                    <v-text-field
                                            v-model="password"
                                            :rules="passRules"
                                            label="Password"
                                            required
                                            prepend-icon="lock" name="password" type="password"></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn @click="login" color="primary">Login</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: "login",
        data: () => ({
            valid: false,
            username: '',
            nameRules: [
                v => !!v || 'Name is required',
                v => v.length <= 10 || 'Name must be less than 10 characters'
            ],
            password: '',
            passRules: [
                v => !!v || 'E-mail is required',
            ]
        }),

        created(){
            fetch('/check')
                .then(res => res.json())
                .then(res => {

                    if(res.login){
                        console.log('already logged')
                        this.$router.push('/')
                    }else{
                        console.log('not logged')
                    }
                })
        },
        methods:{
            login(){
                axios.post('/login',{
                    header:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:{
                        'username':this.username,
                        'password':this.password
                    }
                })
                    .then(res=>{
                            if(res.data.status){
                                window.location='/';
                            }
                        }
                    )
                    .catch(error=>console.log(error))

            }
        }
    }
</script>

<style scoped>

</style>
