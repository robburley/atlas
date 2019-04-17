<style>
</style>

<template>
    <span class="label pull-right" :class="textColor">

        {{ data.figure}}
    </span>
</template>

<script>
    export default {
        components: {},
        props: {
            method: {
                Type: 'String',
                Required: true
            },
            argument: {
                Type: 'String',
                Required: true
            },
            colour: {
                Type: 'String',
                Required: true
            }
        },
        filters: {},
        computed: {
            textColor() {
                return 'text-' + this.colour
            }
        },
        data() {
            return {
                data: {
                    figure: '-',
                },
                utilities: {},
            }
        },
        methods: {
            getData() {
                let self = this
                
                window.axios.post('/nav/figures', {
                    method: self.method,
                    argument: self.argument,
                })
                .then(function(response){
                    if(response.data) {
                        self.data.figure = response.data
                    }
                })
            },
        },
        mounted() {
            this.getData()
        },
    }
</script>

