<template>
    <v-layout row wrap>
        <v-toolbar color="primary" dark>
            <v-icon dark right>airline_seat_flat</v-icon>
            <v-toolbar-title>Manage Patients</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="green" :to="{name:'add_patients'}">
                <v-icon>add</v-icon>
            </v-btn>
        </v-toolbar>
        <v-flex xs12>
            <v-card color="blue-grey darken-2" class="white--text">
                <v-card-title >
                    <v-spacer></v-spacer>
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
                                    :items="desserts"
                                    :search="search"
                            >
                                <template slot="items" slot-scope="props">
                                    <td class="text-xs-left">{{ props.item.patient_id }}</td>
                                    <td class="text-xs-left">{{ props.item.patient_name }}</td>
                                    <td class="text-xs-left">{{ props.item.days }}</td>
                                    <td class="text-xs-left">
                                        {{ props.item.grand_total }}
                                    </td>
                                    <td class="text-xs-left">
                                        {{ props.item.pathology_receivable }}

                                        <v-btn v-if="props.item.pathology_receivable>0" color="info" :to="{name:'all_report_lab'}">
                                            <v-icon>play_for_work</v-icon>
                                        </v-btn>
                                    </td>
                                    <td class="text-xs-left">
                                        {{ props.item.received }}
                                    </td>

                                    <td class="text-xs-left">
                                        {{ props.item.grand_total-props.item.received }}
                                    </td>
                                    <td>
                                        <div class="text-xs-center">
                                            <v-tooltip top>
                                                <v-icon
                                                        @click="view_invoice(props.item.admission_id)"
                                                        slot="activator"
                                                        color="green"
                                                        dark
                                                        large
                                                >visibility</v-icon>
                                                <span>View Invoice</span>
                                            </v-tooltip>
                                        </div>

                                        <div class="text-xs-center" v-if="props.item.status==1">
                                            <v-tooltip top>
                                                <v-icon
                                                        @click="add_service(props)"
                                                        slot="activator"
                                                        color="deep-orange darken-1"
                                                        dark
                                                        large
                                                >add_box</v-icon>
                                                <span>Add Service</span>
                                            </v-tooltip>
                                            <v-tooltip top>
                                                <v-icon
                                                        @click="receive_from_patient(props)"
                                                        slot="activator"
                                                        color="deep-purple accent-1"
                                                        dark
                                                        large
                                                >play_for_work</v-icon>
                                                <span>Receive</span>
                                            </v-tooltip>
                                            <v-tooltip top>
                                                <v-icon
                                                        @click="shift_patient(props)"
                                                        slot="activator"
                                                        color="light-green lighten-1"
                                                        dark
                                                        large
                                                >swap_vertical_circle</v-icon>
                                                <span>Shift</span>
                                            </v-tooltip>
                                            <v-tooltip top>
                                                <v-icon
                                                        @click="release_patient(props)"
                                                        slot="activator"
                                                        color="red"
                                                        dark
                                                        large
                                                >verified_user</v-icon>
                                                <span>Release</span>
                                            </v-tooltip>
                                        </div>
                                        <div class="text-xs-center" v-else-if="props.item.status==2">
                                            <v-tooltip top>
                                                <v-icon
                                                        slot="activator"
                                                        color="grey"
                                                        dark
                                                        large
                                                >check_circle</v-icon>
                                                <span>Already Released</span>
                                            </v-tooltip>
                                        </div>
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
        <!--Print Confirmation-->
        <v-dialog
                v-model="dialog"
                max-width="800"
        >
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-icon dark right>airline_seat_flat</v-icon>
                    <v-toolbar-title>Print Admission Receipt</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>

                <v-card-text>
                    Do you want to print receipt?
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
        <!--Print Confirmation-->
        <!--Receive Dialog-->
        <v-dialog
                v-model="receive"
                max-width="400"
        >
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-icon dark right>airline_seat_flat</v-icon>
                    <v-toolbar-title>Receive From Patient</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-text-field
                            v-model="receive_obj.amount"
                            :counter="20"
                            label="Total"
                            solo-inverted
                            class="mx-3"
                            type="number"
                            disable
                            :messages="['Receivable Amount']"
                    ></v-text-field>
                    <v-text-field
                            v-model="receive_obj.cash"
                            :counter="20"
                            label="Total"
                            solo-inverted
                            class="mx-3"
                            type="number"
                            :messages="['Cash']"
                    ></v-text-field>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="receive = false"
                    >
                        Later
                    </v-btn>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="confirm_receive"
                    >
                        Receive Now
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!--Receive Dialog-->
        <!--Shift Patient-->
        <v-dialog
                v-model="shift"
                max-width="400"
        >
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-icon dark right>airline_seat_flat</v-icon>
                    <v-toolbar-title>Shift Patient</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>

                <v-card-text>
                    <v-flex  >
                        <span v-if="current_resident">Cabin No: {{current_resident.cabin_no}} </span>
                        <span v-if="current_resident && current_resident.ward_no">Ward No: {{current_resident.ward_no}} ,</span>
                        <span v-if="current_resident && current_resident.bed_no">Bed No: {{current_resident.ward_no}}</span>
                    </v-flex>
                    <v-flex  >

                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex  >
                        <v-select
                                :items="bed_type"
                                v-model="patient.admit_on"
                                solo-inverted
                                class="mx-3"
                                label="Shift To"
                                :messages="['Shift To']"
                        ></v-select>
                    </v-flex>
                    <v-flex  v-if="patient.admit_on=='Ward'">
                        <v-autocomplete
                                v-model="patient.ward_no"
                                :items="wards"
                                :filter="customFilter"
                                color="white"
                                item-text="ward_name"
                                item-value="id"
                                label="Ward Name"
                                solo-inverted
                                class="mx-3"
                                required
                                @change="change_ward"
                                :messages="['Ward']"
                        >
                            Select ward
                        </v-autocomplete>
                    </v-flex>
                    <v-flex  v-if="select_ward && patient.admit_on=='Ward'">
                        <v-autocomplete
                                v-model="patient.bed_no"
                                :items="beds"
                                :filter="customFilter"
                                color="white"
                                item-text="bed_no"
                                item-value="id"
                                label="Bed No"
                                solo-inverted
                                class="mx-3"
                                :messages="['Bed No']"
                        >
                            Select ward
                        </v-autocomplete>
                    </v-flex>
                    <v-flex  v-if="patient.admit_on=='Cabin'">
                        <v-autocomplete
                                v-model="patient.cabin_no"
                                :items="cabins"
                                :filter="customFilter"
                                color="white"
                                item-text="id"
                                item-value="id"
                                label="Cabin No"
                                solo-inverted
                                class="mx-3"
                                :messages="['Cabin']"
                        >
                            Select ward
                        </v-autocomplete>
                    </v-flex>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="shift = false"
                    >
                        Later
                    </v-btn>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="confirm_shift"
                    >
                        Shift Now
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!--Shift Patient-->
        <!--Release Patient-->
        <v-dialog
                v-model="release"
                max-width="400"
        >
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-icon dark right>airline_seat_flat</v-icon>
                    <v-toolbar-title>Release Patient</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>

                <v-card-text>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="release = false"
                    >
                        Later
                    </v-btn>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="confirm_release"
                    >
                        Release Now
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!--Release Patient-->
        <!--Add service Patient-->
        <v-dialog
                v-model="patient_service"
                max-width="400"
        >
            <v-card>
                <v-toolbar color="primary" dark>
                    <v-icon dark right>airline_seat_flat</v-icon>
                    <v-toolbar-title>Add Service Patient</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>

                <v-card-text>
                </v-card-text>
                <v-autocomplete
                        v-model="selected_service.service"
                        :items="services"
                        :search-input.sync="search"
                        color="white"
                        item-text="name"
                        :loading="isLoading"
                        item-value="details"
                        label="Select Service"
                        solo-inverted
                        class="mx-3"
                        :messages="['Sel. Service']"
                >
                </v-autocomplete>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="patient_service = false"
                    >
                        Later
                    </v-btn>

                    <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="confirm_add_service"
                    >
                        Add Service
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!--Add service Patient-->
    </v-layout>
</template>

<script>
    export default {
        name: "manage_patients",
        data () {
            return {
                search: '',
                isLoading:false,
                url:location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: ''),
                patient_service:false,
                dialog:false,
                receive:false,
                shift:false,
                release:false,
                select_ward:false,
                receive_obj:{
                    id:null,
                    patient_id:null,
                    amount:0,
                    cash:0,
                },
                services:[],
                release_patient_obj:{
                    grand_total:0,
                    receive:0,
                    admission_id:null
                },
                headers: [

                    {
                        text: 'Patient ID',
                        value: 'patient_id'
                    },
                    {
                        text: 'Patient Name',
                        value: 'patient_name'
                    },
                    {
                        text: 'Days',
                        value: 'days'
                    },
                    {
                        text: 'Grand Total',
                        value: 'grand_total'
                    },
                    {
                        text: 'Pathology Receivable',
                        value: 'pathology_receivable'
                    },
                    {
                        text: 'Received',
                        value: 'received'
                    },
                    {
                        text: 'Receivable',
                        value: 'receivable'
                    },
                    {
                        text: 'action',
                        value: 'id'
                    },
                ],
                desserts: [],

                beds:[],
                wards:[],
                cabins:[],

                bed_type:[
                    'Cabin','Ward'
                ],
                selected_service:{
                    service:null,
                    admission_id:null,
                    patient_id:null,
                },
                current_resident:null,
                patient:{
                    admission_id:null,
                    patient_id:null,
                    admit_on:null,
                    ward_no:null,
                    bed_no:null,
                }
            }
        },
        created(){
            this.get_patients();
        },
        methods:{
            get_patients(){
                this.$Progress.start();
                fetch('/gotisoft/admission/')
                    .then(res=>res.json())
                    .then(res=>{
                        this.desserts=res;
                        this.$Progress.finish();
                    })
                    .catch(err=>{
                        this.$Progress.finish();
                        console.log(err)
                    })
            },
            get_wards(){
                axios.get('/gotisoft/resident/ward/search/all')
                    .then(res => {
                        this.wards=res.data;
                    })
            },
            get_cabin(){
                axios.get('/gotisoft/resident/cabin/free')
                    .then(res => {
                        this.cabins=res.data;
                    })
            },
            change_ward(){
                this.select_ward=true;
                axios.get('/gotisoft/resident/bed/free?ward='+this.patient.ward_no)
                    .then(res => {
                        this.beds=res.data;
                    })
            },
            view_invoice(id){
                var iframe = "<iframe id='admission_inv' style='background-color:white' width='100%' height='30%' src='"+this.url+"/#/admission_receipt/"+id+"'></iframe>"

                var page=document.getElementById('page')
                page.innerHTML=iframe

                this.dialog=true;
            },
            print_admission(){
                var frm = document.getElementById('admission_inv').contentWindow;
                frm.focus();
                frm.print();
                this.dialog=false;
            },

            shift_patient(props){
              this.shift=true;
              this.get_wards();
              this.get_cabin();
                this.patient.admission_id=props.item.admission_id;
                this.patient.patient_id=props.item.patient;
                this.current_resident=props.item.current[0];
            },

            confirm_release(){
                this.$Progress.start();
                axios.post('/gotisoft/admission/release',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.release_patient_obj
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.release=false;
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.receive=false;
                        this.get_patients();
                        this.view_invoice(res.data.admission_id);
                    })
                    .catch(err=>{
                        this.$Progress.fail();
                        this.release=false;
                    })
            },
            confirm_shift(){
                this.$Progress.start();
                axios.post('/gotisoft/admission/shift',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.patient
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.shift=false;
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.receive=false;
                        this.get_bed();
                        this.view_invoice(res.data.inv_id);
                    })
                    .catch(err=>{
                        this.$Progress.fail();
                        this.shift=false;
                    })
            },

            release_patient(props){

              var receivable=props.item.grand_total-props.item.received;
              if(receivable==0){
                  this.release=true
              }else{
                  this.receive=true;

                  this.receive=true;
                  this.receive_obj.amount=props.item.grand_total-props.item.received;
                  this.receive_obj.id=props.item.admission_id;
                  this.receive_obj.patient_id=props.item.patient;

              }
              this.release_patient_obj.admission_id=props.item.id;
              this.release_patient_obj.grand_total=props.item.grand_total;
              this.release_patient_obj.receive=props.item.receive;
            },
            receive_from_patient(props){
                //console.log(props)
                this.receive=true;
                this.receive_obj.amount=props.item.grand_total-props.item.received;
                this.receive_obj.id=props.item.admission_id;
                this.receive_obj.patient_id=props.item.patient;

            },
            confirm_receive(){
                this.$Progress.start();
                axios.post('/gotisoft/admission/receive',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.receive_obj
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.receive=false;
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.receive=false;
                        this.get_patients();
                        this.view_invoice(res.data.inv_id);
                    })
                    .catch(err=>{
                        this.$Progress.fail();
                        this.receive=false;
                    })
            },

            confirm_add_service(){
                this.$Progress.start();
                axios.post('/gotisoft/admission/add_service',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.selected_service
                })
                    .then(res=>{
                        this.$Progress.finish();
                        this.shift=false;
                        this.$notify({
                            group: 'system_alert',
                            position:"bottom right",
                            type: res.data.msg_type,
                            title: res.data.msg_type=='error'?'Deleted':res.data.msg_type,
                            text: res.data.message_title
                        });
                        this.receive=false;
                        this.view_invoice(res.data.admission_id);
                        this.get_patients();

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                        this.shift=false;
                    })
            },

            add_service(props){
                this.patient_service=true;
                this.get_services();
                this.selected_service.admission_id=props.item.admission_id;
                this.selected_service.patient_id=props.item.patient_id;

            },
            get_services(){
                axios.get('/gotisoft/patient/service')
                    .then(res => {
                        this.services=res.data;
                    })
            },
            customFilter (item, queryText, itemText) {



                /*const textOne = item.name.toLowerCase()
                const textTwo = item.id.toLowerCase()
                const searchText = queryText.toLowerCase()

                return textOne.indexOf(searchText) > -1 ||
                    textTwo.indexOf(searchText) > -1*/
            },
        }
    }
</script>

<style scoped>

</style>
