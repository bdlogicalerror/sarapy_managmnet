<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>Add Branch</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'manage_branch'}">
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
                                    v-model="Branch.name"
                                    :rules="required_rules"
                                    :counter="25"
                                    label="Name"
                                    required
                                    solo-inverted

                                    class="mx-3"
                                >

                                </v-text-field>


                                <v-text-field
                                    v-model="Branch.mobile"
                                    :counter="15"
                                    label="Mobile"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="Branch.phone"
                                    :counter="15"
                                    label="Phone"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="Branch.email"
                                    :counter="15"
                                    label="email"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                    v-model="Branch.address"
                                    :counter="15"
                                    label="address"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>

                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_Branch" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_Branch">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_Branch" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_Branch",
        data: () => ({

            //---------------------------
            hasSaved: false,
            model: null,
            wards: [

            ],
            //------------


            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            Branch:{
                id:"",
                name:"",
                mobile:"",
                phone:"",
                email:"",
                address:"",
                delete:false,
            }




        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/system/branch/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                            this.Branch.id=res.id;
                            this.Branch.name=res.name;
                            this.Branch.mobile=res.mobile;
                            this.Branch.phone=res.phone;
                            this.Branch.email=res.email;
                            this.Branch.address=res.address;
                    });
                this.edit = true;

            }

        },
        methods:{
            add_Branch(){
                this.$Progress.start();
                axios.post('/system/branch/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.Branch
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push({name:"manage_branch"});
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.Branch.no=0;
                        this.Branch.rent=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_Branch(){
                this.Branch.delete=true;
                this.update_Branch();
            },
            update_Branch(){
                this.$Progress.start();
                axios.put('/system/branch/'+this.Branch.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.Branch
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
                        this.Branch.no=0;
                        this.Branch.rent=0;
                        this.$router.push({name:"manage_branch"});

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },

            customFilter (item, queryText, itemText) {
                console.log(queryText)



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
