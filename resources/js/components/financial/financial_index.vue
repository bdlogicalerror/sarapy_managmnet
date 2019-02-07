<template>
    <v-container grid-list-md text-sm-center>
        <v-layout row wrap>
            <v-toolbar color="indigo lighten-2" dark>
                <v-icon dark right>assignment</v-icon>
                <v-toolbar-title>Financial</v-toolbar-title>
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

                                <v-flex xs3 >
                                    <v-card dark   >
                                        <v-card-title >
                                            <v-toolbar  dark>
                                                <v-icon dark right>contact_mail</v-icon>
                                                <v-toolbar-title>Lab Income</v-toolbar-title>
                                                <v-spacer></v-spacer>
                                            </v-toolbar>
                                        </v-card-title>
                                        <v-card-text class="display-1 text-lg-center ">
                                            {{summary.lab}}
                                        </v-card-text>

                                    </v-card>
                                </v-flex>
                                <v-flex xs3 >
                                    <v-card dark   >
                                        <v-card-title >
                                            <v-toolbar  dark>
                                                <v-icon dark right>contact_mail</v-icon>
                                                <v-toolbar-title>Patients Income</v-toolbar-title>
                                                <v-spacer></v-spacer>
                                            </v-toolbar>
                                        </v-card-title>
                                        <v-card-text class="display-1 text-lg-center ">
                                            {{summary.patient}}
                                        </v-card-text>

                                    </v-card>
                                </v-flex>
                                <v-flex xs3 >
                                    <v-card dark   >
                                        <v-card-title >
                                            <v-toolbar  dark>
                                                <v-icon dark right>contact_mail</v-icon>
                                                <v-toolbar-title>Expenses</v-toolbar-title>
                                                <v-spacer></v-spacer>
                                            </v-toolbar>
                                        </v-card-title>
                                        <v-card-text class="display-1 text-lg-center ">
                                            {{summary.expense}}
                                        </v-card-text>

                                    </v-card>
                                </v-flex>
                                <v-flex xs3 >
                                    <v-card dark   >
                                        <v-card-title >
                                            <v-toolbar  dark>
                                                <v-icon dark right>contact_mail</v-icon>
                                                <v-toolbar-title>Safe</v-toolbar-title>
                                                <v-spacer></v-spacer>
                                            </v-toolbar>
                                        </v-card-title>
                                        <v-card-text class="display-1 text-lg-center ">
                                            {{summary.safe}}
                                        </v-card-text>

                                    </v-card>
                                </v-flex>

                            </v-layout>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "financial_index",
        data(){
            return{
                summary:{
                    safe:0,
                    patient:0,
                    expense:0,
                    lab:0,
                },
            }
        },
        created(){
           fetch('/gotisoft/financial')
               .then(res=>res.json())
               .then(res=>{
                   this.summary.safe=res.safe;
                   this.summary.lab=res.lab;
                   this.summary.patient=res.patient;
                   this.summary.expense=res.expense;
               })
        }
    }
</script>

<style scoped>

</style>
