import { defineStore } from "pinia";
import {useLocalStorage} from "@vueuse/core";
import axios from "axios"
import {LOGIN_URL, LOGOUT_URL} from "@/constants/Authconstants";
import router from "@/router/router";


export const useAuthStore = defineStore('users', {
    state: () => ({
        user: useLocalStorage('auth/user',{}),
        token: useLocalStorage('auth/tk',null)
    }),
    actions: {
        async login(email: string, password: string, router: any) {
            try {
                const response = await axios.post(LOGIN_URL, { email, password })
                this.setToken(response.data.token);
                this.setUser(response.data.user);
                await router.push('/')
            } catch (error) {
                console.error(error);
                throw error;
            }
        },
        setToken(token: any) {
            useLocalStorage('auth/tk',token)
            this.token = token
        },
        setUser(user: any) {
            useLocalStorage('auth/user',user)
            this.user = user
        },
        logout(){
            this.setUser(null)
            this.setToken(null)
        }
    },
    getters: {
        isAuthenticated(state): Boolean {
            return !!state.token?.length
        }
    }
})
