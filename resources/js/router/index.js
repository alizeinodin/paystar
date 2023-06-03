import {createRouter, createWebHistory} from 'vue-router'
import Home from '../components/Home.vue'
import Register from '../components/Register.vue'
import Login from '../components/Login.vue'
import CardPage from '../components/CardPage.vue'

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
    }
]

const router = createRouter({
    routes,
    history: createWebHistory()
})


export default router;
