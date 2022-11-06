<template>
    <div class="flex flex-col md:flex-row h-screen">
        <div class="hidden md:block w-full md:w-7/12 bg-slate-900">
            hi
        </div>

        <div class="flex justify-center md:justify-start items-center w-full md:w-5/12 h-full">
            <div class="block space-y-4 pl-16 md:pl-24 pr-16 md:pr-32">
                <div class="block space-y-2">
                    <h2 class="text-lg font-bold">Login</h2>
                    <p class="text-sm font-semibold text-slate-600">Daftarkan diri anda dan mulai gunakan layanan pesan antar dari kami segera.</p>
                </div>

                <div class="flex justify-center items-center space-x-3">
                    <button class="flex justify-center space-x-1 w-full border rounded-full px-3 py-2.5 border-slate-300 focus:outline-none" @click="signInWithGoogle">
                        <img src="/image/page/google-logo.png" alt="Google logo" class="w-4" />
                        <h6 class="text-xs font-bold truncate">Sign in with Google</h6>
                    </button>

                    <button class="flex justify-center space-x-1 w-full border rounded-full px-3 py-2.5 border-slate-300 focus:outline-none" @click="signInWithFacebook">
                        <img src="/image/page/facebook-logo.png" alt="facebook logo" class="w-4" />
                        <h6 class="text-xs font-bold truncate">Sign in with Facebook</h6>
                    </button>
                </div>

                <div class="flex justify-center items-center relative text-slate-400">
                    <span class="absolute top-2 w-full h-px bg-slate-300"></span>
                    <div class="w-max px-3.5 text-xs text-center z-10 bg-white">atau Sign in dengan Email</div>
                </div>

                <div v-if="state.error.status" class="flex items-center space-x-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <h6 class="capitalize text-sm font-bold">{{ state.error.message.errors.message !== undefined ? state.error.message.errors?.message[0] : state.error.message.message }}</h6>
                </div>

                <Form @submit="onLogin" :validation-schema="schema" v-slot="{ errors }" class="block space-y-3.5 pb-3">
                    <div class="block space-y-1.5">
                        <label for="email-form" class="text-sm font-bold">
                            Email<span class="text-blue-600">*</span>
                        </label>

                        <div :class="errors['email'] || state.error.message.errors?.email ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>

                            <Field @keydown="delete state.error.message?.errors['email']" name="email" type="email" placeholder="mail@website.com" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="email-form" />
                        </div>

                        <ErrorMessage name="email" class="text-xs text-rose-500" />
                        <span v-if="state.error.message.errors?.email" v-html="state.error.message.errors.email[0]" role="alert" class="text-xs text-rose-500"></span>
                    </div>

                    <div class="block space-y-1.5">
                        <label for="password-form" class="text-sm font-bold">
                            Password<span class="text-blue-600">*</span>
                        </label>

                        <div :class="errors['password'] || state.error.message.errors?.password ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <Field @keydown="delete state.error.message?.errors['password']" name="password" :type="state.form.showPassword ? 'text' : 'password'" placeholder="Min. 8 character" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="password-form" />

                            <button @click="state.form.showPassword = !state.form.showPassword" type="button" class="focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path v-if="!state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />

                                    <path v-if="state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path v-if="state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        <ErrorMessage name="password" class="text-xs text-rose-500" />
                        <span v-if="state.error.message.errors?.password" role="alert" class="text-xs text-rose-500">{{ state.error.message.errors.password[0] }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-1.5">
                        <label class="inline-flex items-center">
                            <input v-model="state.form.remember" type="checkbox" class="form-checkbox w-4 h-4 border rounded-sm border-slate-300 text-blue-600 focus:outline-none" checked>
                            <span class="ml-2 text-sm font-semibold text-slate-700">
                                Ingatkan saya
                            </span>
                        </label>

                        <router-link :to="{ name: 'password.reset' }" class="text-sm font-semibold text-blue-600">
                            Lupa password ?
                        </router-link>
                    </div>

                    <button type="submit" class="w-full px-5 py-2.5 text-sm font-semibold rounded-full text-white bg-blue-600 focus:outline-none">
                        Sign in
                    </button>

                    <div class="text-sm font-semibold">
                        Belum terdaftar ? <router-link :to="{ name: 'auth.register', query: $route.query.redirect ? { redirect: $route.query.redirect } : null }" class="text-blue-600">Buat Akun Sekarang</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import { useRoute, useRouter } from 'vue-router'
    import { onMounted, reactive } from '@vue/runtime-core'

    import { object, string } from 'yup'

    import axios from 'axios'

    import { useReCaptcha } from 'vue-recaptcha-v3'

    import { GoogleAuth } from '@codetrix-studio/capacitor-google-auth'
    import { FacebookLogin } from '@capacitor-community/facebook-login'

    export default {
        middleware: 'guest:user',

        setup() {
            const store  = useStore()
            const route  = useRoute()

            const router = useRouter()

            const { executeRecaptcha, recaptchaLoaded } = useReCaptcha()

            const state  = reactive({
                form: {
                    remember: true,
                    showPassword: false,
                },
                error: {
                    status: false,
                    message: {
                        errors: null,
                        message: null
                    }
                }
            })

            const schema = object({
                email: string().required().email(),
                password: string().required().min(8)
            })

            const onLogin = async (values) => {
                await recaptchaLoaded()
                const token = await executeRecaptcha('login')

                axios.post('/api/user/login', values, {
                    headers: { 'g-recaptcha-response': token }
                }).then(({ data }) => {
                    store.dispatch('auth/saveToken', {
                        token: data.token,
                        remember: state.form.remember
                    })

                    router.push({
                        path: route.redirectedFrom ? route.redirectedFrom.path : '/'
                    })
                }).catch(({ response }) => {
                    state.error = {
                        status: true,
                        message: response.data
                    }
                })
            }

            const signInWithGoogle = async () => {
                try {
                    let response = await GoogleAuth.signIn()

                    if (response.id) {
                        if (typeof response.authentication.accessToken == 'undefined') {
                            response = await GoogleAuth.refresh()
                        }

                        axios.post('/api/user/auth/social/google', {
                            token: response.authentication.accessToken
                        }).then(({ data }) => {
                            store.dispatch('auth/saveToken', {
                                token: data.results.token,
                                remember: true
                            })

                            router.push({
                                path: route.redirectedFrom ? route.redirectedFrom.path : '/'
                            })
                        })
                    }
                } catch (e) { }
            }

            const signInWithFacebook = async () => {
                const response = await FacebookLogin.login({
                    permissions: [ 'email', 'user_photos', 'user_gender' ]
                })

                if (response.accessToken) {
                    axios.post('/api/user/auth/social/facebook', {
                        token: response.accessToken.token
                    }).then(({ data }) => {
                        store.dispatch('auth/saveToken', {
                            token: data.results.token,
                            remember: true
                        })

                        router.push({
                            path: route.redirectedFrom ? route.redirectedFrom.path : '/'
                        })
                    })
                }
            }

            onMounted(async () => {
                GoogleAuth.initialize()
                await FacebookLogin.initialize({ appId: '1871992282993613' })
            })

            return {
                state, schema,
                onLogin, signInWithGoogle, signInWithFacebook
            }
        }
    }
</script>
