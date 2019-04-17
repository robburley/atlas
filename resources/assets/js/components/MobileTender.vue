<style scoped>
    .text-dark {
        color: hsl(302, 75%, 15%) !important;
    }

    .text-light {
        color: hsl(302, 15%, 45%) !important;
    }

    .panel.panel-purple .panel-heading {
        background-color: hsl(302, 50%, 25%);
        color: hsl(302, 15%, 90%);
    }

    .table > tbody > tr > td, .table > tfoot > tr > td, .table > tbody > tr > th, .table > tfoot > tr > th {
        color: hsl(302, 75%, 15%) !important;
    }

    .text-large {
        font-size: 5em !important;
    }

</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="/images/winwin-logo.png" style="width: 200px;" alt="Win Win">
            </div>

            <div class="col-sm-6 text-right">
                <h4 class="text-dark m-b-0">
                    <small class="text-light"> Time Remaining</small>
                </h4>
                <count-down-timer :deadline="invitation.tender.expires_at"
                                  v-on:count-down-finished="disableSubmit"></count-down-timer>
            </div>
        </div>

        <div class="row m-t-25">
            <div class="col-sm-12">
                <div class="panel panel-color panel-purple"><!-- Add class "collapsed" to minimize the panel -->
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ invitation.supplier.name }}
                        </h3>
                    </div>

                    <div class="panel-body">
                        <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                            <div class="row" v-if="!utilities.complete">
                                <div class="col-xs-12">
                                    <p class="text-right text-danger">
                                        If you are unable to facilitate any of the below devices, <br>
                                        Please leave the price fields at £0 and choose "More than 1 week" on the lead time.
                                    </p>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th>
                                                Handset / Colour
                                            </th>

                                            <th class="text-center col-sm-2">
                                                Quantity
                                            </th>

                                            <th class="col-sm-2">
                                                £ Per Unit
                                            </th>

                                            <th class="col-sm-2">
                                                £ Total
                                            </th>

                                            <th class="col-sm-2">
                                                Lead Time
                                            </th>
                                        </tr>

                                        </tbody>

                                        <tbody v-for="handset in handsets">
                                        <mobile-tender-row :handset_data="handset"></mobile-tender-row>
                                        </tbody>
                                    </table>

                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                        <button class="btn btn-success btn-icon btn-icon-standalone pull-right"
                                                v-if="!utilities.disabled"
                                                :disabled="utilities.loading"
                                                @click="submit"
                                        >
                                            <i class="fa fa-spinner fa-spin" v-if="utilities.loading"></i>
                                            <i class="fa fa-check" v-else></i>

                                            <span>Submit Tender</span>
                                        </button>
                                    </transition>
                                </div>

                                <div class="col-sm-12" v-if="utilities.errors">
                                    <div class="alert alert-danger">
                                        <p v-for="[error, index] in utilities.errors">
                                            {{ error }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <p class="text-danger text-right" v-if="utilities.disabled">
                                        This tender has expired.
                                    </p>
                                </div>
                            </div>

                            <div class="row" v-else>
                                <div class="col-sm-12 text-center">
                                    <h1 class="text-large">
                                        <i class="fa fa-check text-success"></i>
                                    </h1>

                                    <h4 class="text-dark">
                                        Thank you for completing the tender request.
                                    </h4>

                                    <h4 class="text-dark">
                                        We will be in touch shortly
                                    </h4>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {},
        props: {
            invitation: {
                type: Object,
                required: true,
            },
            handset_list: {
                required: true,
            },
        },
        filters: {},
        computed: {},
        data() {
            return {
                utilities: {
                    disabled: false,
                    loading: false,
                    complete: false,
                    errors: null,
                },
                handsets: [],
            }
        },
        methods: {
            submit() {
                let self = this

                self.utilities.loading = true
                self.utilities.errors = null

                axios.post('/tenders/mobile/' + this.invitation.hash, {
                    'handsets': self.handsets,
                })
                    .then(function () {
                        self.utilities.loading = false
                        self.utilities.complete = true
                    })
                    .catch(function(errors){
                        self.utilities.errors = errors.response.data

                        self.utilities.loading = false
                    })
            },
            disableSubmit() {
                this.utilities.disabled = true
            },
        },
        mounted() {
            this.handsets = this.handset_list

            if (this.invitation.completed_at) {
                this.utilities.complete = true
            }
        },
    }
</script>

