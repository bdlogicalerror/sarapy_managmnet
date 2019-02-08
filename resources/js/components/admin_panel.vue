<template>
    <v-app id="inspire" dark>
        <notifications group="system_alert" />
        <v-navigation-drawer
            :disable-resize-watcher="watcher"
            clipped
            fixed
            value="true"
            v-model="drawer"
            app
        >

            <v-list>
                <!--Branch-->
                <v-list-group
                    prepend-icon="airline_seat_flat"
                    no-action

                    value="true"
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Branches</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile :to="{name:'manage_branch'}">
                        <v-list-tile-title>All Branches</v-list-tile-title>
                    </v-list-tile>

                </v-list-group>
                <!--User-->
                <v-list-group
                    prepend-icon="airline_seat_flat"
                    no-action

                    value="true"
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Users</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile :to="{name:'manage_user'}">
                        <v-list-tile-title>All Users</v-list-tile-title>
                    </v-list-tile>

                </v-list-group>
                <!--Currency-->
                <v-list-group
                    prepend-icon="airline_seat_flat"
                    no-action

                    value="true"
                >
                    <v-list-tile slot="activator">
                        <v-list-tile-title>Currency</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile :to="{name:'manage_currency'}">
                        <v-list-tile-title>All Currency</v-list-tile-title>
                    </v-list-tile>

                </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar app fixed clipped-left>

            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-btn  dark :to="{name:'admin'}">
                <v-icon dark right>home</v-icon>
                Home
            </v-btn>
            <v-toolbar-title>Sarapy Management -Admin panel</v-toolbar-title>


            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">

            </v-toolbar-items>

            <v-menu bottom left>
                <v-btn
                    slot="activator"
                    dark
                    icon
                >
                    <v-avatar color="teal">
                        <span class="white--text headline">J</span>
                    </v-avatar>

                </v-btn>

                <v-list>
                    <v-list-tile
                        :to="{name:'profile'}"
                    >
                        <v-list-tile-title>Profile</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile
                        @click="trigger_logout"
                    >
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>

        </v-toolbar>
        <v-content>
            <v-container fluid >
                <router-view name="admin">
                </router-view>
            </v-container>
        </v-content>
        <v-footer app fixed>
            <span>&copy; 2018 GotiSoft</span>
        </v-footer>
    </v-app>
</template>

<script>

    export default {
        name: "admin_panel",
        mounted() {

        },
        data: () => ({
            logout:location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/logout',
            drawer: true,
            watcher:false,
        }),
        methods:{
            trigger_logout(){
                window.location.href=this.logout;
            }
        },
        created () {
            this.$Progress.start()
            this.$router.beforeEach((to, from, next) => {
                //  does the page we want to go to have a meta.progress object
                if (to.meta.progress !== undefined) {
                    let meta = to.meta.progress
                    // parse meta tags
                    this.$Progress.parseMeta(meta)
                }
                //  start the progress bar
                this.$Progress.start()
                //  continue to next page
                next()
            })
            //  hook the progress bar to finish after we've finished moving router-view
            this.$router.afterEach((to, from) => {
                //  finish the progress bar
                this.$Progress.finish()
            })
        },

        props: {
            source: String
        }
    }
</script>
