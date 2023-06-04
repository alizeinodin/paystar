import {createRouter, createWebHistory} from 'vue-router'
import Home from '../components/Home.vue'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'
import CardPage from '../components/CardPage.vue'
import PayPage from '../components/PayPage.vue'

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/:id/card',
        component: CardPage
    },
    {
        path: '/pay/:t/:price?/:ref_num?/:card_number?',
        component: PayPage
    }
]

const router = createRouter({
    base: '/',
    routes,
    history: createWebHistory()
})


export default router;
