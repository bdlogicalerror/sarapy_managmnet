<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>Add Currency</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'manage_currency'}">
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
                                    v-model="Currency.name"
                                    :rules="required_rules"
                                    :message="['Currency Name']"
                                    :counter="20"
                                    label="Name"
                                    required
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>

                                <v-text-field
                                    v-model="Currency.ex_rate"
                                    :counter="15"
                                    label="Ex Rate"
                                    :message="['Exchange Rate']"
                                    solo-inverted
                                    class="mx-3"
                                ></v-text-field>

                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_Currency" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_Currency">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_Currency" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>

    </v-layout>
</template>

<script>
    export default {
        name: "add_Currency",
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
            Currency:{
                id:"",
                name:'',
                ex_rate:0,
                delete:false,
            },





        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/system/currency/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                            this.Currency.id=res.id;
                            this.Currency.name=res.name;
                            this.Currency.ex_rate=res.ex_rate;
                    });
                this.edit = true;

            }else{

            }

        },
        methods:{
            add_Currency(){
                this.$Progress.start();
                axios.post('/system/currency/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'multipart/form-data'
                    },
                    body:this.Currency
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push({name:"manage_currency"})
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.Currency.no=0;
                        this.Currency.rent=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_Currency(){
                this.Currency.delete=true;
                this.update_Currency();
            },
            update_Currency(){
                this.$Progress.start();
                axios.put('/system/currency/'+this.Currency.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.Currency
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
                        this.Currency.no=0;
                        this.Currency.rent=0;
                        this.$router.push({name:"manage_currency"})

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
