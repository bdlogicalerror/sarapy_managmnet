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
                    prepend-icon="assignment"
                    no-action

                    value="true"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title>Fiancial</v-list-tile-title>
                </v-list-tile>


                <v-list-tile :to="{name:'income_statment'}">
                    <v-list-tile-title>Income Statement</v-list-tile-title>
                </v-list-tile>

                <v-list-tile :to="{name:'expenses'}">
                    <v-list-tile-title>Expense</v-list-tile-title>
                </v-list-tile>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        name: "financial_menu",
        data: () => ({
            drawer: true,
            watcher:false,
        }),
    }
</script>

<style scoped>

</style>
