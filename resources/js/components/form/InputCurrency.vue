<template>
    <Field v-slot="{ field }" name="harga_beli" type="text" ref="inputRef" :value="value">
        <input v-bind="field" class="w-full text-xs font-semibold bg-transparent focus:outline-none" placeholder="20.xxx" />
    </Field>
</template>

<script>
    import { useCurrencyInput } from "vue-currency-input"

    export default {
        props: {
            value: {
                type: null
            },
            modelValue: Number,
            options: {
                type: Object,
                default: {
                    currency: "USD",
                    currencyDisplay: "hidden",
                    hideCurrencySymbolOnFocus: true,
                    hideGroupingSeparatorOnFocus: true,
                    hideNegligibleDecimalDigitsOnFocus: true,
                    autoDecimalDigits: false,
                    autoSign: true,
                    useGrouping: true,
                    accountingSign: false
                }
            }
        },

        setup(props) {
            const { inputRef } = useCurrencyInput(props.options)

            return {
                inputRef
            }
        }
    }
</script>
