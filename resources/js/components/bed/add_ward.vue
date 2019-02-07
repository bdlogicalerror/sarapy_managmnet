<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>Add Ward</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'all_wards'}">
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
                                        v-model="Ward.no"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="Ward No"
                                        required
                                        solo-inverted
                                ></v-text-field>


                                <v-text-field
                                        v-model="Ward.name"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="Ward Name"
                                        required
                                        solo-inverted
                                ></v-text-field>


                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_Ward" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_Ward">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_Ward" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_Ward",
        data: () => ({
            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            Ward:{
                id:"",
                no:"",
                name:'',
                delete:false,
            }

        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/resident/ward/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.Ward.id=res.id;
                        this.Ward.no=res.ward_no;
                        this.Ward.name=res.ward_name;
                    });
                this.edit = true;

            }
        },
        methods:{
            add_Ward(){
                this.$Progress.start();
                axios.post('/gotisoft/resident/ward/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.Ward
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.Ward.no=0;
                        this.Ward.rent=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_Ward(){
                this.Ward.delete=true;
                this.update_Ward();
            },
            update_Ward(){
                this.$Progress.start();
                axios.put('/gotisoft/resident/ward/'+this.Ward.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.Ward
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
                        this.Ward.no=0;
                        this.Ward.rent=0;
                        this.$router.push('/resident/wards')

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            }
        }
    }
</script>

<style scoped>

</style>
