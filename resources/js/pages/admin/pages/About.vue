<template>
    <div class="block space-y-3 md:space-y-4 p-4 z-10">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Tentang</div>
            </nav>
        </div>

        <div class="block space-y-3 p-4 rounded-lg text-black dark:text-white bg-white dark:bg-slate-800">
            <div>
                <h6 class="text-sm font-semibold">Tentang Aplikasi</h6>
                <p class="text-2xs text-slate-700 dark:text-slate-300">Informasi pembuat aplikasi.</p>
            </div>

            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 space-y-1">
                    <h6 class="text-xs text-slate-700 dark:text-slate-300">Tentang</h6>
                    <p class="text-xs font-semibold">Aplikasi dibuat untuk memudahkan masyarakat dalam pembelian air mineral dan mengetahui lokasi dari kurir pada saat mengantarkan pesanan ke lokasi pemesan, sehingga pemesan tahu kapan kurir itu sampai ke lokasi pemesanan secara realtime dengan melihat estimasi dan peta lokasi kurir.</p>
                </div>

                <div class="col-span-5 space-y-1">
                    <h6 class="text-xs text-slate-700 dark:text-slate-300">Developer</h6>
                    <p class="text-xs font-semibold">Muh Husni Mubarok</p>
                </div>

                <div class="col-span-4 space-y-1">
                    <h6 class="text-xs text-slate-700 dark:text-slate-300">Teknologi</h6>
                    <p class="text-xs font-semibold">Laravel + Vue JS</p>
                </div>

                <div class="col-span-3 space-y-1">
                    <h6 class="text-xs text-slate-700 dark:text-slate-300">Version</h6>
                    <p class="text-xs font-semibold">v 1.0.0 beta</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        setup() {
            
        }
    }
</script>
