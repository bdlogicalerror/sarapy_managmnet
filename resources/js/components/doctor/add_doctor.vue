<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>contact_mail</v-icon>
            <v-toolbar-title>Add Doctor</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'all_doctors'}">
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
                                        v-model="doctor.name"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Name"
                                        required
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>


                                <v-text-field
                                        v-model="doctor.special_on"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Special On"
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>

                                <v-text-field
                                        v-model="doctor.dgree"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Dgree"
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                        v-model="doctor.mobile"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Mobile"
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                        v-model="doctor.address"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Address"
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>

                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn solo-inverted class="mx-3" v-if="!this.edit && this.valid"  @click="add_doctor" color="primary">Add</v-btn>
                    <v-btn solo-inverted class="mx-3" v-else-if="this.edit && this.valid" color="success" @click="update_doctor">Update</v-btn>
                    <v-btn solo-inverted class="mx-3" v-if="this.edit" @click="delete_doctor" color="error">Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_doctor",
        data: () => ({
            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            doctor:{
                id:"",
                name:"",
                special_on:"",
                dgree:"",
                mobile:"",
                address:"",
                delete:false,
            }

        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/doctor/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.doctor.id=res.id;
                        this.doctor.name=res.name;
                        this.doctor.special_on=res.special_on;
                        this.doctor.dgree=res.dgree;
                        this.doctor.mobile=res.mobile;
                        this.doctor.address=res.address;
                    });
                this.edit = true;

            }
        },
        methods:{
            add_doctor(){
                this.$Progress.start();
                axios.post('/gotisoft/doctor/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.doctor
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
                        this.doctor.name="";
                        this.doctor.special_on="";
                        this.doctor.dgree="";
                        this.doctor.mobile="";
                        this.doctor.address="";
                        this.$router.push('/all_doctors')

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_doctor(){
                this.doctor.delete=true;
                this.update_doctor();
            },
            update_doctor(){
                this.$Progress.start();
                axios.put('/gotisoft/doctor/'+this.doctor.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.doctor
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
                        this.doctor.name="";
                        this.doctor.special_on="";
                        this.doctor.dgree="";
                        this.doctor.mobile="";
                        this.doctor.address="";
                        this.$router.push('/all_doctors')

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
