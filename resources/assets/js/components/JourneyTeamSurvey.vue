<style lang="scss" scoped>
    .vue-accordion {
        width: 100%;
        overflow: hidden;
        ul {
            width: 100%;
            height: 100%;
            display: table;
            table-layout: fixed;
            margin: 0;
            padding: 0;
            &:hover li {
                width: 15%;
                &.active {
                    width: 15%;
                }
                &.active-success {
                    width: 15%;
                }
                &:hover {
                    width: 60%;

                    &.active, &.active-success {
                        width: 45%;
                    }
                    .accordion-icon {
                        display: none;
                    }
                    a {
                        background: rgba(0, 0, 0, 0.4);
                        display: block;
                        * {
                            opacity: 1;
                            -webkit-transform: translateX(0);
                            transform: translateX(0);
                        }
                    }
                }
            }
            li {
                display: table-cell;
                vertical-align: bottom;
                position: relative;
                width: 50%;
                transition: all 500ms ease;
                height: 100%;
                background-color: #7938bc;
                border-right: 1px solid #fff;

                .accordion-icon {
                    font-size: 20px !important;
                    @media (max-width: 767px) {
                        font-size: 12px !important;
                    }
                    .fa {
                        @media (max-width: 767px) {
                            font-size: 16px !important;
                            margin-bottom: 2px;
                        }
                        margin-bottom: 3px;
                    }
                }

                &.active {
                    width: 150%;
                    a {
                        background: #40bbea !important;
                        display: block;
                        * {
                            opacity: 1;
                            -webkit-transform: translateX(0);
                            transform: translateX(0);
                        }
                    }
                    .accordion-icon {
                        display: none;
                    }
                }
                &.success {
                    background: #8DC63F !important;
                }
                &.active-success {
                    width: 150%;
                    a {
                        background: darken(#8DC63F, 20%) !important;
                        display: block;
                        * {
                            opacity: 1;
                            -webkit-transform: translateX(0);
                            transform: translateX(0);
                        }
                    }
                    .accordion-icon {
                        display: none;
                    }
                }
                a {
                    display: none;
                    width: 100%;
                    position: relative;
                    z-index: 3;
                    vertical-align: bottom;
                    padding: 15px 20px;
                    box-sizing: border-box;
                    color: #fff;
                    text-decoration: none;
                    transition: all 200ms ease;
                    height: 100%;
                    * {
                        opacity: 0;
                        margin: 0;
                        width: 100%;
                        text-overflow: ellipsis;
                        position: relative;
                        z-index: 5;
                        white-space: nowrap;
                        overflow: hidden;
                        -webkit-transform: translateX(-20px);
                        transform: translateX(-20px);
                        -webkit-transition: all 400ms ease;
                        transition: all 400ms ease;
                    }
                    h2 {
                        font-size: 18px !important;
                        text-overflow: clip;
                        text-transform: uppercase;
                        margin-bottom: 2px;
                        @media (max-width: 767px) {
                            font-size: 12px !important;
                        }
                    }
                }
            }
        }
    }

    .panel-header {
        margin-top: -20px;
        margin-left: -30px;
        margin-right: -30px;
    }

    .sections {
        padding-top: 40px;
    }

    .controls {
        padding-top: 40px;
    }
</style>

<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default border-top-success">
                <div class="panel-header">
                    <div class="vue-accordion">
                        <ul>
                            <li v-for="section in sections" :class="getNavClass(section)">
                                <a href="#" v-on:click.prevent="setCurrentSection(section)">
                                    <h2>{{ section.title }}</h2>
                                </a>
                                <h2 class="accordion-icon text-center text-white">
                                    <i class="fa" :class="section.icon"></i>
                                </h2>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal">
                        <div class="row sections">
                            <input type="hidden" v-model="answers.user_id">

                            <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <div v-show="currentSection.div == 'mobile-questions'">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are there any issues or queries that need addressing, or is everything going well?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                            v-model.number="answers.mobile_issues">
                                                        <option value="1">Yes, Everything is going well</option>
                                                        <option value="0">No, there are issues</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                        <div class="row" v-show="answers.mobile_issues == 0">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">
                                                        Ok well lets go through them straight away so I can note everything down, and process an immediate internal escalation for the issues to be resolved with the highest priority
                                                    </label>
                                                    <div class="col-sm-8">
                                                        <textarea type="text" class="form-control"
                                                                  v-model="answers.mobile_issues_details">
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </transition>

                            <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <div v-show="currentSection.div == 'fixed-line-questions'">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    May I ask who your current supplier is for your landline and broadband?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.fixed_line_current_supplier">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How long is left on the current contract?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.fixed_line_current_contract_remaining">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How much is your average monthly bill?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.fixed_line_average_monthly_bill">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are there any issues at all with your current service and supplier?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.fixed_line_issues">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are you happy for us to carry out a review for you to see how the rates you’re currently getting compare with today’s market?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                            v-model.number="answers.fixed_line_review">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bill</label>
                                                <div class="col-sm-8">
                                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                                        <div v-if="!answers.fixed_line_bill">
                                                            <dropzone id="fixedLineDropzone"
                                                                      v-on:vdropzone-file-added="fileAdded('fixed_line_bill_set', 'fixed_line_bill_requirements', $event)"
                                                                      v-on:vdropzone-success="fileSaved"
                                                                      url="#"
                                                                      :useFontAwesome="true"
                                                                      :maxNumberOfFiles="1"
                                                                      :autoProcessQueue="false"
                                                                      ref="fixedLineBill"
                                                                      paramName="fixed_line_bill"
                                                                      :showRemoveLink="false"
                                                                      :click="fixed_line_bill_requirements = false"
                                                            >
                                                                <input type="hidden" name="user_id"
                                                                       v-model="answers.user_id">
                                                            </dropzone>

                                                            <hr>
                                                            <div v-if="!answers.fixed_line_bill_requirements">
                                                                or
                                                                <a href="#"
                                                                   class="btn btn-warning"
                                                                   v-on:click.prevent="requirementsAdded('fixed_line_bill_requirements', 'fixed_line_bill_set')"
                                                                   v-on:click="removeFiles('fixedLineBill')"
                                                                >
                                                                    Requirements
                                                                </a>
                                                            </div>
                                                            <div v-else>
                                                                <p>Requirements Selected</p>
                                                            </div>
                                                        </div>

                                                        <div v-else>
                                                            <a :href="'/journey-team-survey-files/' + fixedLineBill"
                                                               class="btn btn-info">Download</a>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition>

                            <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <div v-show="currentSection.div == 'energy-questions'">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    May I ask who you’re currently using for your gas and electricity supply?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.energy_current_supplier">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How long is left on the current contract?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.energy_current_contract_remaining">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How much is your average monthly bill?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.energy_average_monthly_bill">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are you on a half hourly meter?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                            v-model.number="answers.energy_meter_type">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are there any issues at all with your current service and supplier?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.energy_issues">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are you happy for us to carry out a review for you to see how the rates you’re currently getting compare with today’s market?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                            v-model.number="answers.energy_review">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bill</label>
                                                <div class="col-sm-8">
                                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                                        <div v-if="!answers.energy_bill">
                                                            <dropzone id="energyDropzone"
                                                                      v-on:vdropzone-file-added="fileAdded('energy_bill_set', 'energy_bill_requirements', $event)"
                                                                      v-on:vdropzone-success="fileSaved"
                                                                      url="#"
                                                                      :useFontAwesome="true"
                                                                      :maxNumberOfFiles="1"
                                                                      :autoProcessQueue="false"
                                                                      ref="energyBill"
                                                                      paramName="energy_bill"
                                                                      :showRemoveLink="false"
                                                                      :click="energy_bill_requirements = false"
                                                            >
                                                                <input type="hidden" name="user_id"
                                                                       v-model="answers.user_id">
                                                            </dropzone>

                                                            <hr>
                                                            <div v-if="!answers.energy_bill_requirements">
                                                                or
                                                                <a href="#"
                                                                   class="btn btn-warning"
                                                                   v-on:click.prevent="requirementsAdded('energy_bill_requirements', 'energy_bill_set')"
                                                                   v-on:click="removeFiles('energyBill')"
                                                                >
                                                                    Requirements
                                                                </a>
                                                            </div>
                                                            <div v-else>
                                                                <p>Requirements Selected</p>
                                                            </div>
                                                        </div>

                                                        <div v-else>
                                                            <a :href="'/journey-team-survey-files/' + energyBill"
                                                               class="btn btn-info">Download</a>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition>

                            <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <div v-show="currentSection.div == 'water-questions'">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    May I ask who your current water supplier is?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.water_current_supplier">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How long is left on the current contract?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.water_current_contract_remaining">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How much is your average monthly bill?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.water_average_monthly_bill">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are there any issues at all with your current service and supplier?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.water_issues">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are you happy for us to carry out a review for you to see how the rates you’re currently getting compare with today’s market?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                            v-model.number="answers.water_review">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bill</label>
                                                <div class="col-sm-8">
                                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                                        <div v-if="!answers.water_bill">
                                                            <dropzone id="waterDropzone"
                                                                      v-on:vdropzone-file-added="fileAdded('water_bill_set', 'water_bill_requirements', $event)"
                                                                      v-on:vdropzone-success="fileSaved"
                                                                      url="#"
                                                                      :useFontAwesome="true"
                                                                      :maxNumberOfFiles="1"
                                                                      :autoProcessQueue="false"
                                                                      ref="waterBill"
                                                                      paramName="water_bill"
                                                                      :showRemoveLink="false"
                                                                      :click="water_bill_requirements = false"
                                                            >
                                                                <input type="hidden" name="user_id"
                                                                       v-model="answers.user_id">
                                                            </dropzone>

                                                            <hr>
                                                            <div v-if="!answers.water_bill_requirements">
                                                                or
                                                                <a href="#"
                                                                   class="btn btn-warning"
                                                                   v-on:click.prevent="requirementsAdded('water_bill_requirements', 'water_bill_set')"
                                                                   v-on:click="removeFiles('waterBill')"
                                                                >
                                                                    Requirements
                                                                </a>
                                                            </div>
                                                            <div v-else>
                                                                <p>Requirements Selected</p>
                                                            </div>
                                                        </div>

                                                        <div v-else>
                                                            <a :href="'/journey-team-survey-files/' + waterBill"
                                                               class="btn btn-info">Download</a>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition>

                            <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <div id="it-questions" v-show="currentSection.div == 'it-questions'">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    May I ask who your current IT support provider is?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.it_current_supplier">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    What sort of contract do you have in place?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.it_current_contract">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    What service level do they provide?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.it_service_level">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    When is your hardware maintenance contract and warranties renewal due?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.it_hardware_maintenance_contract_renewal">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are you happy for us to take a look at your IT provision and support requirements, so we can recommend a comprehensive support contract?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" v-model.number="answers.it_review">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bill</label>
                                                <div class="col-sm-8">
                                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                                        <div v-if="!answers.it_bill">
                                                            <dropzone id="itDropzone"
                                                                      v-on:vdropzone-file-added="fileAdded('it_bill_set', 'it_bill_requirements', $event)"
                                                                      v-on:vdropzone-success="fileSaved"
                                                                      url="#"
                                                                      :useFontAwesome="true"
                                                                      :maxNumberOfFiles="1"
                                                                      :autoProcessQueue="false"
                                                                      ref="itBill"
                                                                      paramName="it_bill"
                                                                      :showRemoveLink="false"
                                                                      :click="it_bill_requirements = false"
                                                            >
                                                                <input type="hidden" name="user_id"
                                                                       v-model="answers.user_id">
                                                            </dropzone>

                                                            <hr>
                                                            <div v-if="!answers.it_bill_requirements">
                                                                or
                                                                <a href="#"
                                                                   class="btn btn-warning"
                                                                   v-on:click.prevent="requirementsAdded('it_bill_requirements', 'it_bill_set')"
                                                                   v-on:click="removeFiles('itBill')"
                                                                >
                                                                    Requirements
                                                                </a>
                                                            </div>
                                                            <div v-else>
                                                                <p>Requirements Selected</p>
                                                            </div>
                                                        </div>

                                                        <div v-else>
                                                            <a :href="'/journey-team-survey-files/' + itBill"
                                                               class="btn btn-info">Download</a>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition>

                            <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                <div v-show="currentSection.div == 'vehicle-tracking-questions'">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    May I ask who your current supplier is?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.vehicle_tracking_current_supplier">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How long is left on the current contract?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.vehicle_tracking_current_contract_remaining">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    How much is your average monthly bill?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.vehicle_tracking_average_monthly_bill">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are there any issues at all with your current service and supplier?
                                                </label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" class="form-control"
                                                              v-model="answers.vehicle_tracking_issues">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">
                                                    Are you happy for us to carry out a review for you to see how the rates you’re currently getting compare with today’s market?
                                                </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                            v-model.number="answers.vehicle_tracking_review">
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Bill</label>
                                                <div class="col-sm-8">
                                                    <transition v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                                                        <div v-if="!answers.vehicle_tracking_bill">
                                                            <dropzone id="vehicle_trackingDropzone"
                                                                      v-on:vdropzone-file-added="fileAdded('vehicle_tracking_bill_set', 'vehicle_tracking_bill_requirements', $event)"
                                                                      v-on:vdropzone-success="fileSaved"
                                                                      url="#"
                                                                      :useFontAwesome="true"
                                                                      :maxNumberOfFiles="1"
                                                                      :autoProcessQueue="false"
                                                                      ref="vehicleTrackingBill"
                                                                      paramName="vehicle_tracking_bill"
                                                                      :showRemoveLink="false"
                                                                      :click="vehicle_tracking_bill_requirements = false"
                                                            >
                                                                <input type="hidden" name="user_id"
                                                                       v-model="answers.user_id">
                                                            </dropzone>

                                                            <hr>
                                                            <div v-if="!answers.vehicle_tracking_bill_requirements">
                                                                or
                                                                <a href="#"
                                                                   class="btn btn-warning"
                                                                   v-on:click.prevent="requirementsAdded('vehicle_tracking_bill_requirements', 'vehicle_tracking_bill_set')"
                                                                   v-on:click="removeFiles('vehicleTrackingBill')"
                                                                >
                                                                    Requirements
                                                                </a>
                                                            </div>
                                                            <div v-else>
                                                                <p>Requirements Selected</p>
                                                            </div>
                                                        </div>

                                                        <div v-else>
                                                            <a :href="'/journey-team-survey-files/' + vehicleTrackingBill"
                                                               class="btn btn-info">Download</a>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </transition>

                        </div>

                        <div class="row controls">
                            <a href="#" class="btn btn-white pull-left" v-on:click.prevent="previousSection()"
                               v-bind:disabled="currentSection.order === 1">Back</a>
                            <a href="#" class="btn btn-success pull-right" v-on:click.prevent="nextSection()"
                               v-if="currentSection.order < sections.length">Next</a>
                            <a href="#" class="btn btn-info pull-right" v-on:click.prevent="finish()">Finish</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Dropzone from 'vue2-dropzone'

    export default {
        components: {
            Dropzone
        },
        props: {
            customer: {
                required: true
            },
            survey: {
                required: false
            },
            user: {
                required: true
            }
        },
        watch: {
            answers: {
                handler: function (answers) {
                    this.handleAnswers(answers);
                },
                deep: true,
                immediate: true
            },
        },
        computed: {
            fixedLineBill() {
                return this.answers.fixed_line_bill ? this.answers.fixed_line_bill.replace(/\//g, '~') : null;
            },
            energyBill() {
                return this.answers.energy_bill ? this.answers.energy_bill.replace(/\//g, '~') : null;
            },
            waterBill() {
                return this.answers.water_bill ? this.answers.water_bill.replace(/\//g, '~') : null;
            },
            itBill() {
                return this.answers.it_bill ? this.answers.it_bill.replace(/\//g, '~') : null;
            },
            vehicleTrackingBill() {
                return this.answers.it_bill ? this.answers.it_bill.replace(/\//g, '~') : null;
            },
        },
        data() {
            return {
                surveyId: null,
                answers: {
                    mobile_issues: 0,
                    mobile_issues_details: null,
                    fixed_line_current_supplier: null,
                    fixed_line_current_contract_remaining: null,
                    fixed_line_average_monthly_bill: null,
                    fixed_line_issues: null,
                    fixed_line_review: null,
                    energy_current_supplier: null,
                    energy_current_contract_remaining: null,
                    energy_meter_type: null,
                    energy_average_monthly_bill: null,
                    energy_issues: null,
                    energy_review: null,
                    water_current_supplier: null,
                    water_current_contract_remaining: null,
                    water_average_monthly_bill: null,
                    water_issues: null,
                    water_review: null,
                    it_current_supplier: null,
                    it_current_contract: null,
                    it_service_level: null,
                    it_hardware_maintenance_contract_renewal: null,
                    it_review: null,
                    vehicle_tracking_current_supplier: null,
                    vehicle_tracking_current_contract_remaining: null,
                    vehicle_tracking_average_monthly_bill: null,
                    vehicle_tracking_issues: null,
                    vehicle_tracking_review: null,
                    fixed_line_complete: false,
                    energy_complete: false,
                    water_complete: false,
                    it_complete: false,
                    vehicle_tracking_complete: false,
                    mobile_complete: false,
                    //files
                    fixed_line_bill: null,
                    fixed_line_bill_set: null,
                    fixed_line_bill_requirements: false,
                    energy_bill: null,
                    energy_bill_set: null,
                    energy_bill_requirements: false,
                    water_bill: null,
                    water_bill_set: null,
                    water_bill_requirements: false,
                    it_bill: null,
                    it_bill_set: null,
                    it_bill_requirements: false,
                    vehicle_tracking_bill: null,
                    vehicle_tracking_bill_set: null,
                    vehicle_tracking_bill_requirements: false,
                },
                currentSection: {},
                sections: [
                    {
                        title: 'Mobile',
                        icon: {'fa-mobile': true},
                        navClass: false,
                        div: 'mobile-questions',
                        complete: false,
                        order: 1,
                        active: false,
                    },
                    {
                        title: 'Fixed Line',
                        icon: {'fa-phone': true},
                        navClass: false,
                        div: 'fixed-line-questions',
                        complete: false,
                        order: 2,
                        active: false,
                    },
                    {
                        title: 'Energy',
                        icon: {'fa-flash': true},
                        navClass: false,
                        div: 'energy-questions',
                        complete: false,
                        order: 3,
                        active: false,
                    },
                    {
                        title: 'Water',
                        icon: {'fa-tint': true},
                        navClass: false,
                        div: 'water-questions',
                        complete: false,
                        order: 4,
                        active: false,
                    },
                    {
                        title: 'IT',
                        icon: {'fa-desktop': true},
                        navClass: false,
                        div: 'it-questions',
                        complete: false,
                        order: 5,
                        active: false,
                    },
                    {
                        title: 'Vehicle Tracking',
                        icon: {'fa-truck': true},
                        navClass: false,
                        div: 'vehicle-tracking-questions',
                        complete: false,
                        order: 6,
                        active: false,
                    },
                ],
            }
        },
        methods: {
            removeFiles(context) {
                this.$refs[context].removeAllFiles();
            },
            fileSaved(event, response){
                let data = JSON.parse(response);

                if (data.id) {
                    this.surveyId = data.id;

                    this.answers = data;
                }
            },
            requirementsAdded(a, b) {
                this.answers[a] = true;

                this.answers[b] = true;
            },
            fileAdded(a, b, file){
                this.answers[a] = true;

                this.answers[b] = false;
            },
            postUrl() {
                let url = '/api/customers/' + this.customer + '/journey-team-survey/';

                return this.surveyId ? url + this.surveyId : url
            },
            getNavClass(section) {
                if (section.active === true && section.complete === false) {
                    return {active: true}
                }

                if (section.complete === true && section.active === false) {
                    return {success: true}
                }

                if (section.complete === true && section.active === true) {
                    return {
                        'active-success': true,
                    }
                }
            },
            handleAnswers(data) {
                let mobileRows = data.mobile_issues === 0
                    ? ['mobile_issues', 'mobile_issues_details']
                    : ['mobile_issues'];

                let mobile = this.only(data, mobileRows);

                let fixedLine = this.only(data, [
                    'fixed_line_average_monthly_bill',
                    'fixed_line_current_contract_remaining',
                    'fixed_line_current_supplier',
                    'fixed_line_issues',
                    'fixed_line_review',
                    'fixed_line_bill_set',
                ]);

                let energy = this.only(data, [
                    'energy_current_supplier',
                    'energy_current_contract_remaining',
                    'energy_meter_type',
                    'energy_average_monthly_bill',
                    'energy_issues',
                    'energy_review',
                    'energy_bill_set',
                ]);

                let water = this.only(data, [
                    'water_current_supplier',
                    'water_current_contract_remaining',
                    'water_average_monthly_bill',
                    'water_issues',
                    'water_review',
                    'water_bill_set',
                ]);

                let it = this.only(data, [
                    'it_current_supplier',
                    'it_current_contract',
                    'it_service_level',
                    'it_hardware_maintenance_contract_renewal',
                    'it_review',
                    'it_bill_set',
                ]);

                let vehicle = this.only(data, [
                    'vehicle_tracking_current_supplier',
                    'vehicle_tracking_current_contract_remaining',
                    'vehicle_tracking_average_monthly_bill',
                    'vehicle_tracking_issues',
                    'vehicle_tracking_review',
                    'vehicle_tracking_bill_set',
                ]);

                let options = [
                    {
                        data: mobile,
                        filtered: this.filterNulls(mobile),
                        arrayId: 0,
                        complete: 'mobile_complete'
                    },
                    {
                        data: fixedLine,
                        filtered: this.filterNulls(fixedLine),
                        arrayId: 1,
                        complete: 'fixed_line_complete'
                    },
                    {
                        data: energy,
                        filtered: this.filterNulls(energy),
                        arrayId: 2,
                        complete: 'energy_complete'
                    },
                    {
                        data: water,
                        filtered: this.filterNulls(water),
                        arrayId: 3,
                        complete: 'water_complete'
                    },
                    {
                        data: it,
                        filtered: this.filterNulls(it),
                        arrayId: 4,
                        complete: 'it_complete'
                    },
                    {
                        data: vehicle,
                        filtered: this.filterNulls(vehicle),
                        arrayId: 5,
                        complete: 'vehicle_tracking_complete'
                    }
                ];

                for (let i = 0, len = options.length; i < len; i++) {
                    this.completeSectionProperty(options[i]);
                }
            },
            completeSectionProperty(options) {
                if (options.data.length === options.filtered.length) {
                    this.setCompleteSection(this.sections[options.arrayId]);

                    return this.answers[options.complete] = true;
                }

                this.setIncompleteSection(this.sections[options.arrayId]);

                return this.answers[options.complete] = false;
            },
            only(data, keys) {
                return _.filter(data, function (i, k) {
                    for (var i = 0, len = keys.length; i < len; i++) {
                        if (k == keys[i]) {
                            return true;
                        }
                    }
                });
            },
            filterNulls(data) {
                return _.filter(data, function (i, k) {
                    return i !== null && i !== '';
                });
            },
            saveSurvey() {
                let self = this;

                let files = [
                    'itBill',
                    'vehicleTrackingBill',
                    'waterBill',
                    'fixedLineBill',
                    'energyBill',
                ];

                axios.post(self.postUrl(), self.answers)
                    .then(function (response) {
                        if (response.data.id) {
                            self.surveyId = response.data.id;

                            self.answers = response.data;

                            _.forEach(files, function (file) {
                                self.$refs[file].setOption('url', self.postUrl());

                                self.$refs[file].processQueue();
                            });
                        }
                    })
                    .catch(function (error) {
                    });
            },
            finish() {
                let self = this;

                this.saveSurvey();

                swal({
                    type: 'success',
                    title: "Survey Saved",
                    text: 'Any information you have input will be saved.',
                    timer: 1500,
                    showConfirmButton: false
                }, function () {
                    location.replace('/customers/' + self.customer + '/journey-team-survey');
                });
            },
            nextSection(section = null) {
                let i = section
                    ? section
                    : this.sections.map(item => item.order).indexOf(this.currentSection.order);

                (i + 1) < this.sections.length && this.setCurrentSection(this.sections[i + 1])
            },
            previousSection(section = null) {
                let i = section
                    ? section
                    : this.sections.map(item => item.order).indexOf(this.currentSection.order);

                (i - 1) < this.sections.length && this.setCurrentSection(this.sections[i - 1])
            },
            resetActiveState() {
                _.forEach(this.sections, (s) => {
                    s.active = false;
                });
            },
            setCompleteSection(section) {
                section.complete = true;
            },
            setIncompleteSection(section) {
                section.complete = false;
            },
            setCurrentSection(section) {
                this.resetActiveState();

                section.active = true;

                this.currentSection = section;

                this.saveSurvey();
            },
        },
        created()
        {
            this.surveyId = this.survey;
            this.answers.user_id = this.user;

            if (this.surveyId > 0) {
                let self = this;

                axios.get(self.postUrl())
                    .then(function (response) {
                        self.answers = response.data;
                    })
                    .catch(function (error) {
                    });
            }

            this.resetActiveState();

            this.sections[0].active = true;

            this.currentSection = this.sections[0];
        }
    }
</script>