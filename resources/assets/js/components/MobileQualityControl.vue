<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        display: none;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cc3f44;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #8DC640;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #8DC640;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 24px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<template>
    <div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h4 class="text-dark text-center">
                    Please review each section of the opportunity
                </h4>

                <hr>

                <div class="row">
                    <div class="col-xs-2 text-right">
                        <h2 class="text-purple">
                            <i class="fa fa-fw fa-user"></i>
                        </h2>
                    </div>

                    <div class="col-xs-8">
                        <h4 class="text-dark p-t-5">
                            Customer Information <small v-if="!data.Information.complete">Penalty <input type="checkbox" v-model="data.Information.penalty"></small><br>
                        </h4>

                        <p class="m-t-0">
                            Has the agent filled in all customer information to an acceptable standard?</p>


                        <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <textarea rows="4"
                                          class="m-t-25 form-control"
                                          v-model="data.Information.description"
                                          v-if="!data.Information.complete"
                                ></textarea>
                        </transition>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-block p-t-25">
                            <label class="switch">
                                <input type="checkbox" v-model="data.Information.complete">

                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-2 text-right">
                        <h2 class="text-blue">
                            <i class="fa fa-fw fa-mobile-phone"></i>
                        </h2>
                    </div>

                    <div class="col-xs-8">
                        <h4 class="text-dark p-t-5">
                            Allocations <small v-if="!data.Allocations.complete">Penalty <input type="checkbox" v-model="data.Allocations.penalty"></small><br>
                        </h4>

                        <p class="m-t-0">Are all of the allocations correct?</p>

                        <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <textarea rows="4"
                                          class="m-t-25 form-control"
                                          v-model="data.Allocations.description"
                                          v-if="!data.Allocations.complete"
                                ></textarea>
                        </transition>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-block p-t-25">
                            <label class="switch">
                                <input type="checkbox" v-model="data.Allocations.complete">

                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-xs-2 text-right">
                        <h2 class="text-info">
                            <i class="fa fa-fw fa-file-text"></i>
                        </h2>
                    </div>

                    <div class="col-xs-8">
                        <h4 class="text-dark p-t-5">
                            Deal and Purchase order <small v-if="!data.Deal.complete">Penalty <input type="checkbox" v-model="data.Deal.penalty"></small><br>
                        </h4>

                        <p class="m-t-0">Is the deal valid and has the purchase order been signed correctly?</p>


                        <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <textarea rows="4"
                                          class="m-t-25 form-control"
                                          v-model="data.Deal.description"
                                          v-if="!data.Deal.complete"
                                ></textarea>
                        </transition>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-block p-t-25">
                            <label class="switch">
                                <input type="checkbox" v-model="data.Deal.complete">

                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
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
                <a class="btn btn-success" @click="update()" :disabled="utilities.loading">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-save" v-else></i>
                    Update
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {},
        props: {
            opportunity: Number,
            user: Number,
        },
        filters: {},
        computed: {},
        data() {
            return {
                data: {
                    Information: {
                        complete: false,
                        description: '',
                        penalty: true,
                    },
                    Allocations: {
                        complete: false,
                        description: '',
                        penalty: true,
                    },
                    Deal: {
                        complete: false,
                        description: '',
                        penalty: true,
                    },
                },
                utilities: {
                    loading: false,
                    errors: false,
                },
            }
        },
        methods: {
            update() {
                let self = this

                self.utilities.loading = true

                self.utilities.errors = null

                axios.post('/api/mobile/quality-control/' + this.opportunity, {
                    data: this.data,
                    user: this.user,
                })
                    .then(function (response) {
                        self.utilities.errors = null

                        location.reload()
                    })
                    .catch(function (errors) {
                        self.utilities.loading = false

                        self.utilities.errors = errors.response.data

                        self.$scrollTo('#error-block')
                    })
            },
        },
        mounted() {
        },
    }
</script>

