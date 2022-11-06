<template>
    <div class="block space-y-4 w-full p-4 text-black dark:text-white">
        <div class="flex md:grid grid-cols-5 gap-4 snap-x scroll-pl-6 overflow-x-auto md:overflow-hidden">
            <div class="space-y-3 px-3 py-4 shrink-0 snap-start rounded-md bg-white dark:bg-slate-800">
                <div class="w-min px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-900">
                    <h6 class="truncate text-2xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Pesanan Perhari</h6>
                </div>

                <div class="flex items-center space-x-3 px-2.5">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>

                    <div class="block space-y-0.5 text-xs">
                        <div>{{ state.report.ordersPerday }} Pesanan</div>
                        <div class="text-2xs text-slate-700 dark:text-slate-300">{{ day(new Date()).format('ddd, DD MMM') }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3 px-3 py-4 shrink-0 snap-start rounded-md bg-white dark:bg-slate-800">
                <div class="w-min px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-900">
                    <h6 class="truncate text-2xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Pesanan Perbulan</h6>
                </div>

                <div class="flex items-center space-x-3 px-2.5">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <div class="block space-y-0.5 text-xs">
                        <div>{{ state.report.ordersPermonth }} Pesanan</div>
                        <div class="text-2xs text-slate-700 dark:text-slate-300">{{ day(new Date()).format('MMM YYYY') }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3 px-3 py-4 shrink-0 snap-start rounded-md bg-white dark:bg-slate-800">
                <div class="w-min px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-900">
                    <h6 class="truncate text-2xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Pendapatan Perhari</h6>
                </div>

                <div class="flex items-center space-x-3 px-2.5">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                        </svg>
                    </div>

                    <div class="block space-y-0.5 text-xs">
                        <div>Rp. {{ rupiah(state.report.incomePerday) }}</div>
                        <div class="text-2xs text-slate-700 dark:text-slate-300">{{ day(new Date()).format('ddd, DD MMM') }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3 px-3 py-4 shrink-0 snap-start rounded-md bg-white dark:bg-slate-800">
                <div class="w-min px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-900">
                    <h6 class="truncate text-2xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Pendapatan Perbulan</h6>
                </div>

                <div class="flex items-center space-x-3 px-2.5">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                        </svg>
                    </div>

                    <div class="block space-y-0.5 text-xs">
                        <div>Rp. {{ rupiah(state.report.incomePermonth) }}</div>
                        <div class="text-2xs text-slate-700 dark:text-slate-300">{{ day(new Date()).format('MMM YYYY') }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-3 px-3 py-4 shrink-0 snap-start rounded-md bg-white dark:bg-slate-800">
                <div class="w-min px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-900">
                    <h6 class="truncate text-2xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Pelanggan Terdaftar</h6>
                </div>

                <div class="flex items-center space-x-3 px-2.5">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <div class="block space-y-0.5 text-xs">
                        <div>{{ rupiah(state.report.registeredPerson) }} Orang</div>
                        <div class="text-2xs text-slate-700 dark:text-slate-300">{{ day(new Date()).format('MMM YYYY') }}</div>
                    </div>
                </div>
            </div>

            <!-- <div class="space-y-3 px-3 py-4 shrink-0 snap-start rounded-md bg-white dark:bg-slate-800">
                <div class="w-min px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-900">
                    <h6 class="truncate text-2xs font-semibold text-slate-700 dark:text-slate-300">Jumlah Pengeluaran Perbulan</h6>
                </div>

                <div class="flex items-center space-x-3 px-2.5">
                    <div class="p-3 rounded-md bg-sky-500 dark:bg-slate-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <div class="block space-y-0.5 text-xs">
                        <div>Rp. {{ rupiah(state.report.expensesPermonth) }}</div>
                        <div class="text-2xs text-slate-700 dark:text-slate-300">{{ day(new Date()).format('MMM YYYY') }}</div>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="block space-y-3">
                <div>
                    <h6 class="text-sm font-semibold">Grafik {{ store.getters['auth/level'] == 'admin' ? 'Total' : null }} Penjualan</h6>
                    <div class="text-xs text-slate-700 dark:text-slate-300">Menampilkan semua jumlah penjualan.</div>
                </div>

                <div class="h-56 md:h-72">
                    <canvas class="w-full aspect-video" id="purchase-chart">Your browser does not support the canvas element.</canvas>
                </div>
            </div>

            <div class="block space-y-3">
                <div>
                    <h6 class="truncate text-sm font-semibold">Grafik Total Pendapatan</h6>
                    <div class="text-xs text-slate-700 dark:text-slate-300">Menampilkan jumlah semua pendapatan.</div>
                </div>

                <div class="h-56 md:h-72">
                    <canvas class="w-full aspect-video" id="income-expense-chart">Your browser does not support the canvas element.</canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import { inject, onMounted, reactive } from '@vue/runtime-core'

    import axios from 'axios'

    import { Chart, registerables } from 'chart.js'

    export default {
        setup() {
            const day    = inject('day')
            const rupiah = inject('rupiah')

            const store  = useStore()

            const state  = reactive({
                report: {
                    ordersPerday: 0,
                    ordersPermonth: 0,
                    incomePerday: 0,
                    incomePermonth: 0,
                    expensesPermonth: 0,
                    registeredPerson: 0
                }
            })

            onMounted(() => {
                let purchaseChart, incomeExpenseChart

                Chart.register(...registerables)

                purchaseChart = new Chart(document.getElementById('purchase-chart'), {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                            label: 'Penjualan',
                            data: [],
                            tension: 0.5,
                            borderWidth: 2,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 1)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                })

                incomeExpenseChart = new Chart(document.getElementById('income-expense-chart'), {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [
                            {
                                label: 'Pendapatan',
                                data: [],
                                tension: 0.5,
                                borderWidth: 2,
                                borderColor: 'rgba(14, 165, 233, 1)',
                                backgroundColor: 'rgba(14, 165, 233, 1)'
                            },
                            // {
                            //     label: 'Pengeluaran',
                            //     data: [],
                            //     tension: 0.5,
                            //     borderWidth: 2,
                            //     borderColor: 'rgba(255, 99, 132, 1)',
                            //     backgroundColor: 'rgba(255, 99, 132, 1)'
                            // }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }
                })

                axios.get('/api/admin/recap/report').then(({ data }) => {
                    state.report = data.results
                })

                axios.get('/api/admin/recap/chart/purchase').then(({ data }) => {
                    Object.entries(data.results).forEach(v => {
                        purchaseChart.data.labels.push(day(v[0]).format('DD MMM'))
                        purchaseChart.data.datasets[0].data.push(v[1])
                    })

                    purchaseChart.update()
                })

                axios.get('/api/admin/recap/chart/finance').then(({ data }) => {
                    Object.entries(data.results.income).forEach(v => {
                        incomeExpenseChart.data.labels.push(day(v[0]).format('DD MMM'))
                        incomeExpenseChart.data.datasets[0].data.push(v[1])
                    })

                    // data.results.spending.forEach((value) => {
                    //     incomeExpenseChart.data.datasets[1].data.push(value.total)
                    // })

                    incomeExpenseChart.update()
                })
            })

            return {
                day, rupiah,
                store, state
            }
        }
    }
</script>
