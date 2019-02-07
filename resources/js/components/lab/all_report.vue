<template>
    <v-layout row wrap>
        <v-toolbar color="red" dark>
            <v-icon dark right>opacity</v-icon>
            <v-toolbar-title>All Test Receipt</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="green" :to="{name:'add_patients_lab'}">
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
                                    <td class="text-xs-left">{{ props.item.id }}</td>
                                    <td class="text-xs-left">{{ props.item.inv_id }}</td>
                                    <td class="text-xs-left">{{ props.item.admission_inv }}</td>
                                    <td class="text-xs-left">{{ props.item.grand_total }}</td>
                                    <td class="text-xs-left">
                                        {{ props.item.cash }}
                                    </td>
                                    <td class="text-xs-left">
                                        {{ props.item.grand_total-props.item.cash }}
                                    </td>
                                    <td class="text-xs-left">
                                        <v-btn color="green" @click="view_invoice(props.item.id)"><v-icon>visibility</v-icon>View</v-btn>
                                    </td>
                                    <td>
                                        <v-btn color="info" @click="receive_from_patient(props)">
                                            <v-icon>play_for_work</v-icon>
                                            Receive
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
        <v-dialog
                v-model="dialog"
                max-width="800"
        >
            <v-card>
                <v-card-title class="headline">Print Confirmation</v-card-title>

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
        <v-dialog
                v-model="receive"
                max-width="400"
        >
            <v-card>
                <v-card-title class="headline">Receive From Patient</v-card-title>

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
    </v-layout>
</template>

<script>
    export default {
        name: "all_report",
        data () {
            return {
                search: '',
                url:location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: ''),
                dialog:false,
                receive:false,
                receive_obj:{
                  id:null,
                  admission_id:null,
                  amount:0,
                  cash:0,
                },
                headers: [
                    {
                        text: 'ID',
                        align: 'left',

                        value: 'id'
                    },
                    {
                        text: 'Invoice No',
                        value: 'inv_id'
                    },
                    {
                        text: 'Admission ID',
                        sortable: false,
                        value: 'admission_id'
                    },
                    {
                        text: 'Grand Total',
                        value: 'grand_total'
                    },
                    {
                        text: 'Cash',
                        value: 'cash'
                    },
                    {
                        text: 'Receivable',
                        value: 'cash'
                    },
                    {
                        text: 'View',
                        value: 'id'
                    },
                    {
                        text: 'action',
                        value: 'id'
                    },
                ],
                desserts: [],
            }
        },
        created(){
            this.get_bed();
            if(this.$route.params.id!==undefined) {
                this.search=this.$route.params.id;
            }
        },
        methods:{
            get_bed(){
                fetch('/gotisoft/lab/patient/all')
                    .then(res=>res.json())
                    .then(res=>{
                        this.desserts=res;
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            },
            view_invoice(id){
                var iframe = "<iframe id='admission_inv' style='background-color:white' width='100%' height='30%' src='"+this.url+"/#/lab_receipt/"+id+"'></iframe>"

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
            receive_from_patient(props){
                this.receive=true;
                this.receive_obj.amount=props.item.grand_total-props.item.cash;
                this.receive_obj.id=props.item.id;
                this.receive_obj.admission_id=props.item.admission_inv;

            },
            confirm_receive(){
                this.$Progress.start();
                axios.post('/gotisoft/lab/patient/receive',{
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
                        this.get_bed();
                        this.view_invoice(res.data.inv_id);
                    })
                    .catch(err=>{
                        this.$Progress.fail();
                        this.receive=false;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
