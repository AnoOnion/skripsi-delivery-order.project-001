<template>
    <div class="block space-y-6 p-4">
        <div class="block space-y-4">
            <nav class="flex items-center text-sm font-medium space-x-2 whitespace-nowrap text-slate-700 dark:text-slate-300">
                <div>Dashboard</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Laporan</div>

                <svg aria-hidden="true" width="24" height="24" fill="none" class="flex-none text-slate-300">
                    <path d="M10.75 8.75l3.5 3.25-3.5 3.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>

                <div>Produk</div>
            </nav>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end space-x-0 md:space-x-4 space-y-3 md:space-y-0 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Laporan Produk.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar semua laporan produk termasuk stok masuk.</p>
                </div>

                <div class="grid md:flex grid-cols-12 items-center space-x-3 w-full md:w-auto">
                    <div class="col-span-4 flex flex-col space-y-2">
                        <label for="early-period-filter" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Periode Awal</label>

                        <div class="flex px-3 py-2.5 border rounded-md border-transparent bg-slate-200/50 dark:bg-slate-800/50">
                            <input v-model="state.filters.rules.earlyPeriod" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="early-period-filter" />
                        </div>
                    </div>

                    <div class="col-span-4 flex flex-col space-y-2">
                        <label for="end-period-filter" class="text-xs font-semibold text-slate-700 dark:text-slate-300">Periode Akhir</label>

                        <div class="flex px-3 py-2.5 border rounded-md border-transparent bg-slate-200/50 dark:bg-slate-800/50">
                            <input v-model="state.filters.rules.endPeriod" type="date" class="w-full text-xs font-semibold bg-transparent focus:outline-none read-only:text-slate-700 dark:read-only:text-slate-300" id="end-period-filter" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-auto">
            <table class="min-w-full divide-y divide-slate-50 dark:divide-slate-800">
                <thead class="bg-white dark:bg-slate-800/50">
                    <tr>
                        <th rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NO</th>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ID UNIQEU</td>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NAMA PRODUK</td>
                        <td colspan="2" class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">STOK</td>
                        <td colspan="2" class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">HARGA</td>
                        <td rowspan="2" class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">DIBUAT</td>
                        <td rowspan="2" class="hidden px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">DIEDIT</td>
                    </tr>
                    <tr>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">AWAL</td>
                        <td class="hidden px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">SEMENTARA</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">AKHIR</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">BELI</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">JUAL</td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-if="state.loading">
                        <tr v-for="loading in 3" :key="loading" class="text-sm font-flow">
                            <td class="px-5 py-4 text-slate-500">x.</td>
                            <td class="px-5 py-4 whitespace-nowrap">PD-123456</td>
                            <td class="px-5 py-4 whitespace-nowrap">Lorem ipsum dolor sit.</td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">00</td>
                            <td class="hidden px-5 py-4 text-center whitespace-nowrap">00</td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">00</td>
                            <td class="px-5 py-4 whitespace-nowrap">Rp. 00.000</td>
                            <td class="px-5 py-4 whitespace-nowrap">Rp. 00.000</td>
                            <td class="px-5 py-4 whitespace-nowrap">00 00 00 00:00</td>
                            <td class="hidden px-5 py-4 whitespace-nowrap">00 00 00 00:00</td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(product, index) in state.pagination.listProducts" :key="product" class="text-sm">
                            <th class="px-5 py-4 whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td class="px-5 py-4 whitespace-nowrap">{{ product.kode_item }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div>{{ product.nama_item }}</div>
                                <div class="text-xs text-slate-500">Ditambah Oleh {{ product.nama_depan }}</div>
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">{{ product.stok_awal }}</td>
                            <td class="hidden px-5 py-4 text-center whitespace-nowrap">{{ product.stok_sementara }}</td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">{{ product.stok_akhir }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">Rp. {{ product.harga_beli.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">Rp. {{ product.harga_jual.toString().replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1\.") }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">{{ day(product.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                            <td class="hidden px-5 py-4 whitespace-nowrap">{{ day(product.updated_at).format('DD MMM YYYY - HH:mm') }}</td>
                        </tr>

                        <tr v-if="state.pagination.listProducts.length == 0">
                            <td colspan="8" class="py-4 text-center text-sm">
                                Laporan Produk Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listProducts.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listProducts.length }} dari {{ (state.filters.status ? state.filters.listProducts : state.products).length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= (state.filters.status ? state.filters.listProducts : state.products).length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import axios from 'axios'

    export default {
        setup() {
            const day   = inject('day')

            const state = reactive({
                products: [],
                loading: true,

                filters: {
                    status: false,
                    listProducts: [],
                    rules: {
                        earlyPeriod: null,
                        endPeriod: null,
                    }
                },

                pagination: {
                    begin: 0,
                    end: 10,
                    listProducts: []
                }
            })

            const periodFilter = () => {
                state.pagination.begin = 0
                state.pagination.end = 10

                if (state.filters.rules.earlyPeriod && ['', null].includes(state.filters.rules.endPeriod)) {
                    state.filters.rules.endPeriod = day().add(1, 'day').format('YYYY-MM-DD')
                }

                if (state.filters.rules.earlyPeriod == '' || state.filters.rules.endPeriod == '') {
                    state.filters.status = false
                    state.filters.listProducts = []
                } else {
                    state.filters.status = true
                    state.filters.listProducts = state.products.filter(v => {
                        return day(
                                day(v.created_at).format('YYYY-MM-DD')
                            ).isBetween(
                                day(state.filters.rules.earlyPeriod).format('YYYY-MM-DD'),
                                day(state.filters.rules.endPeriod).format('YYYY-MM-DD'), 'day', '[)'
                            )
                    })
                }
                
                pageControl()
            }

            watch(() => state.filters.rules.earlyPeriod, periodFilter)
            watch(() => state.filters.rules.endPeriod, periodFilter)

            const pageControl = (direction = null) => {
                if (direction === 'left') {
                    state.pagination.begin -= 10
                    state.pagination.end -= 10
                } else if (direction === 'right') {
                    state.pagination.begin += 10
                    state.pagination.end += 10
                }

                state.pagination.listProducts = (
                    state.filters.status ? state.filters.listProducts : state.products
                ).slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            onMounted(() => {
                axios.get('/api/admin/report/product').then(({ data }) => {
                    state.loading  = false
                    state.products = data.results

                    pageControl()
                })
            })

            return {
                day,
                state,
                pageControl
            }
        }
    }
</script>
