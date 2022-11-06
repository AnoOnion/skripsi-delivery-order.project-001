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

                <div>Kendaraan</div>
            </nav>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-end space-x-0 md:space-x-4 space-y-3 md:space-y-0 whitespace-nowrap">
                <div>
                    <h6 class="text-sm font-semibold">Laporan Kendaraan.</h6>
                    <p class="text-xs text-slate-700 dark:text-slate-300">Daftar laporan kendaraan berdasarkan status penggunaan.</p>
                </div>

                <div class="grid md:flex grid-cols-12 items-center space-x-3 w-full md:w-auto">
                    <div class="col-span-4 flex flex-col space-y-2">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">Kurir</label>

                        <div class="relative flex w-full md:w-36 py-2.5 border rounded-md overscroll-contain border-transparent bg-slate-200/50 dark:bg-slate-800/50">
                            <SelectInput
                                :options="[{ nama_depan: 'Semua' }, ...state.filters.rules.courier.data]"
                                @update:modelValue="v => state.filters.rules.courier.value = v"
                                :value="state.filters.rules.courier.value"
                                key-prop="nama_depan"
                                label-prop="nama_depan"
                                class="w-full text-xs font-semibold"
                            />
                        </div>
                    </div>

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
                        <th class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NO</th>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ID UNIQUE</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">NAMA MERK</td>
                        <td class="px-5 py-3 text-center text-xs font-medium text-slate-500 tracking-wider">STATUS</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">CATATAN</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">ADMIN</td>
                        <td class="px-5 py-3 text-xs font-medium text-slate-500 tracking-wider">DIBUAT</td>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50 dark:divide-slate-800/50">
                    <template v-if="state.loading">
                        <tr v-for="loading in 3" :key="loading" class="text-sm font-flow">
                            <th class="px-5 py-4 text-slate-500">x.</th>
                            <td class="px-5 py-4 whitespace-nowrap">Ken.12345</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-xs text-slate-500">G 1234 ABC</div>
                                <div>Lorem, ipsum dolor.</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-white text-white bg-white/50">Ada</div>
                            </td>
                            <td class="px-5 py-4">Lorem ipsum dolor sit amet.</td>
                            <td class="px-5 py-4 whitespace-nowrap">Admin</td>
                            <td class="px-5 py-4 whitespace-nowrap">00 00 00 00:00</td>
                        </tr>
                    </template>

                    <template v-else>
                        <tr v-for="(vehicle, index) in state.pagination.listVehicle" :key="index" class="text-sm">
                            <th class="px-5 py-4 whitespace-nowrap text-slate-500">{{ index + 1 + state.pagination.begin }}.</th>
                            <td class="px-5 py-4 whitespace-nowrap">{{ vehicle.kode_laporan }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-xs text-slate-500">{{ vehicle.plat_nomer }}</div>
                                <div>{{ vehicle.nama_merk }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div v-if="vehicle.status == 'ada'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full before:bg-slate-300 text-black dark:text-white bg-white/50">Ada</div>

                                <div v-if="vehicle.status == 'pakai'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-sky-600 after:dark:bg-sky-400 before:bg-sky-600 before:dark:bg-sky-400 text-sky-600 dark:text-sky-400 bg-sky-500/50">Dipakai</div>

                                <div v-if="vehicle.status == 'masalah'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-rose-600 after:dark:bg-rose-400 before:bg-rose-600 before:dark:bg-rose-400 text-rose-600 dark:text-rose-400 bg-rose-500/50">Bermasalah</div>

                                <div v-if="vehicle.status == 'perbaikan'" class="relative w-min px-3 pl-6 py-1 m-auto rounded-full text-xs before:absolute before:top-2.5 before:left-2.5 before:w-[0.3125rem] before:h-[0.3125rem] before:rounded-full after:absolute after:top-2.5 after:left-2.5 after:w-[0.3125rem] after:h-[0.3125rem] after:rounded-full after:animate-ping after:bg-amber-600 after:dark:bg-amber-400 before:bg-amber-600 before:dark:bg-amber-400 text-amber-600 dark:text-amber-400 bg-amber-500/50">Perbaikan</div>
                            </td>
                            <td class="px-5 py-4">{{ vehicle.catatan ?? 'Tidak Ada' }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">{{ vehicle.nama_depan }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">{{ day(vehicle.created_at).format('DD MMM YYYY - HH:mm') }}</td>
                        </tr>

                        <tr v-if="state.pagination.listVehicle.length == 0">
                            <td colspan="7" class="py-4 text-center text-sm">
                                Laporan Kendaraan Belum Ada.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between items-center space-x-3">
            <h6 class="text-sm font-semibold whitespace-nowrap text-slate-700 dark:text-slate-300">Menampilkan {{ state.pagination.listVehicle.length > 0 ? '1' : '0' }} sampai {{ state.pagination.listVehicle.length }} dari {{ (state.filters.status ? state.filters.listVehicle : state.vehicle).length }} Data</h6>

            <div class="flex items-center space-x-3">
                <button @click="pageControl('left')" :disabled="state.pagination.begin === 0" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="pageControl('right')" :disabled="state.pagination.end >= (state.filters.status ? state.filters.listVehicle : state.vehicle).length" class="p-2 rounded-md bg-white dark:bg-slate-800/50 disabled:opacity-50 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { useStore } from 'vuex'
    import { inject, onMounted, reactive, watch } from '@vue/runtime-core'

    import axios from 'axios'

    import SelectInput from '~/components/form/SelectInput'

    export default {
        components: {
            SelectInput
        },

        setup(){
            const day   = inject('day')

            const store = useStore()
            const state = reactive({
                vehicle: [],
                loading: true,

                filters: {
                    status: false,
                    listVehicle: [],
                    rules: {
                        courier: {
                            data: [],
                            value: 'Semua'
                        },
                        earlyPeriod: null,
                        endPeriod: null,
                    }
                },

                pagination: {
                    begin: 0,
                    end: 10,
                    listVehicle: []
                }
            })

            const periodFilter = () => {
                state.pagination.begin = 0
                state.pagination.end = 10

                if (state.filters.rules.earlyPeriod && ['', null].includes(state.filters.rules.endPeriod)) {
                    state.filters.rules.endPeriod = day().add(1, 'day').format('YYYY-MM-DD')
                }

                if (
                    (state.filters.rules.earlyPeriod == '' || state.filters.rules.endPeriod == '') &&
                    state.filters.rules.courier.value == 'Semua'
                ) {
                    state.filters.status = false
                    state.filters.listVehicle = []
                } else {
                    state.filters.status = true
                    state.filters.listVehicle = state.vehicle.filter(v => {
                        return (
                                (
                                    day( day(v.created_at).format('YYYY-MM-DD') ).isBetween(
                                    day(state.filters.rules.earlyPeriod).format('YYYY-MM-DD'),
                                    day(state.filters.rules.endPeriod).format('YYYY-MM-DD'), 'day', '[)'
                                ) && (
                                    state.filters.rules.courier.value == 'Semua' ||
                                    state.filters.rules.courier.value == v.nama_depan
                                )
                            ) || (
                                (
                                    ['', null].includes(state.filters.rules.earlyPeriod) ||
                                    ['', null].includes(state.filters.rules.endPeriod)
                                ) && (
                                    state.filters.rules.courier.value == 'Semua' ||
                                    state.filters.rules.courier.value == v.nama_depan
                                )
                            )
                        )
                    })
                }

                pageControl()
            }

            watch(() => state.filters.rules.courier.value, periodFilter)
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

                state.pagination.listVehicle = (
                    state.filters.status ? state.filters.listVehicle : state.vehicle
                ).slice(
                    state.pagination.begin, state.pagination.end
                )
            }

            onMounted(() => {
                axios.get('/api/admin/member').then(({ data }) => {
                    state.filters.rules.courier.data = data.results
                })

                if (store.getters['search/search'].length > 0) {
                    state.loading = false
                    state.vehicle = store.getters['search/search']

                    pageControl()

                    store.dispatch('search/saveDataSearch', [])
                } else {
                    axios.get('/api/admin/report/vehicle').then(({ data }) => {
                        state.loading = false
                        state.vehicle = data.results

                        pageControl()
                    })
                }
            })

            return {
                day,
                state,
                pageControl
            }
        }
    }
</script>
