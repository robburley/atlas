<template>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default m-h-386 border-top-success">
                <div class="panel-heading">Calendar</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4 text-left">
                            <a href="#" class=" btn btn-success btn-xs"
                               @click.prevent="getCalendar(previousMonth.date)">
                                <i class="fa fa-chevron-left"></i>

                                {{ previousMonth.name }}
                            </a>
                        </div>

                        <div class="col-xs-4 text-center">
                            <h4>{{ currentMonth.name }}</h4>
                        </div>

                        <div class="col-xs-4 text-right">
                            <a href="#" class=" btn btn-success btn-xs" @click.prevent="getCalendar(nextMonth.date)">
                                {{ nextMonth.name }}

                                <i class="fa fa-chevron-right"></i>
                            </a>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div v-show="loading" class="text-center">
                                <h1>
                                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                                </h1>
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center" v-for="name in dayNames" :key="name">
                                        {{ name }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="chunk in chunkDays" :key="chunk">
                                    <td class="v-mid text-center clickable"
                                        v-for="day in chunk"
                                        :key="day"
                                        @click="setActiveDay(day)"
                                        v-bind:class="getActiveDayClass(day)">
                                        {{ getDayFromString(day.date) }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default m-h-386 border-top-success">
                <div class="panel-heading">
                    Events
                    <a class="btn btn-xs btn-danger pull-right" @click="toggleForm" v-if="showForm">
                        Show Events
                    </a>
                    <a class="btn btn-xs btn-success pull-right" @click="toggleForm" v-else>
                        New Event
                    </a>
                </div>

                <div class="panel-body">
                    <div v-show="loading" class="text-center">
                        <h1>
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        </h1>
                    </div>

                    <transition-group v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                        <div class="row" :key="1" v-if="showForm">
                            <div class="col-xs-12">
                                <p>
                                    This event will not be attached to a customer. <br>
                                    To attach an event to a customer, go to the customer record and create the event from there.
                                </p>

                                <hr>

                                <form @submit.prevent="saveEvent">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" v-model="currentEvent.type">
                                            <option value="danger" selected>Important</option>
                                            <option value="purple">Bill Request</option>
                                            <option value="info">Bill Received</option>
                                            <option value="warning">Basic</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Date and Time</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <date-time :value="currentEvent.date_time"
                                                           v-on:input="setDate"></date-time>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Title</label>

                                        <input class="form-control" type="text" v-model="currentEvent.title">
                                    </div>

                                    <div class="form-group">
                                        <label>Content</label>

                                        <textarea class="form-control" cols="30" rows="10"
                                                  v-model="currentEvent.body"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-success pull-right">Save</button>

                                </form>
                            </div>
                            <div class="col-sm-12" v-if="errors">
                                <div class="alert alert-danger">
                                    <p v-for="[error, index] in errors" :key="index">
                                        {{ error }}
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="row" v-for="event in events" v-else :key="event">
                            <div class="col-xs-12">
                                <h4 class="clickable p-b-10 event-title" @click="toggleContent(event)">
                                    <div class="row">
                                        <div class="col-xs-1">
                                            <i class="fa fa-calendar" v-bind:class="getEventClass(event)"></i>
                                        </div>
                                        <div class="col-lg-2 col-md-3">
                                            {{ event.time }}
                                        </div>
                                        <div class="col-lg-8 col-md-7">
                                            <div class="row">
                                                <div class="col-sm-12 p-b-5" v-if="event.customer">
                                                    {{ event.customer.company_name }}
                                                </div>
                                                <div class="col-sm-12">
                                                    {{ event.title }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-1 v-mid">
                                            <i class="fa fa-chevron-down pull-right" v-if="event.showContent"></i>
                                            <i class="fa fa-chevron-right pull-right" v-else></i>
                                        </div>
                                    </div>
                                </h4>

                                <div class="row" v-if="event.showContent">
                                    <div class="col-md-12 p-b-10 event-title">
                                        <p v-if="event.customer">
                                            <strong>Customer: </strong>
                                            <a v-bind:href="getEventCustomUrl(event)">
                                                {{ event.customer.company_name }}
                                            </a>
                                        </p>

                                        <p v-if="event.customer">
                                            <strong>Phone Number: </strong> {{ event.customer.telephone_number }}
                                        </p>

                                        <p v-html="event.body "></p>

                                        <div class="row">
                                            <div class="col-sm-12 text-right">
                                                <a class="btn btn-xs btn-warning btn-icon" @click="getEvent(event)">
                                                    <i class="fa fa-fw fa-cog"></i>
                                                    <span>edit</span>
                                                </a>

                                                <a class="btn btn-xs btn-danger btn-icon" @click="deleteEvent(event)">
                                                    <i class="fa fa-fw fa-close"></i>
                                                    <span>delete</span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition-group>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DateTime from "./DateTime";

    export default {
        components: {
            'date-time': DateTime,
        },
        props: [
            'user_id'
        ],
        data() {
            return {
                currentMonth: {},
                previousMonth: {},
                nextMonth: {},
                days: [],
                dayNames: [],
                activeDay: {},
                events: [],
                showForm: false,
                currentEvent: {
                    id: null,
                    title: '',
                    body: '',
                    type: 'danger',
                    customer: null,
                    date_time: '',
                },
                errors: false,
                loading: true,
            }
        },
        computed: {
            chunkDays: function () {
                return window._.chunk(this.days, 7);
            }
        },
        created() {
            this.getCalendar()

            this.setActiveDay({date: window.moment().format('YYYY-MM-DD')});
        },
        methods: {
            getDayFromString(DateString){
                return window.moment(DateString).format('Do')
            },
            setDate(val) {
                this.currentEvent.date_time = val;
            },
            getCalendar(date) {
                let self = this;

                window.axios.get('/calendar?start=' + date)
                    .then(function (payload) {
                        self.loading = false;

                        self.currentMonth = payload.data.currentMonth;

                        self.previousMonth = payload.data.previousMonth;

                        self.nextMonth = payload.data.nextMonth;

                        self.days = payload.data.days;

                        self.dayNames = payload.data.dayNames;
                    });
            },

            setActiveDay(day) {
                this.activeDay = day;

                this.getEvents(day);
            },

            getEvents (day) {
                let self = this;

                window.axios.get('/calendar/' + this.user_id + '/events?date=' + day.date)
                    .then(function (payload) {
                        self.events = payload.data;
                    });
            },

            toggleContent(event) {
                event.showContent = event.showContent !== true;
            },

            getEventCustomUrl(event) {
                return '/customers/' + event.customer.id;
            },

            getEventClass(event) {
                return {
                    'text-purple': event.type === 'purple',
                    'text-warning': event.type === 'warning',
                    'text-danger': event.type === 'danger',
                    'text-info': event.type === 'info',
                }
            },

            getActiveDayClass(day){
                return {
                    'active-day': this.activeDay.date === day.date
                }
            },

            toggleForm(){
                this.showForm = this.showForm !== true;

                this.currentEvent = {
                    id: null,
                    title: '',
                    body: '',
                    type: 'danger',
                    customer: null,
                    date_time: '',
                }
            },

            getEvent(event) {
                let self = this;

                window.axios.get('/calendar/' + this.user_id + '/events/' + event.id)
                    .then(function (payload) {
                        self.showForm = true;

                        self.errors = false;

                        self.currentEvent = payload.data;
                    })
            },

            deleteEvent(event) {
                let self = this;

                window.swal({
                        title: "Are you sure?",
                        text: "You will not be able to undo this.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "delete",
                        closeOnConfirm: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            window.axios.delete('/calendar/' + self.user_id + '/events/' + event.id)
                                .then(function () {
                                    self.getEvents(self.activeDay);
                                });
                        }
                    });
            },

            saveEvent() {
                let self = this;

                let url = this.currentEvent.id
                    ? '/calendar/' + this.user_id + '/events/' + this.currentEvent.id
                    : '/calendar/' + this.user_id + '/events';

                window.axios.post(url, this.currentEvent)
                    .then(function () {
                        self.showForm = false;

                        self.errors = false;

                        self.currentEvent = {
                            title: '',
                            body: '',
                            type: 'danger',
                            date_time: '',
                        };

                        self.getEvents(self.activeDay);
                    })
                    .catch(function (errors) {
                        self.errors = errors.response.data;
                    });
            },
        }
    }
</script>
