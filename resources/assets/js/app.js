
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('hero', require('./components/Hero.vue'));
Vue.component('alert', require('./components/Alert.vue'));
Vue.component('modal', require('./components/Modal.vue'));
Vue.component('countdown', require('./components/Countdown.vue'));
Vue.component('beursmateriaal', require('./components/Beursmateriaal.vue'));
Vue.component('kantoormateriaal', require('./components/KantoorMateriaal.vue'));
Vue.component('info-panel', require('./components/InfoPanel.vue'));
Vue.component('promomateriaal', require('./components/PromoMateriaal.vue'));

window.Event = new Vue({});

const app = new Vue({
    el: '#app'
});

Vue.filter('two_digits', function (value) {
    if(value.toString().length <= 1)
    {
        return "0"+value.toString();
    }
    return value.toString();
});

$(function(){
	
  $('.products').masonry({
    itemSelector : '.product-card',
    fitWidth: true
  });

});