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
                    prepend-icon="chrome_reader_mode"
                    no-action

                    value="true"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Bed/Cabins/Wards</v-list-tile-title>
                </v-list-tile>


                <v-list-tile :to="{name:'all_wards'}">
                    <v-list-tile-title>Wards</v-list-tile-title>
                </v-list-tile>

                <v-list-tile :to="{name:'all_beds'}">
                    <v-list-tile-title>Beds</v-list-tile-title>
                </v-list-tile>

                <v-list-tile :to="{name:'all_cabins'}">
                    <v-list-tile-title>Cabins</v-list-tile-title>
                </v-list-tile>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "bed_menu",
        data: () => ({
            drawer: true,
            watcher: false,
        }),
    }
</script>

<style scoped>

</style>
