<template>
    <!--
        courier-process, courier-canceled, courier-delivered,
        payment-success, payment-failed,
        topup-success
    -->

    <TransitionRoot appear :show="modal" as="template">
        <Dialog as="div" @close="$emit('eventModal', false)">
            <div class="flex justify-center items-center fixed inset-0 px-4 z-50">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 backdrop-filter backdrop-blur-[1px]" />
                </TransitionChild>

                <span class="inline-block h-screen align-middle" aria-hidden="true">
                    &#8203;
                </span>

                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <div class="inline-block space-y-3 w-full max-w-md px-5 py-4 align-middle text-xs text-center transform rounded-md shadow-xl text-black dark:text-white bg-white dark:bg-slate-800">
                        <div v-if="type == 'courier-process'">
                            <h6 class="text-sm font-semibold text-emerald-500">Pesanan Berhasil Diambil</h6>
                            <p class="text-slate-700 dark:text-slate-300">Pesanan sudah berhasil diambil kurir, silahkan tunggu hingga pemberitahuan kurir sampai !</p>
                        </div>

                        <div v-if="type == 'courier-canceled'">
                            <h6 class="text-sm font-semibold text-rose-500">Pesanan Dibatalkan Oleh Kurir</h6>
                            <p class="text-slate-700 dark:text-slate-300">Maaf, sepertinya terjadi kendala pada kurir, sehingga pesanan anda di kembalikan</p>
                        </div>

                        <div v-if="type == 'courier-delivered'">
                            <h6 class="text-sm font-semibold text-sky-500">Pesanan Telah Sampai</h6>
                            <p class="text-slate-700 dark:text-slate-300">Kurir sudah sampai ke tempat tujuan, silahkan temui kurir dan membawa barang yang dibutuhkan</p>
                        </div>

                        <div v-if="type == 'payment-success'">
                            <h6 class="text-sm font-semibold text-emerald-500">Pembayaran Telah Berhasil</h6>
                            <p class="text-slate-700 dark:text-slate-300">Pembayaran sudah sukses, terima kasih sudah melakukan transaksi di kami</p>
                        </div>

                        <div v-if="type == 'payment-failed'">
                            <h6 class="text-sm font-semibold text-rose-500">Pembayaran Gagal</h6>
                            <p class="text-slate-700 dark:text-slate-300">Maaf, sepertinya pembayaran gagal dilakukan, silahkan hubungi kurir</p>
                        </div>

                        <div v-if="type == 'topup-success'">
                            <h6 class="text-sm font-semibold text-emerald-500">Topup Telah Berhasil</h6>
                            <p class="text-slate-700 dark:text-slate-300">Selamat, topup berhasil dilakukan, saldo akan terakumulasi otomatis</p>
                        </div>

                        <div v-if="type == 'new-buyer'">
                            <h6 class="text-sm font-semibold text-rose-500">Pembeli Baru</h6>
                            <p class="text-slate-700 dark:text-slate-300">Sepertinya kurir mendapatkan pembeli baru hari ini</p>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
    import { TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle } from '@headlessui/vue'

    export default {
        props: [ 'modal', 'type' ],

        components: {
            TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle
        },

        setup(props) {

        }
    }
</script>
