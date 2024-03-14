import {createRouter, createWebHistory} from 'vue-router'
import guest from '../middleware/guest.ts'
import auth from '../middleware/auth.ts'
import middlewarePipeline from '../middleware/middlewarePipeline.ts'
import {useAuthStore} from "../stores/auth.store.ts"


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            name: 'home',
            path: '/',
            component: () => import('../components/private/User/index.vue'),
            meta: {
                middleware: [
                    auth
                ],
                layout: 'BasicLayout',
                title: 'Inicio'
            }
        },
        {
            name: 'login',
            path: '/login',
            component: () => import('../components/public/auth/Login.vue'),
            meta: {
                middleware: [
                    guest
                ],
                layout: 'AppLayout',
                title: 'login'
            }
        },
        {
            name: 'user',
            path: '/user',
            component: () => import('../components/private/User/index.vue'),
            meta: {
                middleware: [
                    auth
                ],
                layout: 'BasicLayout',
                title: 'usuario'

            },
        },
    ]
})

router.beforeEach(async (to, from, next): Promise<void> => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware;
    const context = {
        to,
        from,
        next,
        store: useAuthStore()
    }
    const pageTitle = to.meta.title ? to.meta.title : ('prueba');

    // Actualizar el título de la página
    document.title = pageTitle;

    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })
})

export default router
