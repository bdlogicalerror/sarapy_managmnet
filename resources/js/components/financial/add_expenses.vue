<template>
    <v-layout row wrap>
        <v-toolbar color="indigo lighten-2" dark>
            <v-icon dark right>contact_mail</v-icon>
            <v-toolbar-title>Add Expense</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="red" :to="{name:'expenses'}">
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
                                        v-model="expense.name"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Name"
                                        required
                                        solo-inverted
                                        class="mx-3"
                                ></v-text-field>
                                <v-text-field
                                        v-model="expense.amount"
                                        :rules="required_rules"
                                        :counter="50"
                                        label="Amount"
                                        solo-inverted
                                        type="number"
                                        class="mx-3"
                                ></v-text-field>

                            </v-form>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn solo-inverted class="mx-3" v-if="!this.edit && this.valid"  @click="add_expense" color="primary">Add</v-btn>
                    <v-btn solo-inverted class="mx-3" v-else-if="this.edit && this.valid" color="success" @click="update_expense">Update</v-btn>
                    <v-btn solo-inverted class="mx-3" v-if="this.edit" @click="delete_expense" color="error">Delete</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        name: "add_expenses",
        data: () => ({
            valid: false,
            required_rules: [
                v => !!v || 'required',
            ],
            edit:false,
            expense:{
                id:"",
                name:"",
                amount:"",
                delete:false,
            }

        }),
        created(){
            if(this.$route.params.id!==undefined) {
                fetch('/gotisoft/expense/'+this.$route.params.id)
                    .then(res=>res.json())
                    .then(res=>{
                        this.expense.id=res.id;
                        this.expense.name=res.name;
                        this.expense.amount=res.amount;
                    })
                this.edit = true;

            }
        },
        methods:{
            add_expense(){
                this.$Progress.start();
                axios.post('/gotisoft/expense/add',{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.expense
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
                        this.expense.name="";
                        this.expense.amount="";
                        this.$router.push('/financial/expenses')

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            },
            delete_expense(){
                this.expense.delete=true;
                this.update_expense();
            },
            update_expense(){
                this.$Progress.start();
                axios.put('/gotisoft/expense/'+this.expense.id,{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body:this.expense
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
                        this.expense.name="";
                        this.expense.amount="";
                        this.$router.push('/financial/expenses')

                    })
                    .catch(err=>{
                        this.$Progress.fail();
                    })
            }
        }
    }
</script>

<style scoped>

</style>
