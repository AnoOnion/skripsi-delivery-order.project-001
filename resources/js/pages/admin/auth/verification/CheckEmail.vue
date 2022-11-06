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
                    <h2 class="text-lg font-bold">Verifikasi Sudah Terkirim</h2>
                    <p class="text-sm font-semibold text-slate-600">Cek email anda dan pastikan link verifikasi untuk melanjutkan ke tahap berikutnya sudah terkirim.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { useRouter } from 'vue-router'
    import { onMounted } from '@vue/runtime-core'

    export default {
        setup() {
            const router = useRouter()

            onMounted(() => {
                setTimeout(() => {
                    router.push({ name: 'admin.auth.login' })
                }, 5000)
            })
        }
    }
</script>
