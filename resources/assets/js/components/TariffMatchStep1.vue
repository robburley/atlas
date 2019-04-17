<style>
    .select2-container--default .select2-selection--single {
        border: 1px solid #cccccc;
    }

    .v-select .dropdown-toggle {
        border-radius: 0;
    }

    .v-select .selected-tag {
        color: #333;
        background-color: transparent;
        border: none;
        border-radius: 0;
        float: left;
        line-height: 24px;
        margin: 0 1px 0 3px;
    }

    .v-select input[type=search], .v-select input[type=search]:focus {
        height: 26px;
    }

    .v-select .open-indicator {
        bottom: 0;
    }

    .v-select .dropdown-menu {
        border-radius: 0;
    }

    .v-select .spinner, .v-select .spinner:after {
        width: 4em;
        height: 4em;
    }

    .v-select.open .open-indicator {
        bottom: -2px;
    }
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

                <div class="col-sm-2">
                    <p>Data (GB)</p>

                    <input type="number" min="0" step="0.5" class="w-100-p" v-model="line.data">
                </div>

                <div class="col-sm-3">
                    <p>Network</p>

                    <select-box
                            :options="utilities.networks"
                            v-model.number="line.network"
                            :value="line.network"
                    ></select-box>
                </div>

                <div class="col-sm-3">
                    <p>Device</p>

                    <v-select
                            :debounce="250"
                            @search="getOptions($event, line)"
                            :options="line.devices"
                            v-model="line.device"
                            placeholder="Search Handsets"
                            :loading="utilities.loading"
                    >
                    </v-select>
                    <!--:on-search="getOptions"-->
                </div>

                <div class="col-sm-1 text-right m-t-18">
                    <a class="btn btn-danger p-t-6 p-b-6" v-on:click="removeLine(line)">
                        <i class="fa fa-close fa-lg"></i>
                    </a>
                </div>
            </div>

            <hr>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <h4 class="text-dark">Average monthly bill</h4>
            </div>

            <div class="col-sm-4">
                <div class="input-group m-t-15">
                    <div class="input-group-addon">£</div>
                    <input type="text" class="form-control" v-model="data.current_monthly_cost">
                </div>
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
            <div class="col-xs-12 text-right">
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
    import SelectBox from './SelectBox'
    import VueScrollTo from 'vue-scrollto'
    import 'vue-popperjs/dist/css/vue-popper.css'

    export default {
        filters: {
            type: function (value) {
                return value === 1 ? 'Voice' : 'Data'
            },
        },
        components: {},
        props: {
            customer: Number,
            opportunity: Number,
            tariffmatch: Object,
        },
        computed: {
            voiceLines: function () {
                return _.filter(this.data.lines, function (l) {
                    return l.type === 1
                }).length
            },
            dataLines: function () {
                return _.filter(this.data.lines, function (l) {
                    return l.type === 2
                }).length
            },
            linesOrdered: function () {
                return _.sortBy(this.data.lines, function (l) {
                    return l.type
                })
            },

            formData: function () {
                return {
                    lines: _.map(this.data.lines, function (line, key) {
                        return _.pickBy(line, function (value, key) {
                            return !_.startsWith(key, 'devices')
                        })
                    }),
                    current_monthly_cost: this.data.current_monthly_cost,
                    step: 2,
                    mobile_opportunity_id: this.opportunity,
                }
            },
        },
        data() {
            return {
                data: {
                    lines: [],
                    current_monthly_cost: 0,
                },
                utilities: {
                    loading: false,
                    errors: false,
                    networks: [],
                },
            }
        },
        methods: {
            getOptions(search, line) {
                this.utilities.loading = true

                axios.get('/api/tariff-match/customer-handsets?model=' + search).then(resp => {
                    line.devices = resp.data

                    this.utilities.loading = false
                })
            },
            addLine(type) {
                this.data.lines.push({
                    type: type,
                    network: '',
                    name: '',
                    device: '',
                    mins: 0,
                    data: 0,
                    devices: [],
                })
            },
            removeLine(row) {
                let index = this.data.lines.indexOf(row)

                this.data.lines.splice(index, 1)
            },
            nextStep() {
                let self = this
                self.utilities.loading = true

                console.log(this.formData)

                axios.post('/api/tariff-match/update/1', this.formData)
                    .then(function (response) {
                        self.$emit('updateTariffMatch')
                    })
                    .catch(function (errors) {
                        self.utilities.loading = false

                        self.utilities.errors = errors.response.data

                        self.$scrollTo('#error-block')
                    })
            },
        },
        mounted() {
            let self = this

            axios.get('/api/tariff-match/networks')
                .then(function (response) {
                    self.utilities.networks = response.data
                })
                .then(function () {
                    self.data = self.tariffmatch

                    _.each(self.data.lines, function (line) {
                        line.devices = []
                    })
                })

        },
    }
</script>

