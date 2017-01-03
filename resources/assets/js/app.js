
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
Vue.component('orders', require('./components/Orders.vue'));
Vue.component('info-panel', require('./components/InfoPanel.vue'));
Vue.component('promomateriaal', require('./components/promo/PromoMateriaal.vue'));
Vue.component('promodetail', require('./components/promo/PromoOrderDetail.vue'));
Vue.component('kantoordetail', require('./components/kantoor/KantoorOrderDetail.vue'));
Vue.component('beursdetail', require('./components/beurs/BeursOrderDetail.vue'));
Vue.component('beursmateriaal', require('./components/beurs/Beursmateriaal.vue'));
Vue.component('kantoormateriaal', require('./components/kantoor/KantoorMateriaal.vue'));
Vue.component('datepicker', require('./components/datepicker/datepicker.vue'));

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
    jQuery.curCSS = function(element, prop, val) {
        return jQuery(element).css(prop, val);
    };
	// $('.datepicker').DatePicker({
 //        format:'Y-m-d',
 //        date: $('.datepicker').val(),
 //        current: $('.datepicker').val(),
 //        starts: 1,
 //        position: 'r',
 //        onChange: function(formated, dates){
 //            $('.datepicker').val(formated);
 //            $('.datepicker').DatePickerHide();
 //        }
 //    });
  $('.products').masonry({
    itemSelector : '.product-card',
    fitWidth: true
  });

});