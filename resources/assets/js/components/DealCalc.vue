<style scoped>
    .table {
        font-size: 12px !important;
    }

    /*@media (max-width: 1199px) {*/

    /*.no-padding-sm {*/
    /*padding: 0;*/
    /*}*/

    /*}*/
</style>

<template>
    <div id="deal-calculators">
        <div class="row" v-if="dealCalculators.length > 0">
            <div class="col-sm-12">
                <h4 class="text-dark">Deal Calculators</h4>
                <table class="table table-responsive border-top-info">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Created</th>
                        <th>Created By </th>
                        <th>GP</th>
                        <th class="text-right"></th>
                    </tr>
                    </thead>
                    <tbody v-for="calculator in dealCalculators">
                    <tr>
                        <td>
                            <i class="fa fa-star text-warning" v-if="calculator.primary"></i>
                            {{ calculator.name }}
                        </td>
                        <td>{{ calculator.created_at }}</td>
                        <td>{{ calculator.creator.name }}</td>
                        <td>{{ calculator.overview.totalProfit }}</td>
                        <td class="text-right">
                            <a href="#"
                               class="btn btn-xs btn-warning btn-icon"
                               v-on:click.prevent="setPrimary(calculator)"
                               v-if="!calculator.primary"
                            >
                                <i class="fa fa-fw fa-star"></i>
                                <span>Set Primary</span>
                            </a>

                            <a href="#"
                               class="btn btn-xs btn-danger btn-icon"
                               v-on:click.prevent="deleteDealCalc(calculator)"
                               v-if="!calculator.primary"
                            >
                                <i class="fa fa-fw fa-close"></i>
                                <span>Delete</span>
                            </a>

                            <a href="#"
                               class="btn btn-xs btn-white btn-icon"
                               v-on:click.prevent="editDealCalc(calculator)"
                            >
                                <i class="fa fa-fw fa-edit"></i>
                                <span>Edit</span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12">

                <a href="#" v-on:click.prevent="newCalc()" class="btn btn-success pull-left" v-if="editId">
                    <i class="fa fa-fw fa-save"></i>
                    New Deal Calculator
                </a>

                <a href="#" v-on:click.prevent="finished()" class="btn btn-success pull-right" v-if="status_id">
                    <i class="fa fa-fw fa-save"></i>
                    Finished
                </a>
            </div>
        </div>

        <hr>

        <form id="deal-calc-form" class="" v-on:submit.prevent="submitDealCalc">
            <div class="row">
                <div class="col-sm-12">
                    <label class="text-dark">Deal Calculator Name</label>
                    <input type="text" v-model="calculatorName" class="form-control" required>
                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-dark">Primary Connections</h4>
                    <table class="table table-responsive border-top-success">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Tariff</th>
                            <th>Contract Term</th>
                            <th>Connections</th>
                            <th>Discount</th>
                        </tr>
                        </thead>
                        <tbody v-for="connection in primaryConnections">

                        <tr>

                            <td class="v-mid m-w-100">
                                <select-box :options="connectionTypeOptions" v-model="connection.type"></select-box>

                                <label class="p-t-10">GP</label>

                                <input readonly type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.gp">
                            </td>
                            <td class="v-mid m-w-300">
                                <!--<input type="text" class="form-control no-padding-sm" v-model="connection.tariff_name">-->
                                <select-box :options="primaryTariffOptions" v-model="connection.tariff_id"></select-box>
                                <label class="p-t-10">Commission</label>
                                <input readonly type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.commission">
                            </td>
                            <td class="v-mid ">
                                <select-box :options="termOptions" v-model.number="connection.term"></select-box>

                                <label class="p-t-10">Cost</label>

                                <input type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.cost" readonly>
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" class="form-control no-padding-sm"
                                       v-model.number="connection.connections">

                                <label class="p-t-10">Total Cost</label>

                                <input readonly type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.total">
                            </td>

                            <td class="">
                                <input type="number" min="0" class="form-control no-padding-sm"
                                       v-model.number="connection.discount">
                                <!--v-bind:readonly="connection.readonly"-->

                                <br>
                                <br>
                                <br>

                                <a class="text-danger pull-right clickable"
                                   v-on:click="removeRow(primaryConnections, connection)">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <table class="table">
                                <tr>
                                    <th>
                                        Total Commission
                                    </th>
                                    <td class="col-sm-3">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="primaryConnectionTotal.commission">
                                    </td>
                                    <th>
                                        Total
                                    </th>
                                    <td class="col-sm-3">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="primaryConnectionTotal.total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right"
                               v-on:click="addConnection(primaryConnections, 1)">
                                <i class="fa fa-plus"></i>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-dark">Secondary Connections</h4>
                    <table class="table table-responsive border-top-warning">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Tariff</th>
                            <th>Contract Term</th>
                            <th>Connections</th>
                            <th></th>
                        </tr>

                        </thead>
                        <tbody v-for="connection in secondaryConnections">

                        <tr>

                            <td class="v-mid m-w-100">
                                <select-box :options="connectionTypeOptions" v-model="connection.type"></select-box>

                                <label class="p-t-10">GP</label>

                                <input readonly type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.gp">
                            </td>
                            <td class="v-mid m-w-300">
                                <!--<input type="text" class="form-control no-padding-sm" v-model="connection.tariff_name">-->
                                <select-box :options="secondaryTariffOptions"
                                            v-model="connection.tariff_id"></select-box>
                                <label class="p-t-10">Commission</label>
                                <input readonly type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.commission">
                            </td>
                            <td class="v-mid ">
                                <select-box :options="termOptions" v-model.number="connection.term"></select-box>

                                <label class="p-t-10">Cost</label>

                                <input type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.cost" readonly>
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" class="form-control no-padding-sm"
                                       v-model.number="connection.connections">

                                <label class="p-t-10">Total Cost</label>

                                <input readonly type="number" min="0" step="0.01" class="form-control no-padding-sm"
                                       v-model.number="connection.total">
                            </td>

                            <td class="v-mid">
                                <a class="text-danger pull-right clickable"
                                   v-on:click="removeRow(secondaryConnections, connection)">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>

                        </tbody>
                    </table>


                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-6">
                            <table class="table">
                                <tr>
                                    <th>
                                        Total Commission
                                    </th>
                                    <td class="col-sm-3">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="secondaryConnectionTotal.commission">
                                    </td>
                                    <th>
                                        Total
                                    </th>
                                    <td class="col-sm-3">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="secondaryConnectionTotal.total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right"
                               v-on:click="addConnection(secondaryConnections, 0)">
                                <i class="fa fa-plus"></i>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-dark">Customer Contributions</h4>
                    <table class="table border-top-danger">
                        <thead>
                        <tr>
                            <th>Tariff</th>
                            <th>Value</th>
                            <th>Units</th>
                            <th>Commission</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="contribution in contributions">
                            <td class="v-mid">

                                <input type="text" class="form-control" v-model="contribution.name"
                                       v-bind:readonly="contribution.readonly">
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="contribution.value">
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" class="form-control" v-model.number="contribution.units">
                            </td>
                            <td class="v-mid">
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="contribution.total">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-9">
                            <table class="table">
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <td class="col-sm-6">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="contributionsTotal.total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-dark">Handsets</h4>
                    <table class="table  border-top-info">
                        <thead>
                        <tr>
                            <th class="col-xs-3">Manufacturer & Model</th>
                            <th>Cost</th>
                            <th>Units</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="handset in handsets">
                            <td class="v-mid">
                                <select-box v-model="handset.handset_id" :options="devices"></select-box>
                            </td>

                            <td class="v-mid">
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="handset.value">
                            </td>

                            <td class="v-mid">
                                <input type="number" min="0" class="form-control" v-model.number="handset.units">
                            </td>

                            <td class="v-mid">
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="handset.total">
                            </td>

                            <td class="v-mid">
                                <a class="text-danger pull-right clickable"
                                   v-on:click="removeRow(handsets, handset)" v-if="!handset.readonly">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-9">
                            <table class="table">
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <td class="col-sm-6">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="handsetsTotal.total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right"
                               v-on:click="addHandsets">
                                <i class="fa fa-plus"></i>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-dark">Accessory Costs</h4>
                    <table class="table  border-top-purple">
                        <thead>
                        <tr>
                            <th>Manufacturer & Model</th>
                            <th>Value</th>
                            <th>Units</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="accessory in accessories">
                            <td class="v-mid">
                                <input type="text" class="form-control" v-model="accessory.name"
                                       v-bind:readonly="accessory.readonly">
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="accessory.value"
                                       v-bind:readonly="accessory.readonlyAll">
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" class="form-control" v-model.number="accessory.units"
                                       v-bind:readonly="accessory.readonlyAll">
                            </td>
                            <td class="v-mid">
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="accessory.total">
                            </td>

                            <td class="v-mid">
                                <a class="text-danger pull-right clickable"
                                   v-on:click="removeRow(accessories, accessory)" v-if="!accessory.readonly">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-9">
                            <table class="table">
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <td class="col-sm-6">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="accessoriesTotal.total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right"
                               v-on:click="addBasic(accessories)">
                                <i class="fa fa-plus"></i>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="text-dark">Credits & Buyout</h4>
                    <table class="table border-top-warning">
                        <thead>
                        <tr>
                            <th>Manufacturer & Model</th>
                            <th>Value</th>
                            <th>Units</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="credit in credits">
                            <td class="v-mid">

                                <input type="text" class="form-control" v-model="credit.name"
                                       v-bind:readonly="credit.readonly">
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="credit.value">
                            </td>
                            <td class="v-mid">
                                <input type="number" min="0" class="form-control" v-model.number="credit.units">
                            </td>
                            <td class="v-mid">
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="credit.total">
                            </td>

                            <td class="v-mid">
                                <a class="text-danger pull-right clickable"
                                   v-on:click="removeRow(credits, credit)" v-if="!credit.readonly">
                                    <i class="fa fa-close"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-9">
                            <table class="table">
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <td class="col-sm-6">
                                        <input readonly type="number" min="0" step="0.01" class="form-control"
                                               v-model.number="creditsTotal.total">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-success btn-icon btn-icon-standalone btn-icon-standalone-right m-b-0 pull-right"
                               v-on:click="addBasic(credits)">
                                <i class="fa fa-plus"></i>
                                <span>Add</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <h4 class="text-dark">Overview</h4>

            <div class="row">
                <div class="col-sm-6">
                    <table class="table border-top-success">
                        <tbody>
                        <tr>
                            <td class="text-dark text-bold">Months Free?</td>
                            <td>
                                <input type="number" min="0" max="6" class="form-control"
                                       v-model.number="overview.monthsFree">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Gross Line Rental</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.lineRental">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">BCAD Value</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.bcad">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Total Cashback</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.cashBack">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Total Monthly Discount</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.monthlyDiscount">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">NET MONTHLY LINE RENTAL</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.monthlyLineRental">
                            </td>
                        </tr>
                        <tr class="text-white text-bold discount-margin-row" v-bind:class="discountClass">
                            <td>Discount Margin (%)</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.discountMargin">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table border-top-success">
                        <tbody>
                        <tr>
                            <td class="text-dark text-bold">Discounted Monthly Cost to Customer</td>
                            <td>
                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.discountedMonthlyCost">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Total Income</td>
                            <td>

                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.income">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Total Cost</td>
                            <td>

                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.cost">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Handling Fees</td>
                            <td>

                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.handlingFee">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-dark text-bold">Total Gross Profit</td>
                            <td>

                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.totalProfit">
                            </td>
                        </tr>
                        <tr class="profit-margin-row">
                            <td>Profit Margin</td>
                            <td>

                                <input readonly type="number" min="0" step="0.01" class="form-control"
                                       v-model.number="overview.profitMargin">
                            </td>
                        </tr>
                        <tr class="text-white text-bold" v-bind:class="statusClass">
                            <td>Status</td>
                            <td>
                                <input readonly type="text" min="0" step="0.01" class="form-control"
                                       v-model.number="authorisedText ">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-right">

                    <modal v-if="showModal" @close="showModal = false">
                        <span slot="header">
                            Authorise Deal Calculator
                        </span>
                        <div slot="body">
                            <form @submit.prevent="authoriseDealCalc">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>Username</label>
                                            <input type="text" class="form-control" v-model="user.username">
                                        </div>

                                        <div class="col-sm-12">
                                            <label>Password</label>
                                            <input type="password" class="form-control" v-model="user.password">
                                        </div>

                                        <div class="col-sm-12" style="padding-top:15px;">
                                            <button type="submit" class="btn btn-success btn-icon btn-icon-standalone">
                                                <i class="fa fa-fw fa-upload"></i>
                                                <span>Authorise</span>
                                            </button>
                                        </div>

                                        <div class="col-sm-12 text-center" style="padding-top:15px;">
                                            <span v-text="authoriseError" class="text-danger"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </modal>


                    <button type="submit" class="btn btn-success m-t-5">
                        <i class="fa fa-fw fa-spinner fa-spin" v-if="loading"></i>
                        <i class="fa fa-fw fa-save" v-else></i>
                        Save
                    </button>

                    <!--<a class="btn btn-warning" @click.prevent="showModal = true" v-else>Request Authorisation</a>-->
                </div>
                <div id="error-block">
                    <div class="col-sm-12" v-if="errors">
                        <div class="alert alert-danger">
                            <p v-for="[error, index] in errors">
                                {{ error }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</template>

<script>
    import SelectBox from './SelectBox'
    import Modal from './Modal'
    import VueScrollTo from 'vue-scrollto'

    export default {
        components: {
            SelectBox,
        },
        props: {
            customer: Number,
            opportunity: Number,
            status_id: {
                type: Number,
                required: false,
            },
        },
        computed: {
            statusClass: function () {
                return {
                    danger: this.isNotAuthorised(),
                    success: this.isAuthorised(),
                }
            },
            discountClass: function () {
                return {
                    danger: this.discountFailed(),
                    success: this.discountPassed(),
                }
            },
            authorisedText: function () {
                return this.isNotAuthorised()
                    ? 'NOT AUTHORISED'
                    : 'AUTHORISED'
            },
            authorised: function () {
                return this.isAuthorised() || this.adminAuthorisation === 1
            },
            postData: function () {
                return {
                    'name': this.calculatorName,
                    'primary_connections': this.primaryConnections,
                    'secondary_connections': this.secondaryConnections,
                    'contributions': this.contributions,
                    'handsets': this.handsets,
                    'accessories': this.accessories,
                    'credits': this.credits,
                    'overview': this.overview,
                }
            },
        },
        data() {
            return {
                devices: [],
                calculatorName: '',
                editId: null,
                dealCalculators: [],
                loading: false,
                errors: false,
                showModal: false,
                authoriseError: '',
                user: {
                    username: '',
                    password: '',
                },
                adminAuthorisation: 0,
                primaryConnections: [],
                primaryConnectionTotal: {
                    'total': 0,
                    'commission': 0,
                },
                secondaryConnections: [],
                secondaryConnectionTotal: {
                    'total': 0,
                    'commission': 0,
                },
                contributionsTotal: {
                    'total': 0,
                },
                contributions: [
                    {
                        name: 'Customer Contribution',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                    {
                        name: 'Termination Credit',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                ],
                handsets: [],
                handsetsTotal: {
                    total: 0,
                },
                accessories: [
                    {
                        name: 'O2 SIM Card',
                        value: 10,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },

                    {
                        name: 'Delivery',
                        value: 20,
                        units: 1,
                        total: 0,
                        readonly: true,
                    },
                ],
                accessoriesTotal: {
                    total: 0,
                },
                credits: [
                    {
                        name: 'Buyout',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                    {
                        name: 'Hardware Fund',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                    {
                        name: 'Line Rental Cashback',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                ],
                creditsTotal: {
                    total: 0,
                },
                overview: {
                    monthsFree: 0,
                    lineRental: 0,
                    bcad: 0,
                    cashBack: 0,
                    monthlyDiscount: 0,
                    monthlyLineRental: 0,
                    discountMargin: 0,
                    discountedMonthlyCost: 0,
                    income: 0,
                    cost: 0,
                    handlingFee: 0,
                    totalProfit: 0,
                    profitMargin: 0,
                    status: 0,
                },
                primaryTariffOptions: [],
                secondaryTariffOptions: [],
                termOptions: [
                    {id: 24, text: '24 Months'},
                    {id: 36, text: '36 Months'},
                ],
                connectionTypeOptions: [
                    {id: 1, text: 'O2 New'},
                    {id: 2, text: 'O2 Upgrade'},
                    {id: 3, text: 'O2 Existing'},
                    {id: 4, text: 'O2 MBB'},
                    {id: 5, text: 'Vodafone New'},
                    {id: 6, text: 'Vodafone Upgrade'},
                ],
            }
        },
        watch: {
            primaryConnections: {
                handler: function (connections) {
                    this.calculateConnections(connections, this.primaryConnectionTotal, 'primary')
                },
                deep: true,
                immediate: true,
            },
            secondaryConnections: {
                handler: function (connections) {
                    this.calculateConnections(connections, this.secondaryConnectionTotal, 'secondary')
                },
                deep: true,
                immediate: true,
            },
            contributions: {
                handler: function (contributions) {
                    this.calculateBasic(contributions, this.contributionsTotal)
                },
                deep: true,
                immediate: true,
            },
            handsets: {
                handler: function (handsets) {
                    this.calculateHandsets(handsets, this.handsetsTotal)
                },
                deep: true,
                immediate: true,
            },
            accessories: {
                handler: function (accessories) {
                    this.calculateBasic(accessories, this.accessoriesTotal)
                },
                deep: true,
                immediate: true,
            },
            credits: {
                handler: function (credits) {
                    this.calculateBasic(credits, this.creditsTotal)
                },
                deep: true,
                immediate: true,
            },
            overview: {
                handler: function () {
                    this.calculateOverview()

                    this.calculateConnections(this.primaryConnections, this.primaryConnectionTotal, 'primary')

                    this.calculateConnections(this.secondaryConnections, this.secondaryConnectionTotal, 'secondary')

                    this.calculateBasic(this.accessories, this.accessoriesTotal)
                },
                deep: true,
                immediate: true,
            },
        },
        methods: {
            newCalc() {
                this.resetForm()
            },
            deleteDealCalc(calc) {
                let self = this
                let url = '/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/deal-calculator/' + calc.id + '/delete'

                swal({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this once deleted.',
                        type: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#8dc63f',
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel',
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            axios.post(url)
                                .then(function (response) {
                                    let i = self.dealCalculators.map(item => item.id).indexOf(calc.id)

                                    self.dealCalculators.splice(i, 1)
                                })
                        }
                    })
            },
            setPrimary(calc) {
                let self = this
                let url = '/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/deal-calculator/' + calc.id + '/set-active'

                axios.get(url)
                    .then(function (response) {
                        _.forEach(self.dealCalculators, function (c) {
                            c.primary = 0
                        })

                        calc.primary = 1

                    })
            },
            resetForm() {
                this.calculatorName = ''

                this.primaryConnections = []

                this.primaryConnectionTotal = {
                    'total': 0,
                    'commission': 0,
                }

                this.secondaryConnections = []

                this.secondaryConnectionTotal = {
                    'total': 0,
                    'commission': 0,
                }

                this.contributionsTotal = {
                    'total': 0,
                }

                this.contributions = [
                    {
                        name: 'Customer Contribution',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                    {
                        name: 'Termination Credit',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                ]

                this.handsets = []

                this.handsetsTotal = {
                    total: 0,
                }

                this.accessories = [
                    {
                        name: 'O2 SIM Card',
                        value: 10,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },

                    {
                        name: 'Delivery',
                        value: 20,
                        units: 1,
                        total: 0,
                        readonly: true,
                    },
                ]

                this.accessoriesTotal = {
                    total: 0,
                }

                this.credits = [
                    {
                        name: 'Buyout',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                    {
                        name: 'Hardware Fund',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                    {
                        name: 'Line Rental Cashback',
                        value: 0,
                        units: 0,
                        total: 0,
                        readonly: true,
                    },
                ]

                this.creditsTotal = {
                    total: 0,
                }

                this.overview = {
                    monthsFree: 0,
                    lineRental: 0,
                    bcad: 0,
                    cashBack: 0,
                    monthlyDiscount: 0,
                    monthlyLineRental: 0,
                    discountMargin: 0,
                    discountedMonthlyCost: 0,
                    income: 0,
                    cost: 0,
                    handlingFee: 0,
                    totalProfit: 0,
                    profitMargin: 0,
                    status: 0,
                }

                this.editId = null
            },
            editDealCalc(calc) {
                window.onbeforeunload = function () {
                    return 'Have you saved everything?'
                }

                this.resetForm()

                this.calculatorName = calc.name

                this.primaryConnections = calc.primary_connections

                this.secondaryConnections = calc.secondary_connections

                this.contributions = calc.contributions.length > 0
                    ? calc.contributions
                    : [
                        {
                            name: 'Customer Contribution',
                            value: 0,
                            units: 0,
                            total: 0,
                            readonly: true,
                        },
                        {
                            name: 'Termination Credit',
                            value: 0,
                            units: 0,
                            total: 0,
                            readonly: true,
                        },
                    ]

                this.handsets = calc.handsets

                this.accessories = calc.accessories

                this.credits = calc.credits.length > 0
                    ? calc.credits
                    : [
                        {
                            name: 'Buyout',
                            value: 0,
                            units: 0,
                            total: 0,
                            readonly: true,
                        },
                        {
                            name: 'Hardware Fund',
                            value: 0,
                            units: 0,
                            total: 0,
                            readonly: true,
                        },
                        {
                            name: 'Line Rental Cashback',
                            value: 0,
                            units: 0,
                            total: 0,
                            readonly: true,
                        },
                    ]

                this.overview = calc.overview

                this.editId = calc.id
            },
            removeRow(type, row) {
                let index = type.indexOf(row)

                type.splice(index, 1)
            },
            addConnection(type, primary) {
                window.onbeforeunload = function () {
                    return 'Have you saved everything?'
                }

                type.push({
                    tariff_id: null,
                    tariff_name: '',
                    term: 36,
                    connections: 1,
                    cost: 0,
                    gp: 0,
                    commission: 0,
                    total: 0,
                    modifier: 0.5,
                    type: 1,
                    primary: primary,
                    discount: 0,
                    readonly: true,
                    maxDiscount: 0,
                    baseCost: 0,
                    tariffType: 0,
                })
            },
            updateModifier(connection) {
                if (connection.type == 1) {
                    connection.modifier = 0.5
                } else if (connection.type == 2) {
                    connection.modifier = 0.46
                } else if (connection.type == 3) {
                    connection.modifier = 0.43
                } else if (connection.type == 4) {
                    connection.modifier = 0
                } else if (connection.type == 5) {
                    connection.modifier = 0.4
                } else if (connection.type == 6) {
                    connection.modifier = 0.4
                }
            },
            calculateConnections(connections, totals, type) {
                let self = this

                _.each(connections, function (connection) {

                    if (connection.discount > connection.maxDiscount) {
                        connection.discount = connection.maxDiscount
                    }

                    let calculatedTerm = type === 'primary'
                        ? _.subtract(connection.term, self.overview.monthsFree)
                        : connection.term

                    connection.gp = _.round(_.multiply(_.multiply(calculatedTerm, connection.cost), connection.modifier), 2)

                    connection.commission = _.round(_.multiply(connection.gp, connection.connections), 2)

                    connection.tariff_id > 0 && axios.get('/api/mobile/opportunities/deal-calc/get-tariff/' + connection.tariff_id)
                        .then(function (response) {
                            connection.tariffType = response.data.tariff_type_id

                            connection.baseCost = response.data.price

                            connection.maxDiscount = response.data.max_discount

                            connection.cost = _.round(_.multiply(connection.baseCost, _.divide(_.subtract(100, connection.discount), 100)), 2)
                        })

                    connection.total = _.round(_.multiply(connection.cost, connection.connections), 2)

                    self.updateModifier(connection)
                })

                totals.total = _.round(_.sumBy(connections, 'total'), 2)
                totals.commission = _.round(_.sumBy(connections, 'commission'), 2)

                this.calculateOverview()
            },
            addHandsets: function (type) {
                window.onbeforeunload = function () {
                    return 'Have you saved everything?'
                }

                this.handsets.push({
                    handset_id: 0,
                    value: 0,
                    units: 0,
                    total: 0,
                    readonly: false,
                    readonlyAll: false,
                })
            },
            addBasic: function (type) {

                window.onbeforeunload = function () {
                    return 'Have you saved everything?'
                }

                type.push({
                    name: '',
                    value: 0,
                    units: 0,
                    total: 0,
                    readonly: false,
                    readonlyAll: false,
                })
            },
            calculateHandsets(data, totals, calcOverview = true) {
                _.each(data, function (item) {
                    if (item.handset_id > 0) {
                        axios.get('/api/mobile/handsets/' + item.handset_id)
                            .then(function (response) {
                                item.value = response.data.price
                            })
                    }
                })

                this.calculateBasic(data, totals, calcOverview)
            },
            calculateBasic(data, totals, calcOverview = true) {
                if (data.length > 0) {
                    _.each(data, function (row) {
                        if (
                            row.name === 'Line Rental Cashback' ||
                            row.name === 'Hardware Fund' ||
                            row.name === 'Buyout' ||
                            row.name === 'O2 SIM Card' ||
                            row.name === 'Delivery' ||
                            row.name === 'Unlock Fee' ||
                            row.name === 'Customer Contribution' ||
                            row.name === 'Termination Credit'
                        ) {
                            row.readonly = true

                            if (
                                row.name === 'Unlock Fee' ||
                                row.name === 'O2 SIM Card' ||
                                row.name === 'Delivery'
                            ) {
                                row.readonlyAll = true
                            }
                        }

                        row.total = _.round(_.multiply(row.value, row.units), 2)
                    })

                    totals.total = _.round(_.sumBy(data, 'total'), 2)
                    totals.commission = _.round(_.sumBy(data, 'commission'), 2)
                }

                if (calcOverview) {
                    this.calculateOverview()
                }
            },
            calculateUnlockFee() {
                let sims = this.accessories[this.accessories.map(item => item.name).indexOf('O2 SIM Card')].units

                let handsets = _.sum(this.handsets.map(item => parseInt(item.units)))

                let remainingSims = sims - handsets

                remainingSims > 0
                    ? this.addUnlockFee(remainingSims)
                    : this.removeUnlockFee()
            },
            removeUnlockFee() {
                let index = this.accessories.map(item => item.name).indexOf('Unlock Fee')

                if (index > 0) {
                    this.accessories.splice(index, 1)
                }
            },
            addUnlockFee(sims) {
                let unlockIndex = this.accessories.map(item => item.name).indexOf('Unlock Fee')

                if (unlockIndex > 0) {
                    let unlockUnits = this.accessories[unlockIndex].units

                    if (sims !== unlockUnits) {
                        this.accessories[unlockIndex] = {
                            name: 'Unlock Fee',
                            value: 80,
                            units: sims,
                            total: _.multiply(80, sims),
                            readonly: true,
                            readonlyAll: false,
                        }
                    }
                } else {
                    if (sims > 0) {
                        this.accessories.push({
                            name: 'Unlock Fee',
                            value: 80,
                            units: sims,
                            total: _.multiply(80, sims),
                            readonly: false,
                            readonlyAll: false,
                        })
                    }
                }


                this.calculateBasic(this.accessories, this.accessoriesTotal, false)
            },
            addSim(connection) {
                let simsIndex = this.accessories.map(item => item.name).indexOf('O2 SIM Card')

                if (connection.tariffType === 1 || connection.tariffType === 2) {
                    let currentSims = this.accessories[simsIndex].units

                    let totalSims = _.add(currentSims, parseInt(connection.connections))

                    this.accessories[simsIndex] = {
                        name: 'O2 SIM Card',
                        value: 10,
                        units: totalSims,
                        total: _.multiply(80, totalSims),
                        readonly: true,
                        readonlyAll: true,
                    }
                }
            },
            calculateSims() {
                let self = this

                let simsIndex = self.accessories.map(item => item.name).indexOf('O2 SIM Card')

                self.accessories[simsIndex] = {
                    name: 'O2 SIM Card',
                    value: 10,
                    units: 0,
                    total: 0,
                    readonly: true,
                    readonlyAll: true,
                }

                _.each(self.primaryConnections, function (connection) {
                    self.addSim(connection)
                })

                _.each(self.secondaryConnections, function (connection) {
                    self.addSim(connection)
                })

                this.calculateBasic(this.accessories, this.accessoriesTotal, false)
            },
            calculateOverview() {
                let self = this

                this.calculateSims()

                this.calculateUnlockFee()

                if (this.overview.monthsFree > 6) {
                    this.overview.monthsFree = 6
                }

                let lrcIndex = this.credits.map(item => item.name).indexOf('Line Rental Cashback')

                this.overview.lineRental = _.round(_.sum([this.primaryConnectionTotal.total, this.secondaryConnectionTotal.total]), 2)
                this.overview.bcad = _.round(_.multiply(this.primaryConnectionTotal.total, this.overview.monthsFree), 2)
                this.overview.cashBack = _.round(this.credits[lrcIndex].total, 2)
                this.overview.monthlyDiscount = _.round(_.round(_.divide(_.sum([this.overview.bcad, this.overview.cashBack]), 12), 2), 2)
                this.overview.monthlyLineRental = _.round(_.round(_.subtract(this.overview.lineRental, this.overview.monthlyDiscount), 2), 2)
                this.overview.discountMargin = this.overview.lineRental > 0 ? _.round(_.multiply(_.divide(this.overview.monthlyDiscount / this.overview.lineRental), 100), 2) : 0
                this.overview.discountedMonthlyCost = _.round(_.divide(_.subtract(_.multiply(this.overview.lineRental, 12), _.sum([this.overview.bcad, this.overview.cashBack])), 12), 2)
                this.overview.income = _.round(_.sum([this.primaryConnectionTotal.commission, this.secondaryConnectionTotal.commission, this.contributionsTotal.total]), 2)
                this.overview.cost = _.round(_.sum([this.handsetsTotal.total, this.accessoriesTotal.total, this.creditsTotal.total]), 2)
                this.overview.handlingFee = _.round(_.multiply(_.subtract(this.overview.income, this.overview.cost), 0.15), 2)
                this.overview.totalProfit = _.round(_.subtract(_.subtract(this.overview.income, this.overview.cost), this.overview.handlingFee), 2)
                this.overview.profitMargin = this.overview.income > 0 ? _.round(_.multiply(_.round(_.divide(this.overview.totalProfit, this.overview.income), 2), 100), 2) : 0

                if (this.overview.profitMargin >= 30 && this.overview.discountMargin <= 70) {
                    this.overview.status = 1
                } else {
                    this.overview.status = 0
                }
            },
            isNotAuthorised() {
                return this.overview.status === 0
            },
            isAuthorised() {
                return this.overview.status === 1
            },
            discountPassed() {
                return this.overview.discountMargin <= 70
            },
            discountFailed() {
                return this.overview.discountMargin > 70
            },

            authoriseDealCalc() {
                let self = this

                axios.post('/api/mobile/opportunities/deal-calc/authorise', this.user)
                    .then(function (response) {
                        if (response.data.success) {
                            self.setAuthorised()

                            self.showModal = false

                            return self.submitDealCalc()
                        }

                        self.authoriseError = 'Invalid login'
                    })
            },

            setAuthorised() {
                this.adminAuthorisation = 1
            },

            dealCalcUrl() {
                return this.editId
                    ? '/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/deal-calculator/' + this.editId
                    : '/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/deal-calculator/create'
            },

            submitDealCalc() {
                self = this
                self.errors = null
                self.loading = true

                axios.post(self.dealCalcUrl(), self.postData)
                    .then(function (response) {
                        let editId = self.editId

                        let swalTitle = 'Deal Calculator Created!'

                        if (editId) {
                            let i = self.dealCalculators.map(item => item.id).indexOf(editId)

                            self.dealCalculators[i] = response.data

                            swalTitle = 'Deal Calculator Updated!'
                        } else {
                            self.dealCalculators.push(response.data)
                        }

                        swal({
                            title: swalTitle,
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        })

                        self.resetForm()

                        self.$scrollTo('#deal-calculators')

                        self.loading = false

                        let primary = self.dealCalculators.map(item => item.id).indexOf(response.data.id)

                        self.setPrimary(self.dealCalculators[primary])
                    })
                    .catch(function (errors) {
                        self.loading = false

                        self.errors = errors.data

                        self.$scrollTo('#error-block')
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
                                'mobile_opportunity_status_id': 7,
                            }

                            axios.post('/customers/' + self.customer + '/mobile/opportunities/' + self.opportunity, data)
                                .then(function (response) {

                                    window.onbeforeunload = function () {
                                        return null
                                    }

                                    location.reload()
                                })
                        }
                    })

            },
        },
        created() {
            let self = this

            axios.get('/api/mobile/opportunities/deal-calc/get-tariffs/primary')
                .then(function (response) {
                    self.primaryTariffOptions = response.data
                })

            axios.get('/api/mobile/opportunities/deal-calc/get-tariffs/secondary')
                .then(function (response) {
                    self.secondaryTariffOptions = response.data
                })

            axios.get('/customers/' + this.customer + '/mobile/opportunities/' + this.opportunity + '/deal-calculator')
                .then(function (response) {
                    self.dealCalculators = response.data
                })

            axios.get('/api/mobile/handsets')
                .then(function (response) {
                    _.each(response.data, function (phone) {
                        self.devices.push(phone)
                    })
                })
        },
    }
</script>

