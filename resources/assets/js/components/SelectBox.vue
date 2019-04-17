<template>
    <select>
        <slot></slot>
    </select>
</template>

<script>
    export default {
        props: ['options', 'value', 'delay'],
        mounted: function () {
            let self = this;

            this.delay
                ? setTimeout(function () {
                    self.render()
                }, 1000)
                : this.render();
        },
        watch: {
            value: function (value) {
                $(this.$el).val(value).trigger('change');
            },
            options: function (options) {
                this.setOptions(options)
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        },
        methods: {
            setOptions(options) {
                let vm = this;

                $(this.$el)
                    .select2({data: options})
                    .val(this.value)
                    .trigger('change')
                    .on('change', function () {
                        vm.$emit('input', this.value)
                    })

            },
            render() {
                this.setOptions(this.options)
            }
        }
    }
</script>
