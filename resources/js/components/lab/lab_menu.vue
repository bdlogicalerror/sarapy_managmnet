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
                    prepend-icon="opacity"
                    no-action

                    value="true"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>LAB</v-list-tile-title>
                </v-list-tile>


                <v-list-tile :to="{name:'add_patients_lab'}">
                    <v-list-tile-title>Add Patients</v-list-tile-title>
                </v-list-tile>

                <v-list-tile :to="{name:'all_test_lab'}">
                    <v-list-tile-title>All Tests</v-list-tile-title>
                </v-list-tile>

                <v-list-tile :to="{name:'all_report_lab'}">
                    <v-list-tile-title>All Report Receipt</v-list-tile-title>
                </v-list-tile>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "lab_menu",
        data: () => ({
            drawer: true,
            watcher: false,
        }),
    }
</script>

<style scoped>

</style>
