import {createRouter, createWebHistory} from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {path: '/', redirect: '/dashboard'},
        {
            path: '/dashboard',
            component: () => import('../layouts/default.vue'),
            children: [
                {
                    path: '',
                    component: () => import('../pages/dashboard.vue'),
                },
                {
                    path: 'users',
                    component: () => import('../pages/users.vue'),
                }, {
                    path: 'account-settings',
                    component: () => import('../pages/account-settings.vue'),
                },
                {
                    path: 'typography',
                    component: () => import('../pages/typography.vue'),
                },
                {
                    path: 'icons',
                    component: () => import('../pages/icons.vue'),
                },
                {
                    path: 'cards',
                    component: () => import('../pages/cards.vue'),
                },
                {
                    path: 'tables',
                    component: () => import('../pages/tables.vue'),
                },
                {
                    path: 'form-layouts',
                    component: () => import('../pages/form-layouts.vue'),
                },
            ],
        },
        {
            path: '/',
            component: () => import('../layouts/blank.vue'),
            children: [
                {
                    path: 'login',
                    component: () => import('../pages/login.vue'),
                },
                {
                    path: 'register',
                    component: () => import('../pages/register.vue'),
                },
                {
                    path: '/:pathMatch(.*)*',
                    component: () => import('../pages/[...all].vue'),
                },
            ],
        },
        {
            path: '/api/administrator', children: [
                {
                    path: 'users',
                },
            ]
        },
    ],
})

export default router
