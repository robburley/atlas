<style scoped>
</style>

<template>
    <form v-on:submit.prevent="saveCommercials">
        <div class="row">
            <div class="col-xs-12">
                <h4 class="text-dark">
                    Term
                    <small>(Months)</small>
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">

                <input class="w-100-p"
                       type="number"
                       v-model="data.term"
                       step="1"
                       min="0"
                >
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-xs-12">
                <h4 class="text-dark">
                    Package Details
                </h4>

                <table class="table table-responsive border-top-info">
                    <thead>
                    <tr v-if="data.lines.length === 0">
                        <td colspan="5">
                            No Lines currently added, click add to add a new line.
                        </td>
                    </tr>
                    </thead>
                    <tbody v-for="line in data.lines">
                    <tr>
                        <th class="v-mid text-dark">Type</th>
                        <th class="v-mid text-dark">Telephone Number</th>
                        <th class="v-mid text-dark">Monthly Line Rental</th>
                        <th class="v-mid text-dark">Installation Postcode</th>
                        <th class="v-mid text-dark">Broadband on this number</th>
                    </tr>
                    <tr>
                        <td class="v-mid">
                            <select-box delay="true"
                                        :options="utilities.lineTypeOptions"
                                        v-model.number="line.type"
                            ></select-box>
                        </td>

                        <td class="v-mid">
                            <input class="w-100-p"
                                   name="telephone_number"
                                   type="text"
                                   v-model="line.telephone_number"
                                   v-show="line.type == 2"
                                   :required="line.type == 2"
                            >
                        </td>

                        <td class="v-mid">

                            <div class="col-xs-3 col-lg-2 p-r-0">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-9 col-lg-10 p-l-0">
                                <input class="w-100-p"
                                       type="number"
                                       step="0.01"
                                       v-model.number="line.monthly_line_rental"
                                >
                            </div>
                        </td>

                        <td class="v-mid">
                            <input class="w-100-p"
                                   type="text"
                                   v-model="line.installation_postcode"
                                   required
                            >
                        </td>

                        <td class="v-mid">
                            <select-box delay="true" :options="utilities.broadBandOptions"
                                        v-model.number="line.broadband"></select-box>
                        </td>
                    </tr>

                    <tr>
                        <td class="v-mid">
                            <p class="text-dark">
                                <strong>
                                    1571
                                </strong>
                            </p>

                            <select-box delay="true"
                                        :options="utilities.yesNoOptions"
                                        v-model.number="line.has1571"
                            ></select-box>
                        </td>

                        <td class="v-mid">
                            <p class="text-dark">
                                <strong>
                                    Call Divert
                                </strong>
                            </p>

                            <select-box delay="true"
                                        :options="utilities.yesNoOptions"
                                        v-model.number="line.call_divert"
                            ></select-box>

                        </td>

                        <td class="v-mid">
                            <p class="text-dark">
                                <strong>
                                    Call Waiting
                                </strong>
                            </p>

                            <select-box delay="true"
                                        :options="utilities.yesNoOptions"
                                        v-model.number="line.call_waiting"
                            ></select-box>

                        </td>

                        <td class="v-mid">
                            <p class="text-dark">
                                <strong>
                                    Caller Display
                                </strong>
                            </p>

                            <select-box delay="true"
                                        :options="utilities.yesNoOptions"
                                        v-model.number="line.caller_display"
                            ></select-box>
                        </td>

                        <td class="v-mid">
                            <a class="text-danger pull-right clickable"
                               v-on:click="removeLine(line)">
                                <i class="fa fa-close"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right"
                   v-on:click="addLine()">
                    <i class="fa fa-plus"></i>
                    <span>Add</span>
                </a>
            </div>
        </div>

        <br>
        <div class="row m-b-25">
            <div class="col-sm-6">
                <div class="border-top-purple">
                    <h4 class="text-dark">
                        Please note that all orders are subject to an administration charge of £30.00
                    </h4>

                    <label>
                        <input type="checkbox" v-model="data.admin_charge_confirmed"> Confirmed to customer
                    </label>
                </div>
            </div>
            <div class="col-sm-6" v-if="hasBroadband">
                <div class="border-top-danger">
                    <h4 class="text-dark">
                        Note! All orders for ADSL or Fibre broadband require a pre- configured router at £49.00
                    </h4>

                    <label>
                        <input type="checkbox" v-model="data.broad_band_confirmed"> Confirmed to customer
                    </label>
                </div>
            </div>
        </div>
        <div class="row m-b-25">

            <div class="col-sm-6" v-if="countBroadbandFibre > 0">
                <div class="border-top-info">
                    <h4 class="text-dark">
                        Fibre Broadband Price
                    </h4>

                    <div class="row">
                        <div class="col-xs-3 col-lg-2 p-r-0">
                            <i class="fa fa-gbp m-t-5"></i>
                        </div>
                        <div class="col-xs-9 col-lg-10 p-l-0">
                            <input class="w-100-p"
                                   type="number"
                                   step="0.01"
                                   v-model.number="data.fibre_broad_band_price"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" v-if="countBroadbandAdsl > 0">
                <div class="border-top-warning">
                    <h4 class="text-dark">
                        Broadband Price
                    </h4>
                    <div class="row">
                        <div class="col-xs-3 col-lg-2 p-r-0">
                            <i class="fa fa-gbp m-t-5"></i>
                        </div>
                        <div class="col-xs-9 col-lg-10 p-l-0">
                            <input class="w-100-p"
                                   type="number"
                                   step="0.01"
                                   v-model.number="data.adsl_broad_band_price"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4 class="text-dark">
                    Call Bundles
                </h4>

                <table class="table table-responsive border-top-danger">
                    <thead>
                    <tr>
                        <th class="v-mid col-xs-6">Tariff</th>
                        <th class="v-mid col-xs-6">Setup/Install Charges</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="v-mid">
                            <select-box :options="utilities.tariffOptions"
                                        delay="true"
                                        v-model.number="data.tariff"
                            ></select-box>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-2 col-lg-1">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-10 col-lg-11">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.setup_install_charges">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-responsive border-top-info">
                    <thead>
                    <tr>
                        <th class="v-mid col-xs-6">1000 mins Local & National</th>
                        <th class="v-mid col-xs-6">500 mins UK Std Mobile</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="v-mid">
                            <div class="col-xs-2 col-lg-1">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-10 col-lg-11">
                                <input class="w-100-p" step="0.01" type="number"
                                       v-model.number="data.call_bundle_local_national">
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-2 col-lg-1">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-10 col-lg-11">
                                <input class="w-100-p" step="0.01" type="number"
                                       v-model.number="data.call_bundle_mobile">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <br>
        </div>

        <div class="row" v-if="data.tariff == 3">
            <div class="col-sm-12">
                <table class="table table-responsive border-top-info">
                    <thead>
                    <tr>
                        <th class="v-mid col-sm-2">Local</th>
                        <th class="v-mid col-sm-2">National</th>
                        <th class="v-mid col-sm-2">Vodafone</th>
                        <th class="v-mid col-sm-2">O2</th>
                        <th class="v-mid col-sm-2">EE</th>
                        <th class="v-mid col-sm-2">3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="v-mid">
                            <div class="col-xs-12 col-sm-6 col-lg-8 p-r-0 p-l-0">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.custom_local">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-lg-4 p-l-0 p-r-0 m-t-3">
                                <span class="p-l-5">PPM</span>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-12 col-sm-6 col-lg-8 p-r-0 p-l-0">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.custom_national">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-lg-4 p-l-0 p-r-0 m-t-3">
                                <span class="p-l-5">PPM</span>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-12 col-sm-6 col-lg-8 p-r-0 p-l-0">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.custom_vodafone">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-lg-4 p-l-0 p-r-0 m-t-3">
                                <span class="p-l-5">PPM</span>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-12 col-sm-6 col-lg-8 p-r-0 p-l-0">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.custom_o2">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-lg-4 p-l-0 p-r-0 m-t-3">
                                <span class="p-l-5">PPM</span>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-12 col-sm-6 col-lg-8 p-r-0 p-l-0">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.custom_ee">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-lg-4 p-l-0 p-r-0 m-t-3">
                                <span class="p-l-5">PPM</span>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-12 col-sm-6 col-lg-8 p-r-0 p-l-0">
                                <input class="w-100-p" type="number" step="0.01"
                                       v-model.number="data.custom_three">
                            </div>

                            <div class="col-xs-12 col-sm-6 col-lg-4 p-l-0 p-r-0 m-t-3">
                                <span class="p-l-5">PPM</span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <br>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <table class="table table-responsive border-top-success">
                    <thead>
                    <tr>
                        <th class="v-mid col-xs-3">Monthly Line Rental</th>
                        <th class="v-mid col-xs-3">Monthly Features Rental</th>
                        <th class="v-mid col-xs-3">Total Monthly Recurring Charges</th>
                        <th class="v-mid col-xs-3">Total Setup Charge</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="v-mid">
                            <div class="col-xs-3 col-lg-2 p-r-0">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-9 col-lg-10 p-l-0">
                                <input class="w-100-p" type="text" v-model.number="monthlyLineRental" readonly>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-3 col-lg-2 p-r-0">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-9 col-lg-10 p-l-0">
                                <input class="w-100-p" type="text" v-model.number="monthlyFeaturesRental" readonly>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-3 col-lg-2 p-r-0">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-9 col-lg-10 p-l-0">
                                <input class="w-100-p" type="text" v-model.number="totalMonthlyRecurringCharges"
                                       readonly>
                            </div>
                        </td>
                        <td class="v-mid">
                            <div class="col-xs-3 col-lg-2 p-r-0">
                                <i class="fa fa-gbp m-t-5"></i>
                            </div>
                            <div class="col-xs-9 col-lg-10 p-l-0">
                                <input class="w-100-p" type="text" v-model.number="totalSetupInstallCharges" readonly>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4 class="text-dark">
                    Notes
                </h4>

                <textarea v-model="data.note" class="w-100-p m-b-20 p-t-5 p-l-5 p-b-5 p-r-5" rows="10"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" id="finishedButton">
                <a class="btn btn-info pull-right m-l-5" v-if="utilities.saved" v-on:click.prevent="finishCommercials">
                    <i class="fa fa-fw fa-save"></i>
                    Finished
                </a>

                <button type="submit" class="btn btn-success pull-right">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-save" v-else></i>
                    Save
                </button>
            </div>
        </div>

        <div class="row" id="error-block">
            <div class="col-sm-12" v-if="utilities.errors">
                <div class="alert alert-danger">
                    <p v-for="[error, index] in utilities.errors">
                        {{ error }}
                    </p>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import SelectBox from './SelectBox'
    import VueScrollTo from 'vue-scrollto'

    export default {
        components: {
            SelectBox,
        },
        props: {
            customer: Number,
            opportunity: Number,
        },
        computed: {
            monthlyLineRental: function () {
                return _.sumBy(this.data.lines, 'monthly_line_rental')
            },
            monthlyFeaturesRental: function () {
                return _.sum(_.map(this.data.lines, function (line) {
                    return _.sum([
                        line.has1571,
                        line.call_divert,
                        line.call_waiting,
                        line.caller_display,
                    ])
                }))
            },
            totalMonthlyRecurringCharges: function () {
                return _.sum([
                    this.monthlyLineRental,
                    this.monthlyFeaturesRental,
                    _.multiply(this.countBroadbandFibre, this.data.fibre_broad_band_price),
                    _.multiply(this.countBroadbandAdsl, this.data.adsl_broad_band_price),
                    this.data.call_bundle_local_national,
                    this.data.call_bundle_mobile,
                ])
            },
            totalSetupInstallCharges: function () {
                return _.sum([
                    this.data.setup_install_charges,
                    this.hasBroadband ? 49 : 0,
                ])
            },
            hasBroadband: function () {
                return _.sumBy(this.data.lines, 'broadband') > 0
            },
            countBroadbandFibre: function () {
                return this.fibreBroadbandLines.length
            },
            countBroadbandAdsl: function () {
                return this.adslBroadbandLines.length
            },
            fibreBroadbandLines: function () {
                return _.filter(this.data.lines, function (line) {
                    return line.broadband === 1
                })
            },
            adslBroadbandLines: function () {
                return _.filter(this.data.lines, function (line) {
                    return line.broadband === 2
                })
            },
            formFinishedUrl: function () {
                return '/customers/' + this.customer + '/fixed-line/opportunities/' + this.opportunity
            },
            formUrl: function () {
                return '/customers/' + this.customer + '/fixed-line/opportunities/' + this.opportunity + '/commercials'
            },
            formData: function () {
                return {
                    term: this.data.term,
                    lines: this.data.lines,
                    tariff: this.data.tariff,
                    setup_install_charges: this.data.setup_install_charges,
                    broad_band_confirmed: this.data.broad_band_confirmed,
                    admin_charge_confirmed: this.data.admin_charge_confirmed,
                    fibre_broad_band_price: this.data.fibre_broad_band_price,
                    adsl_broad_band_price: this.data.adsl_broad_band_price,
                    call_bundle_local_national: this.data.call_bundle_local_national,
                    call_bundle_mobile: this.data.call_bundle_mobile,
                    custom_local: this.data.custom_local,
                    custom_national: this.data.custom_national,
                    custom_vodafone: this.data.custom_vodafone,
                    custom_o2: this.data.custom_o2,
                    custom_ee: this.data.custom_ee,
                    custom_three: this.data.custom_three,
                    monthly_line_rental: this.monthlyLineRental,
                    monthly_features_rental: this.monthlyFeaturesRental,
                    total_monthly_recurring_charges: this.totalMonthlyRecurringCharges,
                    total_setup_install_charges: this.totalSetupInstallCharges,
                    hasBroadBand: this.hasBroadband > 0,
                    note: this.data.note,
                }
            },
        },
        data() {
            return {
                data: {
                    lines: [],
                    term: 36,
                    tariff: 1,
                    setup_install_charges: 0,
                    broad_band_confirmed: false,
                    admin_charge_confirmed: false,
                    fibre_broad_band_price: 0,
                    adsl_broad_band_price: 0,
                    call_bundle_local_national: 0,
                    call_bundle_mobile: 0,
                    custom_local: 0,
                    custom_national: 0,
                    custom_vodafone: 0,
                    custom_o2: 0,
                    custom_ee: 0,
                    custom_three: 0,
                    note: '',
                },
                utilities: {
                    saved: false,
                    loading: false,
                    errors: false,
                    lineTypeOptions: [
                        {id: 1, text: 'New'},
                        {id: 2, text: 'Transfer'},
                    ],
                    yesNoOptions: [
                        {id: 0, text: 'No'},
                        {id: 1, text: 'Yes'},
                    ],
                    broadBandOptions: [
                        {id: 0, text: 'None'},
                        {id: 1, text: 'Fibre'},
                        {id: 2, text: 'ADSL'},
                    ],
                    tariffOptions: [
                        {id: 1, text: 'Standard'},
                        {id: 2, text: 'Saver (£5)'},
                        {id: 3, text: 'Custom'},
                    ],
                },
            }
        },
        methods: {
            addLine() {
                this.data.lines.push({
                    type: 2,
                    telephone_number: '',
                    monthly_line_rental: 0,
                    installation_postcode: '',
                    has1571: 0,
                    call_divert: 0,
                    call_waiting: 0,
                    caller_display: 0,
                    broadband: 0,
                })
            },
            removeLine(row) {
                let index = this.data.lines.indexOf(row)

                this.data.lines.splice(index, 1)
            },
            saveCommercials() {
                let self = this
                self.utilities.errors = null
                self.utilities.loading = true

                axios.post(this.formUrl, this.formData)
                    .then(function (response) {
                        self.utilities.loading = false
                        self.utilities.saved = true

                        swal({
                            title: 'Commercials Updated',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        })

                        self.$scrollTo('#finishedButton')
                    })
                    .catch(function (errors) {
                        self.utilities.loading = false
                        self.utilities.saved = false

                        self.utilities.errors = errors.response.data

                        self.$scrollTo('#error-block')
                    })
            },
            finishCommercials() {
                this.saveCommercials()

                let data = {
                    fixed_line_opportunity_status_id: 7,
                }

                axios.post(this.formFinishedUrl, data)
                    .then(function (response) {
                        location.reload()
                    })
            },
        },
        mounted() {
            let vm = this

            axios.get(this.formUrl)
                .then(function (response) {
                    if (Object.keys(response.data).length > 0) {
                        vm.data.lines = response.data.lines
                        vm.data.tariff = response.data.tariff
                        vm.data.setup_install_charges = response.data.setup_install_charges
                        vm.data.broad_band_confirmed = response.data.broad_band_confirmed
                        vm.data.admin_charge_confirmed = response.data.admin_charge_confirmed
                        vm.data.fibre_broad_band_price = response.data.fibre_broad_band_price
                        vm.data.adsl_broad_band_price = response.data.adsl_broad_band_price
                        vm.data.call_bundle_local_national = response.data.call_bundle_local_national
                        vm.data.call_bundle_mobile = response.data.call_bundle_mobile
                        vm.data.custom_local = response.data.custom_local
                        vm.data.custom_national = response.data.custom_national
                        vm.data.custom_vodafone = response.data.custom_vodafone
                        vm.data.custom_o2 = response.data.custom_o2
                        vm.data.custom_ee = response.data.custom_ee
                        vm.data.custom_three = response.data.custom_three
                        vm.data.note = response.data.note
                        vm.data.term = response.data.term
                        vm.data.custom_local = response.data.custom_local
                        vm.data.custom_national = response.data.custom_national

                        vm.utilities.saved = true
                    }
                })
        },
    }
</script>

