<template>
    <v-container grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-toolbar color="primary" dark>
                <v-icon dark right>airline_seat_flat</v-icon>
                <v-toolbar-title>Admit Patients</v-toolbar-title>
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
                                <v-flex  xs3>
                                    <v-text-field
                                            v-model="patient.name"
                                            :rules="required_rules"
                                            :counter="10"
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

                                <v-flex  xs3>
                                    <v-select
                                            :items="bed_type"
                                            v-model="patient.admit_on"
                                            solo-inverted
                                            class="mx-3"
                                            label="Admit on"
                                            :messages="['Admit On']"
                                    ></v-select>
                                </v-flex>
                                <v-flex  xs5 v-if="patient.admit_on=='Ward'">
                                    <v-autocomplete
                                            v-model="patient.ward_no"
                                            :items="wards"
                                            color="white"
                                            item-text="ward_name"
                                            item-value="id"
                                            label="Ward Name"
                                            solo-inverted
                                            class="mx-3"
                                            :rules="required_rules"
                                            required
                                            @change="change_ward"
                                            :messages="['Ward']"
                                    >
                                        Select ward
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex  xs4 v-if="select_ward && patient.admit_on=='Ward'">
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
                                            :rules="required_rules"
                                            @change="select_bed"
                                            :messages="['Bed No']"
                                    >
                                        Select ward
                                    </v-autocomplete>
                                </v-flex>
                                <v-flex  xs9 v-if="patient.admit_on=='Cabin'">
                                    <v-autocomplete
                                            v-model="patient.cabin_no"
                                            :items="cabins"
                                            color="white"
                                            item-text="manual_no"
                                            item-value="id"
                                            label="Cabin No"
                                            solo-inverted
                                            class="mx-9"
                                            :rules="required_rules"
                                            :messages="['Cabin']"
                                            @change="select_cabin"
                                    >
                                        Select ward
                                    </v-autocomplete>
                                </v-flex>
                                    <v-autocomplete
                                            v-model="patient.ref_doctor"
                                            :items="doctors"
                                            :filter="customFilter"
                                            color="white"
                                            item-text="name"
                                            item-value="id"
                                            label="Ref. Doctor"
                                            solo-inverted
                                            class="mx-3"
                                            :rules="required_rules"
                                            :messages="['Ref. Doctor']"
                                            requiered
                                    >

                                    </v-autocomplete>
                                <v-flex xs9>
                                    <v-autocomplete
                                            v-model="selected_service"
                                            :items="services"
                                            :search-input.sync="search"
                                            color="white"
                                            item-text="name"
                                            :loading="isLoading"
                                            item-value="details"
                                            label="Select Service"
                                            solo-inverted
                                            class="mx-3"
                                            :rules="required_rules"
                                            :messages="['Sel. Service']"
                                    >

                                    </v-autocomplete>
                                </v-flex>
                                <v-flex xs3>
                                    <v-btn @click="add_service" color="green">Add</v-btn>
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
                                                            :items="patient.services"
                                                            :search="search"
                                                    >
                                                        <template slot="items" slot-scope="props">
                                                            <td class="text-xs-left">{{ props.item.id }}</td>
                                                            <td class="text-xs-left">{{ props.item.name }}</td>
                                                            <td class="text-xs-left">{{ props.item.price }}</td>
                                                            <td class="text-xs-left">
                                                                <v-btn color="red" @click="remove_service(props.index)">
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
                                            :value="parseInt(patient.fees.grand_total)+parseInt(show_total)"
                                            required
                                            solo-inverted
                                            class="mx-3"
                                            type="number"
                                            disabled
                                            :messages="['Grand Total']"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs4>
                                    <v-text-field
                                            v-model="patient.fees.discount"
                                            :rules="required_rules"
                                            :counter="20"
                                            label="Discount"
                                            solo-inverted
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
                        <v-btn class="mx-3" solo-inverted v-if="!this.edit && this.valid"  @click="add_patient" color="primary">Admit</v-btn>
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
                <v-card-title class="headline">Successfully Admit Patient</v-card-title>

                <v-card-text>
                    Patient admission complete.Do you want to print receipt?
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
        name: "add_patients",
        data: () => ({

            //-------------------------
            headers: [
                {
                    text: 'Sl',
                    align: 'left',
                    sortable: false,
                    value: 'sl'
                },
                {
                    text: 'Service Name',
                    value: 'name'
                },
                {
                    text: 'Service Charge',
                    value: 'price'
                },
                {
                    text: 'action',
                    value: 'id'
                },
            ],
            desserts: [],

            selected_service:null,
            //---------------------------
            hasSaved: false,
            model: null,
            isLoading:false,
            search:'',
            wards: [
            ],
            cabins:[

            ],
            beds:[

            ],
            doctors:[

            ],
            services:[

            ],
            //------------
            url:location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: ''),
            dialog:false,
            valid: true,
            required_rules: [
                v => !!v || 'required',
            ],

            show_total:0,

            edit:false,
            patient:{
                id:"",
                name:"",
                age:'',
                mobile:"",
                address:"",
                cabin_no:"",
                ward_no:"",
                bed_no:"",
                admit_on:"",
                ref_doctor:"",

                services:[],
                fees:{
                    discount:0,
                    grand_total:0,
                    cash:0,
                },
                delete:false,
            },

            bed_type:[
                'Cabin','Ward'
            ],
            select_ward:false




        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/lab/patient/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.patient.id=res.id;
                        this.patient.name=res.name;
                        this.patient.price=res.price;
                    });
                this.edit = true;

            }
            this.get_wards();
            this.get_cabin();
            this.get_doctors();
            this.get_services();

        },
        methods:{
            add_service(){
                this.patient.services.push(this.selected_service);

                var ttl=0;
                for(var i=0;i<this.patient.services.length;i++){
                    if(typeof this.patient.services[i].id =='undefined'){

                    }else{
                        ttl+=parseFloat(this.patient.services[i].price)
                    }

                }
                var dis_amount=(this.patient.fees.discount/100);

                this.patient.fees.grand_total=ttl-(ttl*dis_amount).toFixed(0);
            },
            remove_service(index){
                this.patient.services.splice(index,1);

                var ttl=0;
                for(var i=0;i<this.patient.services.length;i++){
                    if(typeof this.patient.services[i].id =='undefined'){
                        this.show_total=this.patient.services[i].price;
                    }else{
                        ttl+=parseFloat(this.patient.services[i].price)
                    }
                }
                var dis_amount=(this.patient.fees.discount/100);

                this.patient.fees.grand_total=ttl-(ttl*dis_amount).toFixed(0);


            },
            add_patient(){
                this.$Progress.start();
                axios.post('/gotisoft/admission/',{
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

                        var iframe = "<iframe id='admission_inv' style='background-color:white' width='100%' height='30%' src='"+this.url+"/#/admission_receipt/"+res.data.admission_id+"'></iframe>"

                        var page=document.getElementById('page')
                        page.innerHTML=iframe

                        this.dialog=true;

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },

            select_cabin(){
                var cabins=this.cabins;
                cabins.map(element=>{
                    if(element.id==this.patient.cabin_no){
                        this.patient.services.push({
                            'name':'Cabin- '+element.manual_no,
                            'price':element.cabin_rent,
                            'type':false
                        })


                        var ttl=0;
                        for(var i=0;i<this.patient.services.length;i++){
                            if(typeof this.patient.services[i].id =='undefined'){
                                ttl+=parseFloat(this.patient.services[i].price)
                            }

                        }

                        this.show_total=ttl.toFixed(0);

                    }
                })
            },
            select_bed(){
                var beds=this.beds;
                beds.map(element=>{
                    if(element.id==this.patient.bed_no){
                        this.patient.services.push({
                            'name':'Bed - '+element.bed_no,
                            'price':element.bed_rent,
                            'type':false
                        })

                        var ttl=0;
                        for(var i=0;i<this.patient.services.length;i++){
                            if(typeof this.patient.services[i].id =='undefined'){
                                ttl+=parseFloat(this.patient.services[i].price)
                            }

                        }

                        this.show_total=ttl.toFixed(0);

                    }
                })
            },

            change_ward(){
              this.select_ward=true;
                axios.get('/gotisoft/resident/bed/free?ward='+this.patient.ward_no)
                    .then(res => {
                        this.beds=res.data;
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
            get_doctors(){
                axios.get('/gotisoft/doctor')
                    .then(res => {
                        this.doctors=res.data;
                    })
            },
            get_services(){
                axios.get('/gotisoft/patient/service')
                    .then(res => {
                        this.services=res.data;
                    })
            },
            print_admission(){
                //window.frames["admission_inv"].print()
                var frm = document.getElementById('admission_inv').contentWindow;
                frm.focus();// focus on contentWindow is needed on some ie versions
                frm.print();
                this.dialog=false;
            },

            customFilter (item, queryText, itemText) {

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
