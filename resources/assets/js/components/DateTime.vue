<template>
    <input class="form-control datepicker"
           ref="input"
           v-bind:value="value"
           data-date-format="dd/mm/yyyy"
           data-date-end-date="0d"
           placeholder="dd/mm/yyyy"
           type="text"/>
</template>

<script>
    import moment from 'moment';

    export default {
        props: [
            'value'
        ],
        mounted: function () {
            let self = this;

            this.$nextTick(function () {
                $(this.$el).datetimepicker({
                    startView: 1,
                    todayHighlight: true,
                    todayBtn: "linked",
                    autoclose: true,
                    format: "dd/mm/yyyy",

                    timeFormat: 'HH:mm:ss',
                    showSecond: false,
                    stepMinute: 5,
                    hourMin: 5,
                    hourMax: 22,
                })
                    .on('change', function (e) {
                        let date = e.target.value;

                        self.updateValue(date);
                    });
            });
        },
        methods: {
            updateValue: function (value) {

                this.$emit('input', value);
            },
        }
    }
</script>