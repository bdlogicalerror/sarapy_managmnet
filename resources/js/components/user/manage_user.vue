<template>
    <v-layout row wrap>
        <v-toolbar color="cyan lighten-2" dark>
            <v-icon dark right>chrome_reader_mode</v-icon>
            <v-toolbar-title>All User</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'add_user'}">
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
                                :items="table_data"
                                :search="search"
                            >
                                <template slot="items" slot-scope="props">
                                    <td class="text-xs-left">{{ props.item.id }}</td>
                                    <td class="text-xs-left">{{ props.item.first_name }} {{ props.item.last_name }}</td>
                                    <td class="text-xs-left">{{ props.item.username }}</td>
                                    <td class="text-xs-left">{{ props.item.password }}</td>
                                    <td class="text-xs-left">{{ props.item.user_type }}</td>
                                    <td class="text-xs-left">{{ props.item.branch }}</td>

                                    <td v-if="props.item.status=='1'" class="text-xs-left">
                                        <v-btn color="success">Active</v-btn>
                                    </td>
                                    <td v-else-if="props.item.status=='2'" class="text-xs-left">
                                        <v-btn color="error">Blocked</v-btn>
                                    </td>
                                    <td>
                                        <v-btn color="info" :to="{name:'edit_user',params:{id:props.item.id}}">
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
        name: "all_users",
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
                        text: 'Full Name',
                        value: 'first_name'+'last_name'
                    },
                    {
                        text: 'Username',
                        value: 'username'
                    },
                    {
                        text: 'Password',
                        value: 'password'
                    },
                    {
                        text: 'User Type',
                        value: 'user_type'
                    },
                    {
                        text: 'Branch Name',
                        value: 'branch'
                    },
                    {
                        text: 'user Status',
                        value: 'status'
                    },
                    {
                        text: 'action',
                        value: 'id'
                    },
                ],
                table_data: [],
            }
        },
        created(){
            this.get_user();
        },
        mounted(){
        },
        methods:{
            get_user(){
                fetch('/system/user')
                    .then(res=>res.json())
                    .then(res=>{
                        this.table_data=res;
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
