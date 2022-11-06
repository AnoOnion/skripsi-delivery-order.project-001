<template>
    <div :class="$route.meta.wide ? 'md:w-1/6' : 'md:w-2/6'" class="block space-y-3 md:space-y-4 w-full h-full md:h-[calc(100vh-74px)] p-4 z-10 bg-white md:bg-transparent dark:bg-slate-800">
        <div class="block space-y-4 h-[calc(100vh-112px)]">
            <template v-if="state.information">
                <div>
                    <h6 class="text-sm font-semibold capitalize">{{ state.information.judul }}</h6>
                    <p class="text-2xs text-slate-700 dark:text-slate-300">Diposting Oleh {{ state.information.nama_depan }} &middot; {{ day(state.information.created_at).format('DD MMM YYYY - HH:mm') }}</p>
                </div>

                <div class="block space-y-3">
                    <img :src="state.information.gambar" class="w-full h-32 rounded-md object-cover shadow-md" />
                    <p class="text-sm">{{ state.information.deskripsi }}</p>
                </div>
            </template>

            <template v-else>
                <div class="font-flow">
                    <h6 class="text-sm font-semibold capitalize">Lorem ipsum dolor sit amet.</h6>
                    <p class="text-2xs text-slate-700 dark:text-slate-300">Diposting Oleh admin &middot; 00 00 0000 - 00:00</p>
                </div>

                <div class="block space-y-3">
                    <div class="w-full h-36 rounded-md bg-slate-300 dark:bg-slate-700/50"></div>
                    <p class="text-sm font-flow">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptate a id odit itaque est dicta repellat, porro, impedit ullam atque maxime nulla suscipit fugiat laudantium at facilis. Ad, amet dolores.</p>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import { useRoute } from 'vue-router'
    import { inject, onMounted, reactive } from '@vue/runtime-core'

    import axios from 'axios'

    export default {
        setup() {
            const day   = inject('day')

            const route = useRoute()

            const state = reactive({
                information: null
            })

            onMounted(() => {
                axios.get('/api/user/information/' + route.params.slug).then(({ data }) => {
                    state.information = data.results
                })
            })

            return {
                day,
                state
            }
        }
    }
</script>
