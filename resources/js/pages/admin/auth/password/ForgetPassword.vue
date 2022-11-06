<template>
    <div class="flex flex-col md:flex-row h-screen">
        <div class="hidden md:flex justify-center items-center w-full md:w-7/12 bg-slate-900">
            <div>
                <h6 class="text-lg font-semibold text-white">Admin Management Service</h6>
                <p class="text-sm text-slate-300">San Qua Karanganyar - Depot Isi Ulang Air Mineral Galon</p>
                <span class="text-xs text-slate-300/50">Powered By <a href="https://anoonion.xyz/" target="__blank" class="underline hover:text-slate-300">Muh Husni Mubarok</a></span>
            </div>
        </div>

        <div class="flex justify-center md:justify-start items-center w-full md:w-5/12 h-full">
            <div class="block space-y-4 pl-16 md:pl-24 pr-16 md:pr-32">
                <div class="block space-y-2">
                    <h2 class="text-lg font-bold">Lupa Password</h2>
                    <p class="text-sm font-semibold text-slate-600">Masukkan email yang terkait dengan akun Anda dan kami akan mengirimkan email berisi instruksi untuk mengatur ulang kata sandi Anda.</p>
                </div>

                <Form @submit="onForget" :validation-schema="schema" v-slot="{ errors }" class="block space-y-3.5 pb-3">
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

                            <Field @keydown="delete state.error.message['email']" name="email" type="email" placeholder="mail@website.com" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="email-form" />
                        </div>

                        <ErrorMessage name="email" class="text-xs text-rose-500" />
                        <span v-if="state.error.message?.email" role="alert" class="text-xs text-rose-500">{{ state.error.message.email[0] }}</span>
                    </div>

                    <button type="submit" class="w-full px-5 py-2.5 text-sm font-semibold rounded-full text-white bg-blue-600 focus:outline-none">
                        Send
                    </button>

                    <div class="text-sm font-semibold">
                        Sudah mengingat password ? <router-link :to="{ name: 'admin.auth.login' }" class="text-blue-600">Login</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRouter } from 'vue-router'
    import { reactive } from '@vue/runtime-core'

    import { object, string } from 'yup'

    import { useReCaptcha } from 'vue-recaptcha-v3'

    import axios from 'axios'

    export default {
        middleware: 'guest',

        setup() {
            const route = useRouter()

            const { executeRecaptcha, recaptchaLoaded } = useReCaptcha()

            const state  = reactive({
                error: {
                    status: false,
                    message: null
                }
            })

            const schema = object({
                email: string().required().email()
            })

            const onForget = async (values) => {
                await recaptchaLoaded()
                const token = await executeRecaptcha('forget')

                axios.post('/api/admin/password/email', values, {
                    headers: { 'g-recaptcha-response': token }
                }).then(({ data }) => {
                    console.log(data)
                    route.push({ name: 'admin.verify.check' })
                }).catch(({ response }) => {
                    state.error = {
                        status: true,
                        message: response.data.errors
                    }
                })
            }

            return {
                state, schema,
                onForget
            }
        }
    }
</script>
