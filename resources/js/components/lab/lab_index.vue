<template>
    <v-container grid-list-md text-sm-center>
        <v-layout row wrap>
            <v-toolbar color="red" dark>
                <v-icon dark right>opacity</v-icon>
                <v-toolbar-title>Pathology LAB</v-toolbar-title>
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
                                <v-flex xs6>
                                    <v-card dark   color="green"  >
                                        <v-card-title >
                                            Total:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.total}}/-
                                        </v-card-text>

                                    </v-card>
                                </v-flex>
                                <v-flex xs6>
                                    <v-card dark   color="primary"  >
                                        <v-card-title >
                                            Receivable:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.receivable}}/-
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12>
                                    <v-card dark   color="indigo accent-1"  >
                                        <v-card-title >
                                            Total Patient:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.total_patient}}
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
        name: "lab_index",
        data(){
            return{
                summary:null,
            }
        },
        created(){
            fetch('/gotisoft/lab/summary')
                .then(res=>res.json())
                .then(res=>{
                    this.summary=res;
                })
        },
    }
</script>

<style scoped>

</style>
