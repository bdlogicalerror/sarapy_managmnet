<template>
    <v-container grid-list-md text-sm-center>
        <v-layout row wrap>
            <v-toolbar color="cyan lighten-2" dark>
                <v-icon dark right>contact_mail</v-icon>
                <v-toolbar-title>Doctors</v-toolbar-title>
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
                                <v-flex xs12>
                                    <v-card dark   color="red accent-1"  >
                                        <v-card-title >
                                            Total:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.doctor}}
                                        </v-card-text>

                                    </v-card>
                                </v-flex>
                                <v-flex xs12>
                                    <v-card dark   color="green"  >
                                        <v-card-title >
                                            Top Doctor: <b>{{summary.top_doctor.doctor_name}}</b>
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.top_doctor.patient}} patient
                                        </v-card-text>doctor

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
        name: "doctor_index",
        data(){
            return{
                summary:null,
            }
        },
        created(){
            fetch('/gotisoft/doctor/summary')
                .then(res=>res.json())
                .then(res=>{
                    this.summary=res;
                })
        }
    }
</script>

<style scoped>

</style>
