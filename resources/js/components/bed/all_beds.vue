<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>All  bed</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'add_beds'}">
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
                                    <td class="text-xs-left">{{ props.item.ward_name }}</td>
                                    <td class="text-xs-left">{{ props.item.bed_no }}</td>
                                    <td class="text-xs-left">{{ props.item.bed_rent }}</td>

                                    <td v-if="props.item.status=='1'" class="text-xs-left">
                                        <v-btn color="success">Available</v-btn>
                                    </td>
                                    <td v-else-if="props.item.status=='2'" class="text-xs-left">
                                        <v-btn color="error">Booked</v-btn>
                                    </td>
                                    <td>
                                        <v-btn color="info" :to="{name:'edit_bed',params:{id:props.item.id}}">
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
        name: "all_beds",
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
                        text: 'Ward Name',
                        value: 'ward_name'
                    },
                    {
                        text: 'Bed No',
                        value: 'bed_no'
                    },
                    {
                        text: 'Bed Rent',
                        value: 'bed_rent'
                    },
                    {
                        text: 'Bed Status',
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
            this.get_bed();
        },
        methods:{
            get_bed(){
                fetch('/gotisoft/resident/bed')
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
