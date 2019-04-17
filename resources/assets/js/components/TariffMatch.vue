<style>
</style>

<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <h2 class="text-dark">
                    <i class="fa fa-tags"></i>
                    Tariff Match
                </h2>
                <h4 :class="titleClass">
                    {{ title }}
                </h4>

                <hr>
            </div>
        </div>

        <div class="row" v-if="Object.keys(data.tariffMatch).length == 0">
            <div class="col-sm-12 text-center">
                <h1 class="text-purple">
                    <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
                </h1>
            </div>
        </div>

        <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
            <div v-if="Object.keys(data.tariffMatch).length > 0">
                <tariff-match-step-1 :customer="customer"
                                     :opportunity="opportunity"
                                     :tariffmatch="data.tariffMatch"
                                     v-if="data.tariffMatch.step == 1"
                                     @updateTariffMatch="updateTariffMatch">
                </tariff-match-step-1>

                <tariff-match-step-2 :customer="customer"
                                     :opportunity="opportunity"
                                     :tariffmatch="data.tariffMatch"
                                     v-if="data.tariffMatch.step == 2"
                                     @updateTariffMatch="updateTariffMatch">
                </tariff-match-step-2>

                <tariff-match-step-3 :customer="customer"
                                     :opportunity="opportunity"
                                     :user_level="user_level"
                                     :tariffmatch="data.tariffMatch"
                                     v-if="data.tariffMatch.step == 3"
                                     @updateTariffMatch="updateTariffMatch">
                </tariff-match-step-3>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            customer: Number,
            opportunity: Number,
            user_level: Number,
        },
        data() {
            return {
                data: {
                    tariffMatch: {},
                },
                utilities: {},
            }
        },
        computed: {
            titleClass: function () {
                return {
                    'text-warning': this.data.tariffMatch.step === 1,
                    'text-info': this.data.tariffMatch.step === 2,
                    'text-success': this.data.tariffMatch.step === 3,
                }
            },
            title: function () {
                let titles = [
                    'Current Usage',
                    'Requirements',
                    'Recommended Solution',
                ]

                return titles[this.data.tariffMatch.step - 1]
            },
        },
        methods: {
            updateTariffMatch() {
                this.getTariffMatch(this.opportunity)
            },
            getTariffMatch(id) {
                let self = this

                axios.get('/api/tariff-match/get/' + id)
                    .then(function (response) {
                        if (Object.keys(response.data).length > 0) {
                            self.data.tariffMatch = response.data
                        }
                    })
                    .catch(function (error) {
                        self.data.tariffMatch = {
                            step: 1,
                            monthly_cost: 0,
                            lines: [],
                        }
                    })
            },
        },
        mounted() {
            this.getTariffMatch(this.opportunity)
        },
    }
</script>

