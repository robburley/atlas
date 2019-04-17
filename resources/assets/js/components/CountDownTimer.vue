<style>
</style>

<template>
    <div>
        <h4 class="text-dark m-t-5">
            <span class="icon-clock">
                <span v-if="finished" class="text-danger">
                    Expired
                </span>

                <span v-else>
                    <span v-show="remaining.days > 0">
                        {{ remaining.days }}

                        <span v-if="remaining.days == 1">Day</span>
                        <span v-else>Days</span>
                    </span>

                    <span v-show="remaining.hours > 0">
                        {{ remaining.hours }}

                        <span v-if="remaining.hours == 1">Hour</span>
                        <span v-else>Hours</span>
                    </span>

                    <span v-show="remaining.minutes > 0">
                        {{ remaining.minutes }}

                        <span v-if="remaining.minutes == 1">Minute</span>
                        <span v-else>Minutes</span>
                    </span>

                    <span v-show="remaining.seconds > 0 && remaining.minutes < 1 && remaining.hours < 1 && remaining.days < 1">
                        {{ remaining.seconds }}

                        <span v-if="remaining.seconds == 1">Second</span>
                        <span v-else>Seconds</span>
                    </span>
                </span>
            </span>
        </h4>
    </div>
</template>

<script>
    export default {
        props: {
            deadline: {
                type: String,
                required: true,
            },
        },
        data() {
            return {
                now: new Date(),
            }
        },
        mounted() {
            let interval = setInterval(() => {
                this.now = new Date()
            }, 1000)

            this.$on('count-down-finished', () => clearInterval(interval))
        },
        computed: {
            finished() {
                return this.remaining.total <= 0
            },
            remaining() {
                let remaining = window.moment.duration(Date.parse(this.deadline) - this.now)

                if (remaining <= 0) {
                    this.$emit('count-down-finished')
                }

                return {
                    total: remaining,
                    days: remaining.days(),
                    hours: remaining.hours(),
                    minutes: remaining.minutes(),
                    seconds: remaining.seconds(),
                }
            },
        },
    }
</script>

