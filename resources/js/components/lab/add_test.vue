<template>
    <v-layout row wrap>
        <v-toolbar color="red" dark>
            <v-icon dark right>opacity</v-icon>
            <v-toolbar-title>Add Test</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="green" :to="{name:'all_test_lab'}">
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
                                        v-model="test.name"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="Test Name"
                                        required
                                        solo-inverted

                                        class="mx-3"
                                ></v-text-field>




                                <v-text-field
                                        v-model="test.price"
                                        :rules="required_rules"
                                        :counter="10"
                                        label="Test Price"
                                        required
                                        solo-inverted
                                        type="number"
                                        class="mx-3"
                                ></v-text-field>


                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_test" color="primary">Add</v-btn>
                    <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_test">Update</v-btn>
                    <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_test" color="error">Delete</v-btn>

                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_test",
        data: () => ({



            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            test:{
                id:"",
                name:"",
                price:'',
                delete:false,
            },




        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/lab/test/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.test.id=res.id;
                        this.test.name=res.name;
                        this.test.price=res.price;
                    });
                this.edit = true;

            }


        },
        methods:{
            add_test(){
                this.$Progress.start();
                axios.post('/gotisoft/lab/test/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.test
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.$router.push('/lab/all_test');
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.test.no=0;
                        this.test.rent=0;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_test(){
                this.test.delete=true;
                this.update_test();
            },
            update_test(){
                this.$Progress.start();
                axios.put('/gotisoft/lab/test/'+this.test.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.test
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
                        this.test.no=0;
                        this.test.rent=0;
                        this.$router.push('/lab/all_test')

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
