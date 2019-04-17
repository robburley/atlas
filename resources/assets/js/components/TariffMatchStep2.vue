<style>
</style>

<template>
    <div>
        <div class="row" v-if="voiceLines < 5">
            <div class="col-xs-12">
                <h4 class="text-dark">
                    Lines:

                    {{ voiceLines }}

                    <a class="btn btn-success m-l-10" v-on:click="addLine(1)">
                        <i class="fa fa-plus"></i>
                    </a>
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="alert alert-warning" role="alert">
                    If the customer requires more than 5 lines, use the deal calculator.
                </div>
            </div>
        </div>

        <hr>

        <div v-for="line, index in linesOrdered">
            <div class="row m-b-10">
                <div class="col-sm-3">
                    <p>Name</p>

                    <input type="text" class="w-100-p" v-model="line.name">
                </div>

                <div class="col-sm-3">
                    <p>Data (GB)</p>

                    <select-box delay="true"
                                :options.sync="utilities.data"
                                v-model.number="line.data"
                                :value="line.data"
                    ></select-box>

                </div>

                <div class="col-sm-5">
                    <p>Hardware</p>

                    <select-box delay="true"
                                :options.sync="utilities.devices"
                                v-model.number="line.device"
                                :value="line.device"
                    ></select-box>
                </div>

                <div class="col-sm-1 text-right v-mid">
                    <div class="p-t-15 hidden-xs"></div>
                    <a class="btn btn-danger p-t-6 p-b-6" v-on:click="removeLine(line)">
                        <i class="fa fa-close fa-lg"></i>
                    </a>
                </div>
            </div>

            <hr>
        </div>

        <div class="row m-t-25">
            <div class="col-sm-3">
                <h4 class="text-dark">New Network</h4>
            </div>

            <div class="col-sm-3">

                <select-box delay="true"
                            :options.sync="utilities.new_networks"
                            v-model="data.new_network"
                            :value="data.new_network"
                ></select-box>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <h4 class="text-dark">Early Termination Fee's</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 m-b-10">
                <div class="row">
                    <div v-for="termination in data.termination_fees">
                        <div class="col-sm-3">
                            {{ termination.network }}
                        </div>

                        <div class="col-sm-3">
                            <input type="number" class="w-100-p" v-model.number="termination.fee">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <h4 class="text-dark">Expected Monthly Cost</h4>
            </div>
            <div class="col-sm-3">
                <input type="number" class="w-100-p" v-model.number="data.expected_monthly_cost">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <hr>
            </div>
        </div>

        <div class="row m-t-25" id="error-block">
            <div class="col-sm-12" v-if="utilities.errors">
                <div class="alert alert-danger">
                    <p v-for="[error, index] in utilities.errors">
                        {{ error }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row m-t-25">
            <div class="col-xs-6">
                <a class="btn btn-info" @click.prevent="previousStep" :disabled="utilities.loading">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-backward" v-else></i>
                    Back to Current Usage
                </a>
            </div>
            <div class="col-xs-6 text-right">
                <a class="btn btn-success" @click.prevent="nextStep" :disabled="utilities.loading">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-save" v-else></i>
                    Next
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {},
        props: {
            customer: Number,
            opportunity: Number,
            tariffmatch: Object,
        },
        filters: {
            type: function (value) {
                return value == 1 ? 'Voice' : 'Data'
            },
        },
        computed: {
            backToCurrentUsageData: function () {
                return {
                    step: 1,
                    mobile_opportunity_id: this.opportunity,
                }
            },
            voiceLines: function () {
                return _.filter(this.data.lines, function (l) {
                    return l.type == 1
                }).length
            },
            dataLines: function () {
                return _.filter(this.data.lines, function (l) {
                    return l.type == 2
                }).length
            },
            linesOrdered: function () {
                return _.sortBy(this.data.lines, function (l) {
                    return l.type
                })
            },
            formData: function () {
                return {
                    requirements: this.data.lines,
                    new_network: this.data.new_network,
                    termination_fees: this.data.termination_fees,
                    step: 3,
                    expected_monthly_cost: this.data.expected_monthly_cost,
                    mobile_opportunity_id: this.opportunity,
                }
            },
        },
        data() {
            return {
                data: {
                    lines: [],
                    monthly_cost: 0,
                    expected_monthly_cost: 0,
                },
                utilities: {
                    loading: false,
                    errors: false,
                    minutes: [
                        {
                            id: 0,
                            text: 0,
                        },
                        {
                            id: 500,
                            text: 500,
                        },
                        {
                            id: 1000,
                            text: 1000,
                        },
                        {
                            id: 1500,
                            text: 1500,
                        },
                        {
                            id: 2000,
                            text: 2000,
                        },
                        {
                            id: 5000,
                            text: '5000',
                        },
                    ],
                    data: [
                        {
                            id: 0,
                            text: 0,
                        },
                        {
                            id: 0.5,
                            text: 0.5,
                        },
                        {
                            id: 1,
                            text: 1,
                        },
                        {
                            id: 2,
                            text: 2,
                        },
                        {
                            id: 3,
                            text: 3,
                        },
                        {
                            id: 4,
                            text: 4,
                        },
                        {
                            id: 5,
                            text: 5,
                        },
                        {
                            id: 6,
                            text: 6,
                        },
                        {
                            id: 8,
                            text: 8,
                        },
                        {
                            id: 10,
                            text: 10,
                        },
                        {
                            id: 20,
                            text: 20,
                        },
                        {
                            id: 25,
                            text: 25,
                        },
                        {
                            id: 30,
                            text: 30,
                        },
                    ],
                    devices: [
                        {
                            id: 0,
                            text: 'No Hardware Required',
                        },
                    ],
                    new_networks: [
                        {
                            id: 'o2',
                            text: 'o2',
                        },
                    ],
                },
            }
        },
        methods: {
            previousStep() {
                let self = this

                self.utilities.loading = true

                axios.post('/api/tariff-match/update/3', this.backToCurrentUsageData)
                    .then(function (response) {
                        self.$emit('updateTariffMatch')
                    })
            },
            addLine(type) {
                this.data.lines.push({
                    type: type,
                    network: '',
                    name: '',
                    device: 0,
                    mins: 0,
                    data: 0,
                })
            },
            removeLine(row) {
                let index = this.data.lines.indexOf(row)

                this.data.lines.splice(index, 1)
            },
            nextStep() {
                let self = this
                self.utilities.loading = true

                axios.post('/api/tariff-match/update/2', this.formData)
                    .then(function (response) {
                        self.$emit('updateTariffMatch')
                    })
                    .catch(function (errors) {
                        self.utilities.loading = false

                        self.utilities.errors = errors.response.data

                        self.$scrollTo('#error-block')
                    })
            },
            getClosestNumber(num, list) {
                let curr = list[0].id
                let diff = Math.abs(num - curr)

                for (let val = 0; val < list.length; val++) {
                    let newdiff = Math.abs(num - list[val].id)

                    if (newdiff < diff) {
                        diff = newdiff
                        curr = list[val].id
                    }
                }

                return curr
            },
            uniqueValues(values, prop) {
                let mapped = _.map(values, function (data) {
                    return data[prop]
                })

                return mapped.filter((v, i, a) => a.indexOf(v) === i)
            },
        },
        mounted() {
            let self = this
            this.data = this.tariffmatch
            this.data.new_network = 'o2'

            if (this.data.expected_monthly_cost == 0) {
                this.data.expected_monthly_cost = this.data.current_monthly_cost
            }

            if (this.data.requirements.length === 0) {
                _.each(this.data.lines, function (line) {
                    line.device = 0
                    line.colour = ''
                    line.mins = self.getClosestNumber(line.mins, self.utilities.minutes)
                    line.data = self.getClosestNumber(line.data, self.utilities.data)
                })
            } else {
                this.data.lines = this.data.requirements
            }

            if (this.data.termination_fees.length === 0) {
                this.data.termination_fees = []

                _.each(this.uniqueValues(this.data.lines, 'network'), function (network) {
                    self.data.termination_fees.push({
                        'network': network,
                        'fee': 0,
                    })
                })
            }

            axios.get('/api/mobile/handsets')
                .then(function (response) {
                    _.each(response.data, function (phone) {
                        self.utilities.devices.push(phone)
                    })
                })
        },
    }
</script>

