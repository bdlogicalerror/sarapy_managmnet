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
                    prepend-icon="contact_mail"
                    no-action

                    value="true"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Doctors</v-list-tile-title>
                </v-list-tile>


                <v-list-tile :to="{name:'all_doctors'}">
                    <v-list-tile-title>Doctors</v-list-tile-title>
                </v-list-tile>


            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "doctor_menu",
        data: () => ({
            drawer: true,
            watcher: false,
        }),
    }
</script>

<style scoped>

</style>
