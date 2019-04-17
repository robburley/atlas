<style lang="scss">
    .dragArea {
        background: #eee;
        min-height: 32px;
        display: block;
    }

    .m-h-50 {
        min-height: 50px;
    }

    .m-h-80 {
        min-height: 80px;
    }

    @media (max-width: 991px) {
        .sticky-menu {
            top: unset !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 100% !important;
            z-index: 9999999 !important;
            background: white !important;
            h2 {
                font-size: 0.9em;
                margin-top: 5px;
                margin-bottom: 5px;
            }
            hr {
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .btn {
                font-size: 0.9em;
                margin-bottom: 5px;
                padding: 3px 12px;
            }
        }
    }

    .affix {
        right: 30px;
        padding-left: 30px;
        padding-right: 30px;
    }
</style>

<template>
    <div>
        <div class="row">
            <div class="col-md-8" id="allocations">
                <h2 class="text-dark">
                    <i class="fa fa-arrows-h"></i>
                    Allocations
                </h2>

                <hr>

                <div v-for="line, index in data.lines">
                    <div class="row">
                        <div class="col-sm-3">
                            Tariff <span class="text-danger">*</span><br>
                            <h4 class="text-dark">{{ line.tariff }}</h4>
                        </div>
                        <div class="col-sm-3">
                            Name <span class="text-danger">*</span>
                            <input type="text" class="form-control" v-model="line.name"/>
                        </div>
                        <div class="col-sm-3">
                            Phone Number
                            <input type="text" class="form-control" v-model="line.phone_number"/>
                        </div>
                        <div class="col-sm-3">
                            Handset

                            <draggable
                                    class="dragArea"
                                    v-model="line.handset"
                                    :options="{group: { name: 'handsets', put: (line.handset.length === 0)}}"
                            >
                                <div v-for="handset in line.handset">
                                    <div class="div btn btn-info btn-block m-b-0" style="overflow: hidden;">
                                        {{ handset.name }}
                                    </div>
                                </div>
                            </draggable>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-sm-3">
                        </div>
                        <div class="col-sm-3">
                            <div v-if="line.handset.length > 0">
                                <span class="p-b-10">
                                    Handset Colour <span class="text-danger">*</span>
                                </span>

                                <input type="text"
                                       class="form-control"
                                       v-model="line.colour"
                                       :required="line.handset.length > 0"
                                />
                            </div>

                            <span class="p-b-10">
                                Type <span class="text-danger">*</span>
                            </span>

                            <select v-model="line.type" class="form-control">
                                <option v-for="option in utilities.connections" v-bind:value="option.id">
                                    {{ option.text }}
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            Network To <span class="text-danger">*</span>


                            <select v-model="line.networkTo" class="form-control">
                                <option v-for="option in utilities.networks" v-bind:value="option.id">
                                    {{ option.text }}
                                </option>
                            </select>

                            <div v-if="line.type == 'Port'">
                                Network From <span class="text-danger">*</span>

                                <select v-model="line.networkFrom" class="form-control">
                                    <option v-for="option in utilities.networks" v-bind:value="option.id">
                                        {{ option.text }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            VAS

                            <draggable
                                    class="dragArea m-h-80"
                                    v-model="line.vas"
                                    :options="{group: {name: 'vas'}}"
                            >
                                <div v-for="item in line.vas">
                                    <div class="div btn btn-info btn-block m-b-0">
                                        {{ item.name }}
                                    </div>
                                </div>
                            </draggable>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <affix class="col-md-4 sticky-menu" relative-element-selector="#allocations" :enabled="windowWidth > 991">
                <div>
                    <h2 class="text-dark">
                        <i class="fa fa-phone text-purple"></i>
                        Handsets <br>
                    </h2>

                    <hr>

                    <p class="text-center p-b-10 hidden-xs hidden-sm"> Drag and drop handsets</p>

                    <draggable v-model="data.handsets" class="dragArea m-h-50" :options="{group:'handsets'}">
                        <div v-for="handset in data.handsets">
                            <div class="div btn btn-info btn-block">
                                {{ handset.name }}
                            </div>
                        </div>
                    </draggable>

                    <h2 class="text-dark">
                        <i class="fa fa-plus-circle text-purple"></i>

                        VAS <br>
                    </h2>

                    <hr>

                    <p class="text-center p-b-10 hidden-xs hidden-sm"> Drag and drop VAS</p>

                    <draggable v-model="data.vas" class="dragArea m-h-50" :options="{group:'vas'}">
                        <div v-for="item in data.vas">
                            <div class="div btn btn-info btn-block">
                                {{ item.name }}
                            </div>
                        </div>
                    </draggable>
                </div>
            </affix>
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

        <div class="row">
            <div class="col-xs-12 text-right">
                <a class="btn btn-info" :disabled="data.handsets.length > 0 && data.vas.length > 0" @click="save">
                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-save" v-else></i>

                    <span>Save</span>
                </a>

                <a class="btn btn-success"
                   :disabled="utilities.allocations.length == 0"
                   @click="finish"
                   v-if="!hide_finished"
                >
                    <span>Finished</span>

                    <i class="fa fa-fw fa-spinner fa-spin" v-if="utilities.loading"></i>
                    <i class="fa fa-fw fa-forward" v-else></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable,
        },
        props: {
            customer: Number,
            opportunity: Number,
            deal_calculator: Object,
            allocations: Array,
            hide_finished: Boolean,
        },
        filters: {},
        computed: {},
        data() {
            return {
                windowWidth: 0,
                data: {
                    lines: [],
                    vas: [],
                    handsets: [],
                },
                utilities: {
                    allocations: [],
                    connections: [
                        {
                            id: 'New connection',
                            text: 'New connection',
                        },
                        {
                            id: 'Port',
                            text: 'Port',
                        },
                    ],
                    networks: [],
                    loading: false,
                    errors: false,
                },
            }
        },
        methods: {
            getWindowWidth(event) {
                this.windowWidth = document.documentElement.clientWidth
            },
            save(load = true) {
                let self = this

                self.utilities.loading = true

                axios.post('/api/mobile/allocation/' + this.opportunity, {
                    allocation: this.data.lines,
                })
                    .then(function (response) {
                        if (load) {
                            self.utilities.loading = false
                        }

                        self.utilities.errors = null

                        self.utilities.allocations = response.data
                    })
                    .catch(function (errors) {
                        self.utilities.loading = false

                        self.utilities.errors = errors.response.data

                        self.$scrollTo('#error-block')
                    })
            },
            finish() {
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
                            self.save(false)

                            axios.post('/customers/' + self.customer + '/mobile/opportunities/' + self.opportunity, {
                                'allocated': true,
                            })
                                .then(function (response) {
                                    location.reload()
                                })
                        }
                    })

            },
        },
        mounted() {
            this.$nextTick(function () {
                window.addEventListener('resize', this.getWindowWidth)

                this.getWindowWidth()

                let self = this

                self.utilities.allocations = this.allocations

                axios.get('/api/tariff-match/networks')
                    .then(function (response) {
                        self.utilities.networks = response.data
                    })

                _.each(this.deal_calculator.handsets, function (handset) {
                    for (let i = 0; i < handset.units; i++) {
                        self.data.handsets.push({
                            id: handset.handset_id,
                            name: handset.handset.manufacturer + ' ' + handset.handset.model,
                        })
                    }
                })

                _.each(this.deal_calculator.connections, function (connection) {
                    if (connection.tariff.tariff_type_id > 2) {
                        for (let i = 0; i < connection.connections; i++) {
                            self.data.vas.push({
                                id: connection.tariff_id,
                                name: connection.tariff.type.name + ' ' + connection.tariff.tariff_code,
                            })
                        }
                    }
                })

                if (this.allocations.length === 0) {
                    _.each(this.deal_calculator.connections, function (connection) {
                        if (connection.tariff.tariff_type_id <= 2) {
                            for (let i = 0; i < connection.connections; i++) {
                                self.data.lines.push({
                                    tariff_id: connection.tariff_id,
                                    tariff: connection.tariff.type.name + ' ' + connection.tariff.tariff_code,
                                    name: '',
                                    colour: '',
                                    phone_number: '',
                                    type: 'Port',
                                    networkFrom: '',
                                    networkTo: 'O2',
                                    handset: [],
                                    vas: [],
                                })
                            }
                        }
                    })
                } else {
                    _.each(this.allocations, function (line) {
                        let vas = line.vas.map(function (item) {
                            return {
                                id: item.tariff_id,
                                name: item.tariff_name,
                            }
                        })

                        self.data.lines.push({
                            tariff_id: line.tariff_id,
                            tariff: line.tariff_name,
                            name: line.name,
                            colour: line.colour,
                            phone_number: line.phone_number,
                            type: line.type,
                            networkFrom: line.network_from,
                            networkTo: line.network_to,
                            handset: line.handset_id > 0
                                ? [
                                    {
                                        id: line.handset_id,
                                        name: line.handset_name,
                                    },
                                ]
                                : [],
                            vas: vas,
                        })

                        let index = self.data.handsets.map(item => item.id).indexOf(line.handset_id)

                        self.data.handsets.splice(index, 1)

                        _.each(vas, function (line) {
                            let index = self.data.vas.map(item => item.id).indexOf(line.tariff_id)

                            self.data.vas.splice(index, 1)
                        })
                    })
                }
            })
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.getWindowWidth)
        },
    }
</script>

