<template>
    <v-layout row wrap>
        <v-toolbar color="primary" dark>
            <v-icon dark right>airline_seat_flat</v-icon>
            <v-toolbar-title>Add Patients Service</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'all_patient_service'}">
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
                                        v-model="service.name"
                                        :rules="required_rules"
                                        :counter="30"
                                        label="Service Name"
                                        required
                                        solo-inverted

                                        class="mx-3"
                                ></v-text-field>



                                <v-text-field
                                        v-model="service.price"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="Price"
                                        required
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>


                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_service" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_service">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_service" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "patient_service",
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
            service:{
                id:"",
                name:"",
                price:'',
                delete:false,
            },




        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/patient/service/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.service.id=res.id;
                        this.service.name=res.name;
                        this.service.price=res.price;
                    });
                this.edit = true;

            }
            axios.get('/gotisoft/resident/ward/search/all')
                .then(res => {
                    this.wards=res.data;
                })

        },
        methods:{
            add_service(){
                this.$Progress.start();
                axios.post('/gotisoft/patient/service/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.service
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push('/patients/services');
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.service.name="";
                        this.service.price=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_service(){
                this.service.delete=true;
                this.update_service();
            },
            update_service(){
                this.$Progress.start();
                axios.put('/gotisoft/patient/service/'+this.service.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.service
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
                        this.service.name="";
                        this.service.price=0;
                        this.$router.push('/patients/services')

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
        }
    }
</script>

<style scoped>

</style>
