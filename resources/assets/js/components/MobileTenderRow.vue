<style>
</style>

<template>
    <tr>
        <td>
            {{ handset.device }}
        </td>

        <td class="text-center p-t-10">
            {{ handset.quantity }}
        </td>

        <td>
            <input type="number" class="form-control" step="0.01" min="0"
                   v-model.number="handset.unit_price" v-on:keyup="calculateTotal">
        </td>

        <td>
            <input type="number" class="form-control" step="0.01" min="0"
                   v-model.number="handset.total_price" v-on:keyup="calculateUnit">
        </td>

        <td>
            <select name="" class="form-control" v-model.number="handset.lead_time">
                <option value="1">1 Day</option>
                <option value="7">1 Week</option>
                <option value="8">More Than 1 week</option>
            </select>
        </td>
    </tr>
</template>

<script>
    export default {
        components: {},
        props: {
            handset_data: {
                required: true,
            },
        },
        filters: {},
        computed: {},
        data() {
            return {
                handset: {},
                utilities: {},
            }
        },
        methods: {
            calculateTotal() {
                this.handset.total_price = _.round(_.multiply(this.handset.unit_price, this.handset.quantity), 2)
            },
            calculateUnit() {
                this.handset.unit_price = _.round(_.divide(this.handset.total_price, this.handset.quantity), 2)
            }
        },
        mounted() {
            this.handset = this.handset_data
        },
    }
</script>

