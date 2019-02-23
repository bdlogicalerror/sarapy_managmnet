<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>Add User</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'manage_user'}">
                <v-icon>keyboard_backspace</v-icon>
            </v-btn>
        </v-toolbar>

        <v-flex xs12>
            <v-card color="blue-grey darken-2" class="white--text">
                <v-card-title >

                </v-card-title>
                <v-container
                    fill-height
                    fluid
                    pa-2
                >
                    <v-layout fill-height>
                        <v-flex xs12 align-end flexbox>
                            <v-form v-model="valid">
                                <v-text-field
                                    v-model="user.first_name"
                                    :rules="required_rules"
                                    :counter="10"
                                    label="First Name"
                                    required
                                    solo-inverted

                                    class="mx-3"
                                >

                                </v-text-field>

                                <v-text-field
                                    v-model="user.last_name"
                                    :rules="required_rules"
                                    :counter="10"
                                    label="Last Name"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>

                                <v-text-field
                                    v-model="user.username"
                                    :rules="required_rules"
                                    :counter="15"
                                    label="Username"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="user.password"
                                    :counter="15"
                                    label="Password"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-select
                                    :rules="required_rules"
                                    :items="user_type"
                                    v-model="user.user_type"
                                    solo-inverted
                                    class="mx-3"
                                    label="User Type"
                                    :messages="['user Type']"
                                ></v-select>
                                <v-autocomplete v-if="user.user_type=='user'"
                                    v-model="user.branch"
                                    :items="branches"
                                    :filter="customFilter"
                                    color="white"
                                    item-text="name"
                                    item-value="id"
                                    label="Branch Name"
                                    solo-inverted
                                    class="mx-3"
                                    required
                                ></v-autocomplete>

                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_user" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_user">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_user" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_user",
        data: () => ({

            //---------------------------
            hasSaved: false,
            model: null,
            //------------


            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            user:{
                id:"",
                first_name:"",
                last_name:'',
                username:"",
                password:"",
                branch:"",
                user_type:"user",
                delete:false,
            },
            user_type:[
                'user',
                'admin'
            ],
            branches:[]





        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/system/user/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                            this.user.id=res.id;
                            this.user.first_name=res.first_name;
                            this.user.last_name=res.last_name;
                            this.user.username=res.username;
                            this.user.user_type=res.user_type;
                            this.user.branch=res.branch_id;
                    });
                this.edit = true;

            }

            this.get_branches();

        },
        methods:{
            add_user(){
                this.$Progress.start();
                axios.post('/system/user/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.user
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push({name:"manage_user"})
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_user(){
                this.user.delete=true;
                this.update_user();
            },
            update_user(){
                this.$Progress.start();
                axios.put('/system/user/'+this.user.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.user
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.user.no=0;
                        this.user.rent=0;
                        this.$router.push({name:"manage_user"})

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },

            get_branches(){
                fetch('/system/branch')
                    .then(res=>res.json())
                    .then(res=>{
                        this.branches=res;
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            },

            customFilter (item, queryText, itemText) {
                //console.log(queryText)



                const textOne = item.name.toLowerCase()
                const textTwo = item.abbr.toLowerCase()
                const searchText = queryText.toLowerCase()

                return textOne.indexOf(searchText) > -1 ||
                    textTwo.indexOf(searchText) > -1
            },
        }
    }
</script>

<style scoped>

</style>
