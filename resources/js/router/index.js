import Vue from 'vue'
import  VueRouter from 'vue-router'



Vue.use(VueRouter);

//main
const main_page = Vue.component('main_page', require('../components/main_page.vue'));
const admin_panel = Vue.component('admin_panel', require('../components/admin_panel.vue'));


//clients
const all_clients=Vue.component('all_clients',require('../components/clients/manage_clients.vue'));
const add_clients=Vue.component('add_clients',require('../components/clients/add_clients.vue'));

//branch
const all_branches=Vue.component('all_branches',require('../components/branch/manage_branch.vue'));
const add_branches=Vue.component('add_branches',require('../components/branch/add_branch.vue'));

//user
const all_user=Vue.component('all_user',require('../components/user/manage_user.vue'));
const add_user=Vue.component('add_user',require('../components/user/add_user.vue'))

const login = Vue.component('login', require('../components/login.vue'));

const routes = [

    {
      name:"login",
      path:'/login',
      component:login,
    },
    {
        name: 'main',
        path: "/",
        component: main_page,
        meta: {
            is_user: true,
            requiresAuth: true
        },
        children: [
            {
                name:"manage_client",
                path: '/manage_client',
                components: {
                    content: all_clients,
                },
                meta: {
                    is_user: true,
                    requiresAuth: true
                }
            },
            {
                name:"add_client",
                path: 'add_client',
                meta: {
                    is_user: true,
                    requiresAuth: true
                },
                components: {
                    content: add_clients,
                }
            },
            {
                name:"edit_client",
                path: 'edit_client/:id',
                meta: {
                    is_user: true,
                    requiresAuth: true
                },
                components: {
                    content: add_clients,
                }
            }

        ]

    },


    //admin_route

    {
        name: 'admin',
        path: "/admin",
        component: admin_panel,

        meta: {
            is_admin: true,
            requiresAuth: true
        },
        children: [
            {
                name:"manage_branch",
                path: 'manage_branch',
                components: {
                    admin: all_branches,
                },
                meta: {
                    is_admin: true,
                    requiresAuth: true
                }
            },
            {
                name:"add_branch",
                path: 'branch_add',
                components: {
                    admin: add_branches,
                },
                meta: {
                    is_admin: true,
                    requiresAuth: true
                }
            },
            {
                name:"edit_branch",
                path: 'branch_edit/:id',
                components: {
                    admin: add_branches,
                },
                meta: {
                    is_admin: true,
                    requiresAuth: true
                }
            },
            {
                name:"manage_user",
                path: 'manage_user',
                components: {
                    admin: all_user,
                },
                meta: {
                    is_admin: true,
                    requiresAuth: true
                }
            },
            {
                name:"add_user",
                path: 'user_add',
                components: {
                    admin: add_user,
                },
                meta: {
                    is_admin: true,
                    requiresAuth: true
                }
            },
            {
                name:"edit_user",
                path: 'edit_user/:id',
                components: {
                    admin: add_user,
                },
                meta: {
                    is_admin: true,
                    requiresAuth: true
                }
            }

        ]

    }


];
const router = new VueRouter({
    //mode: 'history',
    routes // short for `routes: routes`
})
var Auth = {
    loggedIn: false,
    login: function() { this.loggedIn = true },
    logout: function() { this.loggedIn = false }
};
router.beforeEach((to, from, next) => {
    var url=location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '')+'/logout';

    if (to.matched.some(record => record.meta.requiresAuth) ) {
        fetch('/check?name='+to.name)
            .then(res => res.json())
            .then(res => {

                if(res.login){
                    if (to.meta.is_admin) {
                        if(res.role=='admin'){
                            next();
                        }else{
                            next({
                                path: '/',
                            })
                        }

                    }else{
                        if(res.role=='admin'){
                            next({
                                path: '/admin',
                            })
                        }else{
                            next();
                        }

                    }
                }else{
                    next({
                        path: '/login',
                    })
                }
            })
    }else{
        next();
    }
})
Vue.config.devtools = false;
export default router
