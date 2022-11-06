<template>
    <router-view/>
</template>

<script>
    import { onMounted } from '@vue/runtime-core'

    import { loadProgressBar } from 'axios-progress-bar'

    export default {
        setup() {
            onMounted(() => {
                loadProgressBar()
            })
        }
    }
</script>
