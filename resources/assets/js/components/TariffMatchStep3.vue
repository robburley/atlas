<style>
    .border-thick {
        -webkit-box-shadow: 3px 3px 2px 0px rgba(0, 1, 1, 0.2) !important;
        -moz-box-shadow: 3px 3px 2px 0px rgba(0, 1, 1, 0.2) !important;
        box-shadow: 3px 3px 2px 0px rgba(0, 1, 1, 0.2) !important;
        border: 2px solid #ffba00 !important;
    }
</style>

<template>
    <div>
        <div class="row m-t-25" v-if="data.recommendations.lines == 0">
            <div class="col-xs-12 text-center">
                <h1 class="text-purple">
                    <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
                </h1>

                <h4 class="text-purple">
                    Please wait while we gather the best deal.
                </h4>

                <p class="text-purple">
                    This may take a while.
                </p>
            </div>
        </div>

        <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
            <div v-if="data.recommendations.lines > 0">
                <div class="row m-t-25" v-if="data.total > 0">
                    <div class="col-sm-12 text-center">
                        <h4 class="text-info">Tariff match ran {{ data.total | currency('', 0)
                            }} deals in {{ data.timeTaken | currency('', 2) }} seconds to find you the best deal.</h4>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-sm-4">
                                <h3 class="text-success text-center">
                                    {{ data.recommendations.lines }}
                                </h3>
                                <h4 class="text-dark text-center">
                                    Lines
                                </h4>
                            </div>

                            <div class="col-sm-4">
                                <h3 class="text-purple text-center">
                                    {{ data.recommendations.totalMinutes }}
                                </h3>
                                <h4 class="text-dark text-center">
                                    Total Minutes
                                </h4>
                            </div>

                            <div class="col-sm-4">
                                <h3 class="text-info text-center">
                                    {{ data.recommendations.totalData }}GB
                                </h3>
                                <h4 class="text-dark text-center">
                                    Total Data
                                </h4>
                            </div>
                        </div>

                        <div class="row m-t-25">
                            <div class="col-sm-10 col-sm-offset-1">
                                <h4 class="text-dark">
                                    Includes
                                </h4>
                                <ul class="list-group list-group-minimal">
                                    <li class="list-group-item">
                                        Unlimited O2 to O2 minutes
                                    </li>

                                    <li class="list-group-item">
                                        Unlimited minutes to 10 nominated UK landline numbers (01, 02, or 03) of your choice
                                    </li>

                                    <li class="list-group-item">
                                        <strong>Free</strong>
                                        International Traveler – when roaming anywhere in Europe, it's free to use
                                        minutes, texts and data (network terms and conditions apply)
                                    </li>

                                    <li class="list-group-item">
                                        <strong>Free</strong> voicemail retrieval
                                    </li>

                                    <li class="list-group-item">
                                        <strong>Free</strong> itemised billing and online billing manager
                                    </li>

                                    <li class="list-group-item">
                                        36 month contract – <strong>12 month account review</strong>
                                        will be carried out by Win Win (once again, research is carried out throughout
                                        the market to potentially obtain further savings and benefits)
                                    </li>

                                    <li class="list-group-item">
                                        Mid-term contract extension – at the <strong>12</strong>
                                        month stage, Win Win will negotiate with
                                        the network <strong>additional funds</strong>
                                        to be put towards hardware & package amendments.
                                    </li>


                                    <li class="list-group-item" v-if="data.recommendations.buyout > 0">
                                        Buyout cost of up to £{{ data.recommendations.buyout }} will be
                                        covered – free of charge
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row m-t-25" v-if="Object.keys(data.recommendations.handsets).length > 0">
                            <div class="col-sm-10 col-sm-offset-1">
                                <h4 class="text-dark">
                                    Hardware
                                </h4>

                                <ul class="list-group list-group-minimal">
                                    <li class="list-group-item" v-for="handsets in data.recommendations.handsets"
                                        v-if="handsets[0]">
                                        {{ handsets.length }} x {{ handsets[0].manufacturer }} {{ handsets[0].model }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row ">
                    <div class=" col-sm-offset-6 col-sm-2 p-t-10">
                        Add a personalized Message
                    </div>
                    <div class="col-sm-4 p-t-5 p-l-10 p-r-30 p-b-10">
                        <textarea class="form-control" v-model="data.message"></textarea>
                    </div>
                </div>
                <div class="row ">
                    <div class=" col-sm-offset-6 col-sm-2 p-t-10">
                        Send Proposal To
                    </div>
                    <div class="col-sm-4 p-t-5 p-l-10 p-r-30 p-b-10">
                        <select-box delay="true"
                                    :options.sync="contacts"
                                    v-model.number="data.selectedContact"
                        ></select-box>
                    </div>
                </div>


                <div class="row" v-for="data, type in data.recommendations.dealCalculators">
                    <div class="col-sm-12 m-t-25" v-show="data.length > 0">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-dark">
                                    {{ type }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-show="data.length > 0">
                        <div class="col-sm-12" v-for="recommendation in data">
                            <div class="row m-b-10 m-l-25 m-r-25" style="border-bottom: 1px solid #eee;"
                                 :class="[recommendation.class, {'border-thick': recommendation.calc.primary}, {'panel-warning': recommendation.calc.primary}]"
                                 v-if="recommendation.credits > 0 && recommendation.calc && recommendation.calc.overview.cashBack >= 0"
                            >
                                <div class="col-sm-4 p-t-10">
                                    {{ recommendation.title }}
                                </div>
                                <div class="col-sm-2 p-t-10">
                                    {{ recommendation.calc.overview.discountedMonthlyCost | currency('£') }} per month
                                </div>
                                <div class="col-sm-2 p-t-10">
                                    <span v-if="user_level !== 5">
                                        {{ recommendation.credits }} credits
                                    </span>
                                </div>
                                <div class="col-sm-2 p-r-0">
                                    <button type="submit" class="btn btn-info btn-block btn-icon m-b-0"
                                            :disabled="utilities.loading"
                                            @click="sendProposal(recommendation.calc.id)"
                                    >
                                        <i class="fa fa-fw fa-spinner fa-spin"
                                           v-if="utilities.loading"></i>
                                        <i class="fa fa-fw fa-envelope" v-else></i>

                                        <span>Proposal</span>
                                    </button>
                                </div>

                                <div class="col-sm-2 p-r-0">
                                    <a class="btn btn-success btn-block btn-icon m-b-0"
                                       v-on:click="selectDeal(recommendation.calc)"
                                       :disabled="utilities.loading"
                                    >
                                        <span>Select</span>

                                        <i class="fa fa-fw fa-spinner fa-spin"
                                           v-if="utilities.loading"></i>
                                        <i class="fa fa-fw fa-save" v-else></i>
                                    </a>
                                </div>
                            </div>

                            <div class="row m-b-10 m-l-25 m-r-25" style="border-bottom: 1px solid #eee;" v-else>

                                <div class="col-sm-4 text-danger">
                                    {{ recommendation.title }}
                                </div>
                                <div class="col-sm-8 text-danger">
                                    Unfortunately, this option is not available.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div class="row m-t-25">
            <div class="col-xs-6">
                <a class="btn btn-info btn-icon" @click="previousStep" :disabled="utilities.loading">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-backward" v-else></i>
                    <span>Back to requirements</span>
                </a>
            </div>
            <div class="col-xs-6 text-right">
                <a type="submit" class="btn btn-success btn-icon"
                   :disabled="utilities.loading || !hasSelectedDealCalculator" @click="finished">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-save" v-else></i>
                    <span>Continue</span>
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
            user_level: Number,
        },
        filters: {},
        watch: {
            tariffmatch: function (data) {
                this.getRecommendations()
            },
        },
        computed: {
            contacts: function () {
                return _.map(this.tariffmatch.opportunity.customer.contacts, function (item) {
                    return {
                        id: item.id,
                        text: item.forename + ' ' + item.surname + ' (' + (item.email_address ? item.email_address : 'No Email Set') + ')',
                    }
                })
            },
            backToRequirementsData: function () {
                return {
                    step: 2,
                    mobile_opportunity_id: this.opportunity,
                    delete_deal_calculators: true,
                }
            },
            downloadProp: function () {
                return '/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/proposal'
            },
            hasSelectedDealCalculator: function () {
                return _.filter(_.flatten(_.map(this.data.recommendations.dealCalculators, function (type) {
                    return _.map(type, function (data) {
                        if (data.calc && data.calc.primary == 1) {
                            return data
                        }
                    })
                }))).length
            },
        },
        data() {
            return {
                data: {
                    recommendations: {
                        lines: 0,
                        totalMinutes: 0,
                        totalData: 0,
                        handsets: [],
                        dealCalculators: [],
                    },
                    selectedContact: null,
                    message: '',
                },
                utilities: {
                    laravelToken: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
                    loading: false,
                },
            }
        },
        methods: {
            sendProposal(id) {
                axios.post(this.downloadProp, {
                    'deal_calc': id,
                    'contact': this.data.selectedContact,
                    'message': this.data.message,
                })
                    .then(function (success) {
                        swal(
                            success.data.success,
                            'Make sure the customer checks their junk mail',
                            'success',
                        )
                    })
                    .catch(function (error) {
                        swal('Error', error.response.data.error, 'error')
                    })
            },
            finished() {
                let self = this

                swal({
                        title: 'Are you sure?',
                        text: 'You will not be able to edit this once saved.',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#8dc63f',
                        confirmButtonText: 'Save',
                        cancelButtonText: 'Cancel',
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            let data = {
                                'mobile_opportunity_status_id': 8,
                            }

                            axios.post('/customers/' + self.customer + '/mobile/opportunities/' + self.opportunity, data)
                                .then(function (response) {
                                    location.reload()
                                })
                        }
                    })

            },
            selectDeal: function (dealCalculator) {
                let self = this
                self.utilities.loading = true

                let url = '/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/deal-calculator/' + dealCalculator.id + '/set-active'

                axios.get(url)
                    .then(function (response) {
                        self.$emit('updateTariffMatch')
                    })
            },
            previousStep() {
                let self = this

                self.utilities.loading = true

                axios.post('/api/tariff-match/update/3', this.backToRequirementsData)
                    .then(function (response) {
                        self.$emit('updateTariffMatch')
                    })
            },
            getRecommendations() {
                let self = this

                self.utilities.loading = true
                let start = performance.now()
                axios.post('/api/tariff-match/generate/' + this.opportunity, {'deal_calculators': this.tariffmatch.deal_calculators})
                    .then(function (response) {
                        self.data.recommendations.lines = response.data.lines
                        self.data.recommendations.totalMinutes = response.data.totalMinutes
                        self.data.recommendations.totalData = response.data.totalData
                        self.data.recommendations.handsets = response.data.handsets
                        self.data.recommendations.dealCalculators = response.data.dealCalculators
                        self.data.recommendations.buyout = response.data.buyout

                        self.data.total = response.data.total
                        self.data.timeTaken = (performance.now() - start) / 1000

                        self.utilities.loading = false
                    })
            },
        },
        mounted() {
            this.getRecommendations()
        },
    }
</script>

