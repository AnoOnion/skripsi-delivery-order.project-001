<template>
    <router-view :key="$route.params.slug || 'default'" v-slot="{ Component }">
        <transition name="fade" mode="out-in">
            <component :is="Component" />
        </transition>
    </router-view>
</template>

<script>
    export default {
        middleware: 'role-level:admin'
    }
</script>
