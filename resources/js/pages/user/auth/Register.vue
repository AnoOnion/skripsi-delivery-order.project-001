<template>
    <div class="flex flex-col md:flex-row h-screen">
        <div class="hidden md:block w-full md:w-7/12 bg-slate-900">
            hi
        </div>

        <div class="flex justify-center md:justify-start items-center w-full md:w-5/12 h-full">
            <div class="block space-y-4 pl-16 md:pl-24 pr-16 md:pr-32">
                <div class="block space-y-2">
                    <h2 class="text-lg font-bold">Register</h2>
                    <p class="text-sm font-semibold text-slate-600">Daftarkan diri anda dan mulai gunakan layanan pesan antar dari kami segera.</p>
                </div>

                <div class="flex justify-center items-center space-x-3">
                    <button class="flex justify-center space-x-1 w-full border rounded-full px-3 py-2.5 border-slate-300 focus:outline-none" @click="signUpWithGoogle">
                        <img src="/image/page/google-logo.png" alt="Google logo" class="w-4" />
                        <h6 class="text-xs font-bold truncate">Sign up with Google</h6>
                    </button>

                    <button class="flex justify-center space-x-1 w-full border rounded-full px-3 py-2.5 border-slate-300 focus:outline-none" @click="signUpWithFacebook">
                        <img src="/image/page/facebook-logo.png" alt="facebook logo" class="w-4" />
                        <h6 class="text-xs font-bold truncate">Sign up with Facebook</h6>
                    </button>
                </div>

                <div class="flex justify-center items-center relative text-slate-400">
                    <span class="absolute top-2 w-full h-px bg-slate-300"></span>
                    <div class="w-max px-3.5 text-xs text-center z-10 bg-white">atau Sign up dengan Email</div>
                </div>

                <Form @submit="onRegister" :validation-schema="schema" v-slot="{ errors }" class="block space-y-3.5 pb-3">
                    <div class="flex justify-center items-center space-x-3">
                        <div class="block space-y-1.5">
                            <label for="first-name-form" class="text-sm font-bold">
                                Nama Depan<span class="text-blue-600">*</span>
                            </label>

                            <div :class="errors['nama_depan'] || state.error.message?.nama_depan ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>

                                <Field @keydown="delete state.error.message['nama_depan']" name="nama_depan" type="text" placeholder="Nama Depan" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="first-name-form" />
                            </div>

                            <ErrorMessage name="nama_depan" class="text-xs text-rose-500" />
                            <span v-if="state.error.message?.nama_depan" role="alert" class="text-xs text-rose-500">{{ state.error.message.nama_depan[0] }}</span>
                        </div>

                        <div class="block space-y-1.5">
                            <label for="last-name-form" class="text-sm font-bold">
                                Nama Belakang
                            </label>

                            <div :class="errors['nama_belakang'] || state.error.message?.nama_belakang ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>

                                <Field @keydown="delete state.error.message['nama_belakang']" name="nama_belakang" type="text" placeholder="Nama Belakang" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="last-name-form" />
                            </div>

                            <ErrorMessage name="nama_belakang" class="text-xs text-rose-500" />
                            <span v-if="state.error.message?.nama_belakang" role="alert" class="text-xs text-rose-500">{{ state.error.message.nama_belakang[0] }}</span>
                        </div>
                    </div>

                    <div class="block space-y-1.5">
                        <label for="email-form" class="text-sm font-bold">
                            Email<span class="text-blue-600">*</span>
                        </label>

                        <div :class="errors['email'] || state.error.message?.email ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>

                            <Field @keydown="delete state.error.message['email']" name="email" type="email" placeholder="ex. mail@website.com" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="email-form" />
                        </div>

                        <ErrorMessage name="email" class="text-xs text-rose-500" />
                        <span v-if="state.error.message?.email" role="alert" class="text-xs text-rose-500">{{ state.error.message.email[0] }}</span>
                    </div>

                    <div class="flex justify-center items-center space-x-3">
                        <div class="block space-y-1.5">
                            <label for="password-form" class="text-sm font-bold">
                                Password<span class="text-blue-600">*</span>
                            </label>

                            <div :class="errors['password'] || state.error.message?.password ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>

                                <Field @keydown="delete state.error.message['password']" name="password" :type="state.form.showPassword ? 'text' : 'password'" placeholder="Min. 8 character" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="password-form" />

                                <button @click="state.form.showPassword = !state.form.showPassword" type="button" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path v-if="!state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />

                                        <path v-if="state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path v-if="state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            <ErrorMessage name="password" class="text-xs text-rose-500" />
                            <span v-if="state.error.message?.password" role="alert" class="text-xs text-rose-500">{{ state.error.message.password[0] }}</span>
                        </div>

                        <div class="block space-y-1.5">
                            <label for="confirm-password-form" class="text-sm font-bold">
                                Ulangi Password<span class="text-blue-600">*</span>
                            </label>

                            <div :class="errors['password_confirmation'] || state.error.message?.password_confirmation ? 'border-rose-500' : 'border-slate-300'" class="flex items-center space-x-2 px-5 py-3 rounded-full border">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>

                                <Field @keydown="delete state.error.message['password_confirmation']" name="password_confirmation" :type="state.form.showPassword ? 'text' : 'password'" placeholder="Min. 8 character" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="confirm-password-form" />

                                <button @click="state.form.showPassword = !state.form.showPassword" type="button" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path v-if="!state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />

                                        <path v-if="state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path v-if="state.form.showPassword" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            <ErrorMessage name="password_confirmation" class="text-xs text-rose-500" />
                            <span v-if="state.error.message?.password_confirmation" role="alert" class="text-xs text-rose-500">{{ state.error.message.password_confirmation[0] }}</span>
                        </div>
                    </div>

                    <div class="pb-1.5 text-sm font-semibold">
                        <label class="inline-flex items-center">
                            <Field name="terms_agree" type="checkbox" :value="false" :class="errors['terms_agree'] ? 'ring-rose-500' : 'ring-slate-300'"  class="w-4 h-4 border-0 ring-1 rounded-sm text-blue-600 focus:outline-none" />
                            <div class="ml-2 text-slate-700">
                                Saya setuju dengan <router-link :to="{ name: 'policy.terms' }" class="text-blue-500">Syarat & Ketentuan</router-link>
                            </div>
                        </label>
                    </div>

                    <button class="w-full px-5 py-2 text-sm font-semibold rounded-full text-white bg-blue-600 focus:outline-none disabled:opacity-75">
                        Sign up
                    </button>

                    <div class="text-sm font-semibold">
                        Sudah memiliki akun ? <router-link :to="{ name: 'auth.login', query: $route.query.redirect ? { redirect: $route.query.redirect } : null }" class="text-blue-600">Login</router-link>
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

    import { object, string, ref } from 'yup'

    import { useReCaptcha } from 'vue-recaptcha-v3'

    import axios from 'axios'

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
                    termsAgree: true,
                    showPassword: false,
                },
                error: {
                    status: false,
                    message: null
                }
            })

            const schema = object({
                nama_depan: string().required(),
                nama_belakang: string().nullable(),
                email: string().required().email(),
                password: string().required().min(8),
                password_confirmation: string().required().oneOf([ref('password'), null], 'Sandi harus sesuai'),
                terms_agree: string().required()
            })

            const onRegister = async (values) => {
                await recaptchaLoaded()
                const token = await executeRecaptcha('register')

                axios.post('/api/user/register', values, {
                    headers: { 'g-recaptcha-response': token }
                }).then(({ data }) => {
                    router.push({ name: 'verify.check' })
                }).catch(({ response }) => {
                    state.error = {
                        status: true,
                        message: response.data.errors
                    }
                })
            }

            const signUpWithGoogle = async () => {
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
                                remember: false
                            })

                            router.push({ name: 'pages.dashboard' })
                        })
                    }
                } catch (e) { }
            }

            const signUpWithFacebook = async () => {
                const response = await FacebookLogin.login({
                    permissions: [ 'email', 'user_photos', 'user_gender' ]
                })

                if (response.accessToken) {
                    axios.post('/api/user/auth/social/facebook', {
                        token: response.accessToken.token
                    }).then(({ data }) => {
                        store.dispatch('auth/saveToken', {
                            token: data.results.token,
                            remember: false
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
                onRegister, signUpWithGoogle, signUpWithFacebook
            }
        }
    }
</script>
