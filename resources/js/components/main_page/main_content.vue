<template>
    <v-container grid-list-md text-xs-center >
        <v-layout row wrap pa-2>
            <v-flex xs3>
                <v-card dark tile color="primary"  :to="{path:'/patients'}">
                    <v-card-text class="display-1 ">
                        <v-icon x-large dark right>airline_seat_flat</v-icon>
                        Patients
                    </v-card-text>

                </v-card>
            </v-flex>

            <v-flex xs3>
                <v-card color="red" :to="{path:'/lab'}">
                    <v-card-text dark class="display-1">
                        <v-icon x-large dark right>opacity</v-icon>
                        Lab
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs3>
                <v-card color="cyan lighten-2" :to="{path:'/resident'}">
                    <v-card-text dark class="display-1">
                        <v-icon x-large dark right>chrome_reader_mode</v-icon>
                        Cabins/W
                    </v-card-text>
                </v-card>

            </v-flex>

            <v-flex xs3 dark>
                <v-card color="purple" :to="{path:'/doctors'}">
                    <v-card-text class="display-1">
                        <v-icon x-large dark right>contact_mail</v-icon>
                        Doctors
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap pa-2>
            <v-flex xs4>
                <v-card dark tile color="deep-orange " height="75px" >
                    <v-card-text class="display-1">
                        <v-icon x-large dark right>wc</v-icon>
                        HRM
                    </v-card-text>

                </v-card>
            </v-flex>

            <v-flex xs4>
                <v-card color="blue-grey ">
                    <v-card-text dark class="display-1">
                        <v-icon x-large dark right>receipt</v-icon>
                        PAYROLL
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs4>
                <v-card color="blue ">
                    <v-card-text dark class="display-1">
                        <v-icon x-large dark right>store</v-icon>
                        Inventory
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap pa-2>
            <v-flex xs12>
                <v-card dark tile color="grey" height="75px" :to="{path:'/financial'}">
                    <v-card-text class="display-1">
                        <v-icon x-large dark right>library_books</v-icon>
                        FINANCIAL
                    </v-card-text>

                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "main_content"
    }
</script>

<style scoped>

</style>
