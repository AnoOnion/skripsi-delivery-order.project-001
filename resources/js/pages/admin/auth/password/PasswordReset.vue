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
                    <h2 class="text-lg font-bold">Buat Password Baru</h2>
                    <p class="text-sm font-semibold text-slate-600">Kata sandi baru Anda harus berbeda dari kata sandi yang digunakan sebelumnya.</p>
                </div>

                <Form @submit="onReset" :validation-schema="schema" v-slot="{ errors }" class="block space-y-3.5 pb-3">
                    <div class="block space-y-1.5">
                        <label for="password-form" class="text-sm font-bold">
                            Password Baru<span class="text-blue-600">*</span>
                        </label>

                        <div :class="errors['password'] || state.error.message?.password ? 'border-rose-500' : 'border-slate-300'" class="px-5 py-2 rounded-full border">
                            <Field @keydown="delete state.error.message['password']" name="password" type="password" placeholder="Min. 8 character" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="password-form" />
                        </div>

                        <ErrorMessage name="password" class="text-xs text-rose-500" />
                        <span v-if="state.error.message?.password" role="alert" class="text-xs text-rose-500">{{ state.error.message.password[0] }}</span>
                    </div>

                    <div class="block space-y-1.5 pb-1.5">
                        <label for="confirm-password-form" class="text-sm font-bold">
                            Ulangi Password Baru<span class="text-blue-600">*</span>
                        </label>

                        <div :class="errors['confirm_password'] || state.error.message?.confirm_password ? 'border-rose-500' : 'border-slate-300'" class="px-5 py-2 rounded-full border">
                            <Field @keydown="delete state.error.message['confirm_password']" name="confirm_password" type="password" placeholder="Min. 8 character" class="w-full text-xs font-semibold bg-transparent placeholder-slate-500 focus:outline-none" id="confirm-password-form" />
                        </div>

                        <ErrorMessage name="confirm_password" class="text-xs text-rose-500" />
                        <span v-if="state.error.message?.confirm_password" role="alert" class="text-xs text-rose-500">{{ state.error.message.confirm_password[0] }}</span>
                    </div>

                    <button type="submit" class="w-full px-5 py-2.5 text-sm font-semibold rounded-full text-white bg-blue-600 focus:outline-none">
                        Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRoute, useRouter } from 'vue-router'
    import { reactive } from '@vue/runtime-core'

    import { object, string, ref } from 'yup'

    import axios from 'axios'

    export default {
        middleware: 'guest',

        beforeRouteEnter: async (to, from, next) => {
            await axios.post('/api/admin/password/token', {
                email: to.query.email,
                token: to.params.token
            }).then(
                () => next()
            ).catch(
                () => next({ name: 'auth.login' })
            )
        },

        setup() {
            const route  = useRoute()
            const router = useRouter()

            const state  = reactive({
                error: {
                    status: false,
                    message: null
                }
            })

            const schema = object({
                password: string().required().min(8),
                confirm_password: string().required().oneOf([ref('password'), null], 'Passwords must match')
            })

            const onReset = values => {
                const params = {
                    email: route.query.email,
                    token: route.params.token,
                    password: values.password,
                    password_confirmation: values.confirm_password
                }

                axios.post('/api/admin/password/reset', params).then(({ data }) => {
                    router.push({ name: 'admin.auth.login' })
                }).catch(({ response }) => {
                    state.error = {
                        status: true,
                        message: response.data.errors
                    }
                })
            }

            return {
                state, schema,
                onReset
            }
        }
    }
</script>
