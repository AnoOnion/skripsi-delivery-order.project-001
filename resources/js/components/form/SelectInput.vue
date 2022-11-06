<template>
    <Listbox as="div" @update:modelValue="$emit('update:modelValue', $event)" v-slot="{ open }">
        <ListboxButton :disabled="disabled" class="flex justify-between items-center w-full px-3 disabled:text-slate-700 disabled:dark:text-slate-300">
            <h6 class="text-xs font-semibold capitalize">{{ (value ? (keyProp == labelProp ? value : options.filter(v => v.key == value)[0][labelProp]) : null) || (modelValue ? (keyProp == labelProp ? modelValue : options.filter(v => v.key == modelValue)[0][labelProp]) : 'Pilih') }}</h6>

            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
            </svg>
        </ListboxButton>

        <transition
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-show="open" class="absolute top-10 w-full p-1 rounded-md z-10 bg-slate-200 dark:bg-slate-900">
                <ListboxOptions class="focus:outline-none" static>
                    <ListboxOption v-slot="{ active, selected }" v-for="option in options" :key="option[keyProp]" :value="option[keyProp]" :disabled="option?.disabled != undefined ? option.disabled : false" as="template" class="focus:outline-none">
                        <li class="flex items-center py-2 cursor-pointer select-none" :class="[
                            active ? 'text-slate-700 dark:text-slate-300' : (
                                option?.disabled != undefined ? 'text-slate-700 dark:text-slate-300' : 'text-slate-800 dark:text-slate-200'
                            )
                        ]">
                            <div class="flex justify-center w-8">
                                <svg v-if="selected" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>

                            <div class="truncate text-xs font-semibold">{{ option[labelProp] }}</div>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </div>
        </transition>
    </Listbox>
</template>

<script>
    import { Listbox, ListboxLabel, ListboxButton, ListboxOptions, ListboxOption } from "@headlessui/vue"

    export default {
        components: {
            Listbox, ListboxLabel, ListboxButton, ListboxOptions, ListboxOption
        },

        props: {
            options: {
                type: Array,
                required: true
            },
            disabled: {
                type: Boolean
            },
            modelValue: {
                type: null
            },
            value: {
                type: null
            },
            keyProp: {
                type: String,
                required: true
            },
            labelProp: {
                type: String,
                required: true
            },
        },

        emits: [ 'update:modelValue' ]
    }
</script>
