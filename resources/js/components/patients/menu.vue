<template>
    <v-navigation-drawer
            :disable-resize-watcher="watcher"
            clipped
            fixed
            value="true"
            v-model="drawer"
            app
    >
        <!--patients-->
        <v-list>
            <v-list-group
                    prepend-icon="airline_seat_flat"
                    no-action

                    value="true"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Patients</v-list-tile-title>
                </v-list-tile>


                <v-list-tile :to="{name:'add_patients'}">
                    <v-list-tile-title>Admit Patients</v-list-tile-title>
                </v-list-tile>

                <v-list-tile :to="{name:'manage_patients'}">
                    <v-list-tile-title>Manage Admit Patients</v-list-tile-title>
                </v-list-tile>
                <v-list-tile :to="{name:'all_patient_service'}">
                    <v-list-tile-title>Patient Services</v-list-tile-title>
                </v-list-tile>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "patients_menu",
        data: () => ({
            drawer: true,
            watcher:false,
        }),
    }
</script>

<style scoped>

</style>
