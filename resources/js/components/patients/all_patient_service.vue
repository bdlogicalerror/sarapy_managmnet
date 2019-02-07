<template>
    <v-layout row wrap>
        <v-toolbar color="primary" dark>
            <v-icon dark right>airline_seat_flat</v-icon>
            <v-toolbar-title>All Service</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'add_patient_service'}">
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
                                    <td class="text-xs-left">{{ props.item.name }}</td>
                                    <td class="text-xs-left">{{ props.item.details.price }}</td>

                                    <td v-if="props.item.status=='1'" class="text-xs-left">
                                        <v-btn color="success">Available</v-btn>
                                    </td>
                                    <td v-else-if="props.item.status=='2'" class="text-xs-left">
                                        <v-btn color="error">Booked</v-btn>
                                    </td>
                                    <td>
                                        <v-btn color="info" :to="{name:'edit_patient_service',params:{id:props.item.id}}">
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
    </v-layout>
</template>

<script>
    export default {
        name: "all_patient_service",
        data () {
            return {
                search: '',
                headers: [
                    {
                        text: 'ID',
                        align: 'left',
                        sortable: false,
                        value: 'id'
                    },
                    {
                        text: 'Service Name',
                        value: 'ward_name'
                    },
                    {
                        text: 'Service Charge',
                        value: 'price'
                    },
                    {
                        text: 'service Status',
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
            this.get_service();
        },
        methods:{
            get_service(){
                fetch('/gotisoft/patient/service')
                    .then(res=>res.json())
                    .then(res=>{
                        this.desserts=res;
                    })
                    .catch(err=>{
                        console.log(err)
                    })
            }
        }
    }
</script>

<style scoped>

</style>

