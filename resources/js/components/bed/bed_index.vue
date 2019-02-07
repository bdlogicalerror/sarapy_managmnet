

<template>
    <v-container grid-list-md text-sm-center>
        <v-layout row wrap>
            <v-toolbar color="cyan lighten-2" dark>
                <v-icon dark right>chrome_reader_mode</v-icon>
                <v-toolbar-title>Cabins/Wards/Bed</v-toolbar-title>
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
                                <v-flex xs4>
                                    <v-card dark   color="deep-purple accent-1"  >
                                        <v-card-title >
                                            Total Cabins:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.cabins}}
                                        </v-card-text>

                                    </v-card>
                                </v-flex>
                                <v-flex xs4>
                                    <v-card dark   color="light-blue lighten-2"  >
                                        <v-card-title >
                                            Total Wards:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.wards}}
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs4>
                                    <v-card dark  color="indigo accent-1"  >
                                        <v-card-title >
                                            Total Beds:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.beds}}
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs6>
                                    <v-card dark   color="teal lighten-1"  >
                                        <v-card-title >
                                            Free Beds:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.free_beds}}
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs6>
                                    <v-card dark   color="#66BB6A"  >
                                        <v-card-title >
                                            Free Cabins:
                                        </v-card-title>
                                        <v-card-text class="display-1 ">
                                            {{summary.free_cabins}}
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
        name: "bed_index",
        data(){
            return{
                summary:null,
            }
        },
        created(){
            fetch('/gotisoft/resident/summary')
                .then(res=>res.json())
                .then(res=>{
                    this.summary=res;
                })
        },
    }
</script>

<style scoped>

</style>
