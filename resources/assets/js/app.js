require('./bootstrap')

import vSelect from 'vue-select'

Vue.use(require('vue-affix'));

Vue.component('v-select', vSelect)

Vue.use(require('vue2-filters'))

Vue.use(require('vue-scrollto'))

Vue.mixin({
    methods: {
        slideFadeIn(el, done) {
            Velocity(el, 'slideDown', {
                duration: 500,
            })
            Velocity(el, {
                opacity: 1,
            }, {
                complete: done,
            })
        },
        fadeSlideOut(el, done) {
            Velocity(el, {
                opacity: 0,
            }, {
                duration: 500,
            })
            Velocity(el, 'slideUp', {
                complete: done,
            })
        },
    },
})

Vue.component('calendar', require('./components/Calendar.vue'))

Vue.component('deal-calc', require('./components/DealCalc.vue'))

Vue.component('select-box', require('./components/SelectBox.vue'))

Vue.component('modal', require('./components/Modal.vue'))

Vue.component('journey-team-survey', require('./components/JourneyTeamSurvey.vue'))

Vue.component('fixed-line-commercials', require('./components/FixedLineCommericals.vue'))

Vue.component('tariff-match', require('./components/TariffMatch.vue'))

Vue.component('tariff-match-step-1', require('./components/TariffMatchStep1.vue'))

Vue.component('tariff-match-step-2', require('./components/TariffMatchStep2.vue'))

Vue.component('tariff-match-step-3', require('./components/TariffMatchStep3.vue'))

Vue.component('mobile-allocation', require('./components/MobileAllocation.vue'))

Vue.component('mobile-quality-control', require('./components/MobileQualityControl.vue'))

Vue.component('mobile-tender', require('./components/MobileTender.vue'))

Vue.component('count-down-timer', require('./components/CountDownTimer.vue'))

Vue.component('mobile-tender-row', require('./components/MobileTenderRow.vue'))

Vue.component('nav-figure', require('./components/NavFigure.vue'))

window.Events = new Vue()

const app = new Vue({
    el: '#app',
})
