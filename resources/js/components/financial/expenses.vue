<template>
    <v-layout row wrap>
        <v-toolbar color="indigo lighten-2" dark>
            <v-icon dark right>contact_mail</v-icon>
            <v-toolbar-title>All Expenses</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'add_expenses'}">
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
                                    :items="expenses"
                                    :search="search"
                            >
                                <template slot="items" slot-scope="props">
                                    <td class="text-xs-left">{{ props.item.id }}</td>
                                    <td class="text-xs-left">{{ props.item.name }}</td>
                                    <td class="text-xs-left">{{ props.item.date }}</td>
                                    <td class="text-xs-left">{{ props.item.amount }}</td>

                                    <td>
                                        <v-btn color="info" :to="{name:'edit_expenses',params:{id:props.item.id}}">
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
        name: "expenses",
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
                        text: 'Name',
                        value: 'name'
                    },
                    {
                        text: 'Date',
                        value: 'date'
                    },
                    {
                        text: 'Amount',
                        value: 'amount'
                    },
                    {
                        text: 'Action',
                        value: 'id'
                    },
                ],
                expenses: [],
            }
        },
        created(){
            this.all_expenses();
        },
        methods:{
            all_expenses(){
                fetch('/gotisoft/expense')
                    .then(res=>res.json())
                    .then(res=>{
                        this.expenses=res;
                    })
            }
        }
    }
</script>

<style scoped>

</style>
