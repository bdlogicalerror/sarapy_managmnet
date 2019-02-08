<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>All  Clients</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'add_client'}">
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
                                    <td class="text-xs-left">{{ props.item.acc_number }}</td>
                                    <td class="text-xs-left">{{ props.item.name }}</td>
                                    <td class="text-xs-left">{{ props.item.client_type }}</td>

                                    <td v-if="props.item.status=='1'" class="text-xs-left">
                                        <v-btn color="success">Available</v-btn>
                                    </td>
                                    <td v-else-if="props.item.status=='2'" class="text-xs-left">
                                        <v-btn color="error">Booked</v-btn>
                                    </td>
                                    <td>
                                        <v-btn @click="deposit_open(props.item.id)" color="primary" dark>Deposit</v-btn>
                                        <v-btn color="info" :to="{name:'edit_client',params:{id:props.item.id}}">
                                            <v-icon>edit</v-icon>
                                            Edit
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

        <v-dialog v-model="deposit_dialog" persistent max-width="600px">

            <v-card>
                <v-card-title>Deposit Money</v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-autocomplete
                                    v-model="deposit.currency"
                                    :items="currencys"
                                    :filter="customFilter"
                                    color="white"
                                    :messages="['Currency']"
                                    item-text="name"
                                    item-value="id"
                                    label="Currency Name"
                                    solo-inverted
                                    class="mx-3"
                                    required
                    ></v-autocomplete>
                        <v-text-field
                            v-model="deposit.amount"
                            :counter="15"
                            :messages="['Amount']"
                            label="Amount"
                            required
                            solo-inverted
                            class="mx-3"
                        ></v-text-field>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="error" @click="deposit_dialog = false">Close</v-btn>
                    <v-btn color="success"  @click="deposit_dialog = false">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--Inner progress bar-->
        <v-dialog
            v-model="progress_bar"
            hide-overlay
            persistent
            width="300"
        >
            <v-card
                color="primary"
                dark
            >
                <v-card-text>
                    Please stand by
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
        <!--End Inner progress bar-->
    </v-layout>
</template>

<script>
    export default {
        name: "all_Clientss",
        data () {
            return {
                progress_bar: false,
                deposit_dialog: false,

                deposit:{
                    currency:"",
                  amount:0,
                },
                currencys:[],
                search: '',
                headers: [
                    {
                        text: 'ID',
                        align: 'left',
                        sortable: false,
                        value: 'id'
                    },
                    {
                        text: 'Account Number',
                        value: 'acc_number'
                    },
                    {
                        text: 'Clients Name',
                        value: 'name'
                    },
                    {
                        text: 'Clients Type',
                        value: 'client_type'
                    },
                    {
                        text: 'Status',
                        value: 'status'
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
            this.get_Clients();
            this.all_currency();
        },
        methods:{
            all_currency(){
              fetch('/system/currency')
                  .then(res=>res.json())
                  .then(res=>{
                     this.currencys=res;
                  });
            },
            get_Clients(){
                fetch('/system/client')
                    .then(res=>res.json())
                    .then(res=>{
                        this.desserts=res;
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            },
            deposit_open(client_id){
                this.deposit_dialog=true;
                console.log(client_id);
            },
            customFilter (item, queryText, itemText) {
                //console.log(queryText)



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
