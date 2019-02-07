<template>
    <v-container grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-toolbar color="red" dark>
                <v-icon dark right>opacity</v-icon>
                <v-toolbar-title>Add Patients</v-toolbar-title>
                <v-spacer></v-spacer>
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
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-autocomplete
                                            v-model="patient.selected_patient"
                                            :items="patients"
                                            :search-input.sync="search_patients"
                                            color="white"
                                            item-text="name"
                                            :loading="isLoading"
                                            item-value="details"
                                            label="Select Admission ID"
                                            solo-inverted
                                            class="mx-3"
                                            :rules="required_rules"
                                            :messages="['Select Admission ID']"
                                    >

                                    </v-autocomplete>
                                </v-flex>
                                <v-layout row wrap v-if="!patient.selected_patient">
                                    <v-flex  xs3>
                                        <v-text-field
                                                v-model="patient.name"
                                                :rules="required_rules"
                                                :counter="25"
                                                label="Patient Name"
                                                required
                                                solo-inverted
                                                class="mx-3"
                                                :messages="['Patient Name']"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex  xs3>
                                        <v-text-field
                                                v-model="patient.age"
                                                :rules="required_rules"
                                                :counter="10"
                                                label="Age"
                                                required
                                                type="number"
                                                solo-inverted
                                                class="mx-3"
                                                :messages="['Age']"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex  xs3>
                                        <v-text-field
                                                v-model="patient.mobile"
                                                :rules="required_rules"
                                                :counter="11"
                                                label="Mobile"
                                                required
                                                solo-inverted
                                                type="number"
                                                class="mx-3"
                                                :messages="['Mobile']"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex  xs3>
                                        <v-text-field
                                                v-model="patient.address"
                                                :rules="required_rules"
                                                :counter="20"
                                                label="Address"
                                                required
                                                solo-inverted
                                                class="mx-3"
                                                :messages="['Address']"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-autocomplete
                                                v-model="patient.ref_doctor"
                                                :items="doctors"
                                                :loading="isLoading"
                                                :search-input.sync="search_doctor"
                                                color="white"
                                                item-text="name"
                                                item-value="id"
                                                label="Ref. Doctor"
                                                solo-inverted
                                                class="mx-3"
                                                :rules="required_rules"
                                                :messages="['Ref. Doctor']"
                                        >

                                        </v-autocomplete>
                                    </v-flex>
                                </v-layout>

                                <v-flex xs9>
                                    <v-autocomplete
                                            v-model="selected_test"
                                            :items="tests"
                                            :search-input.sync="search"
                                            color="white"
                                            item-text="name"
                                            :loading="isLoading"
                                            item-value="details"
                                            label="Select Test"
                                            solo-inverted
                                            class="mx-3"
                                            :rules="required_rules"
                                            :messages="['Sel. Test']"
                                    >

                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs3>
                                    <v-btn @click="add_test" color="primary">Add</v-btn>
                                </v-flex>

                                <v-flex xs12>
                                    <v-card color="blue-grey darken-2" class="white--text">
                                        <v-card-title >
                                            <v-text-field
                                                    v-model="search"
                                                    append-icon="search"
                                                    label="Search"
                                                    single-line
                                                    hide-details
                                            ></v-text-field>
                                        </v-card-title>
                                        <v-container
                                                fill-height
                                                fluid
                                                pa-2
                                        >
                                            <v-layout fill-height>
                                                <v-flex xs12 align-end flexbox>
                                                    <v-data-table
                                                            :headers="headers"
                                                            :items="patient.tests"
                                                            :search="search"
                                                    >
                                                        <template slot="items" slot-scope="props">
                                                            <td class="text-xs-left">{{ props.item.id }}</td>
                                                            <td class="text-xs-left">{{ props.item.name }}</td>
                                                            <td class="text-xs-left">{{ props.item.price }}</td>
                                                            <td class="text-xs-left">
                                                                <v-btn color="red" @click="remove_test(props.index)">
                                                                    <v-icon>delete</v-icon>
                                                                    Delete
                                                                </v-btn>
                                                            </td>

                                                        </template>
                                                        <v-alert slot="no-results" :value="true" color="error" icon="warning">
                                                            Your search for "{{ search }}" found no results.
                                                        </v-alert>
                                                    </v-data-table>
                                                </v-flex>
                                            </v-layout>
                                        </v-container>
                                    </v-card>
                                </v-flex>



                                <v-flex xs4>
                                    <v-text-field
                                            v-model="patient.fees.grand_total"
                                            :rules="required_rules"
                                            :counter="20"
                                            label="Total"
                                            solo-inverted
                                            class="mx-3"
                                            type="number"
                                            disable
                                            :messages="['Grand Total']"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field
                                            v-model="patient.fees.discount"
                                            :rules="required_rules"
                                            :counter="20"
                                            label="Total"
                                            solo-inverted
                                            @change="change_discount"
                                            class="mx-3"
                                            type="number"
                                            :messages="['Discount']"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field
                                            v-model="patient.fees.cash"
                                            :rules="required_rules"
                                            :counter="20"
                                            label="Cash"
                                            solo-inverted
                                            class="mx-3"
                                            type="number"
                                            :messages="['Cash']"
                                    ></v-text-field>
                                </v-flex>

                            </v-layout>
                        </v-layout>
                    </v-container>
                    <v-card-actions>
                        <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_patient" color="primary">Save</v-btn>
                        <v-btn class="mx-3" solo-inverted v-else-if="this.edit && this.valid" color="success" @click="update_patient">Update</v-btn>
                        <v-btn class="mx-3" solo-inverted v-if="this.edit" @click="delete_patient" color="error">Delete</v-btn>

                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <v-dialog
                v-model="dialog"
                max-width="800"
        >
            <v-card>
                <v-card-title class="headline">Successfully Add Test</v-card-title>

                <v-card-text>
                    All test add complete.Do you want to print receipt?
                    <div id="page"></div>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="dialog = false"
                    >
                        Later
                    </v-btn>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="print_admission"
                    >
                        Print Now
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>


</template>

<script>
    export default {
        name: "add_patients_lab",
        data: () => ({
            selected_test:null,
            search: '',
            search_doctor:"",
            search_patients:"",
            isLoading:false,
            headers: [
                {
                    text: 'Sl',
                    align: 'left',
                    sortable: false,
                    value: 'sl'
                },
                {
                    text: 'Test Name',
                    value: 'name'
                },
                {
                    text: 'Price',
                    value: 'price'
                },
                {
                    text: 'action',
                    value: 'id'
                },
            ],
            desserts: [],
            //---------------------------
            hasSaved: false,
            model: null,
            doctors:[

            ],
            tests:[

            ],
            patients:[

            ],
            //------------
            url:location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: ''),
            dialog:false,
            valid: true,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            patient:{
                id:"",
                selected_patient:false,
                name:"",
                age:'',
                mobile:"",
                address:"",
                ref_doctor:"",

                tests:[],
                fees:{
                    discount:0,
                    grand_total:0,
                    cash:0,
                },
                delete:false,
            },




        }),
        created(){

        },
        methods:{
            add_patient(){

                this.$Progress.start();
                axios.post('/gotisoft/lab/patient/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.patient
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

                        var iframe = "<iframe id='admission_inv' style='background-color:white' width='100%' height='30%' src='"+this.url+"/#/lab_receipt/"+res.data.lab_inv_id+"'></iframe>"

                        var page=document.getElementById('page')
                        page.innerHTML=iframe

                        this.dialog=true;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },

            get_tests(){
                fetch('/gotisoft/lab/test/get_test')
                    .then(res=>res.json())
                    .then(res=>{
                        this.tests=res;
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            },
            print_admission(){
                //window.frames["admission_inv"].print()
                var frm = document.getElementById('admission_inv').contentWindow;
                frm.focus();// focus on contentWindow is needed on some ie versions
                frm.print();
                this.dialog=false;
            },
            add_test(){
                this.patient.tests.push(this.selected_test)

                var ttl=0;
                for(var i=0;i<this.patient.tests.length;i++){
                    ttl+=parseFloat(this.patient.tests[i].price)
                }
                var dis_amount=(this.patient.fees.discount/100);

                this.patient.fees.grand_total=ttl-(ttl*dis_amount).toFixed(0);
            },
            change_discount(){
                var ttl=0;
                for(var i=0;i<this.patient.tests.length;i++){
                    ttl+=parseFloat(this.patient.tests[i].price)
                }
                var dis_amount=(this.patient.fees.discount/100);

                this.patient.fees.grand_total=ttl-(ttl*dis_amount).toFixed(0);
            },
            remove_test(index){
                this.patient.tests.splice(index,1);

                var ttl=0;
                for(var i=0;i<this.patient.tests.length;i++){
                    ttl+=parseFloat(this.patient.tests[i].price)
                }
                var dis_amount=(this.patient.fees.discount/100);

                this.patient.fees.grand_total=ttl-(ttl*dis_amount).toFixed(0);


            },

            customFilter (item, queryText, itemText) {
                /*const textOne = item.name.toLowerCase()
                const textTwo = item.id.toLowerCase()
                const searchText = queryText.toLowerCase()

                return textOne.indexOf(searchText) > -1 ||
                    textTwo.indexOf(searchText) > -1*/
            },
        },

        watch: {
            search (val) {
                fetch('/gotisoft/lab/test/get_test/'+val)
                    .then(res=>res.json())
                    .then(res=>{
                        this.tests=res;
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            },
            search_doctor(val){
                axios.get('/gotisoft/doctor/search/'+val)
                    .then(res => {
                        this.doctors=res.data;
                    })
            },
            search_patients(val){
                axios.get('/gotisoft/admission/search/'+val)
                    .then(res => {
                        this.patients=res.data;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
