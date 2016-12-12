<template>
    <div>
        <span class="timer">{{ timeLeft }}</span>
    </div>
</template>

<script>
export default {
    mounted() {
        this.initializeCountdown();
        moment.locale('nl');
        window.setInterval(() => {
            this.now = Math.trunc((new Date()).getTime());
        },1000);
    },
    data() {
        return {
            now: Math.trunc((new Date()).getTime())
        }
    },
    methods: {
        getNextDayToCountdown(day){
            if (this.date < moment()) { 
              return moment().isoWeekday(day).set('hours',12)
            } else {
              return moment().add(1, 'weeks').isoWeekday(day).set('hours',12);
            }
        },
        initializeCountdown(){
            this.now = Math.trunc((new Date()).getTime());
            this.date = Math.trunc(Date.parse(this.getNextDayToCountdown(1)._d));
        }
    },
    computed: {
        timeLeft(){
            var a = moment(this.now);
            var b = moment(this.date);
            return a.to(b);
        }
    }
}
</script>