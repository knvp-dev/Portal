
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
 Vue.component('notification', require('./components/Notification.vue'));
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
 Vue.component('emailhandtekeningen', require('./components/Emailhandtekeningen.vue'));
 Vue.component('admin-emailhandtekeningen', require('./components/admin/Emailhandtekeningen.vue'));
 Vue.component('admin-promomateriaal', require('./components/admin/Promomateriaal.vue'));
 Vue.component('admin-kantoormateriaal', require('./components/admin/Kantoormateriaal.vue'));
 Vue.component('admin-beursmateriaal', require('./components/admin/Beursmateriaal.vue'));
 Vue.component('admin-orders', require('./components/admin/Orders.vue'));
 Vue.component('admin-kantoren', require('./components/admin/Kantoren.vue'));

 Vue.component('dm-offices', require('./components/dm/Offices.vue'));
 Vue.component('dm-orders', require('./components/dm/Orders.vue'));

 window.Event = new Vue({});

 window.Locale = new Vue({
 	created(){
 		this.getTranslations();
 	},
 	data: {
 		locale: 'nl',
 		translations: [],
 		defaultUrl: '/translations.json'
 	},
 	methods:{
 		getTranslations(){
 			$.getJSON(this.defaultUrl,function(data){
 				Locale.setTranslations(data);
 			});
 		},
 		setTranslations(data){
 			this.translations = data;
 		},
 		getLocale(){
 			return this.locale;
 		},
 		setLocale(locale){
 			this.locale = locale;
 			Cookie.set('locale', locale, 1);
 		},
 		translate(key){
 			if(this.translations.length > 0){
 				return this.translations[0][this.locale][key];
 			}
 		}
 	}
 })

 const app = new Vue({
 	el: '#app',
 	mounted(){
 		(!Cookie.get('locale')) ? Locale.setLocale('nl') : Locale.setLocale(Cookie.get('locale'));
 		(!Cookie.get('locale')) ? window.moment.locale("nl") : window.moment.locale(Cookie.get('locale'));
 	},
 	data:{
 		trans: Locale,
 		translations: ''
 	},
 	methods:{
 		changeLocal(lang){
 			Locale.setLocale(lang);
 			moment.locale(lang);
 		}
 	}
 });

 Vue.directive('translate-name', function (el, binding) {
 	(Locale.getLocale() == 'nl') ? el.innerHTML = binding.value.name_nl : el.innerHTML = binding.value.name_fr;
 })

  	// 	jQuery.curCSS = function(element, prop, val) {
 		// 	return jQuery(element).css(prop, val);
 		// };