<template>
	<div>
		<hero :title="trans.translate('Overzicht bestelling') + ' ' + trans.translate('promomateriaal')" :hasSubtitle="true" :subtitle="trans.translate('Aangevraagd op') + ' ' + formatDate(order.created_at)" type="is-blue">
			<div class="tag is-success" v-if="order.completed">{{ trans.translate('Voltooid') }}</div>
			<div class="tag is-primary" v-else>{{ trans.translate('In behandeling') }}</div>
		</hero>

		<modal 
		v-if="showConfirmationModal" 
		@close="showConfirmationModal = false"
		@modalconfirmed="cancelOrder"
		:hasYesNoOptions="true"
		:body="trans.translate('Bent u zeker dat u deze bestelling wilt annuleren?')"
		>
	</modal>

	<div class="container mb-50">
		<section class="section">
			<ul class="cart-list">
				<li v-for="product in order.products" class="slideInLeft">
					<div class="cart-item-segment" :class="{ notdeliverable : !!product.pivot.status }">
						<div class="cart-item-amount">
							{{ product.pivot.amount }}x
							<span class="anim-circle"></span>
						</div>
						<div class="cart-item-info-name">
							<span v-translate-name="product"></span> <span v-if="product.pivot.status">( Niet leverbaar )</span>
						</div>
						<div class="cart-item-info-pack">
							{{ trans.translate('pakket van') }} {{ product.pack }} {{ trans.translate('stuks') }}
						</div>
						<div class="cart-item-info-price">
							<span v-if="product.pivot.status">-</span>{{ formatCurrency(product.price * product.pivot.amount) }}
						</div>
					</div>
				</li>
			</ul>
			<div class="cart-item-segment cart-list-summary">
				<p>{{ trans.translate('totaalprijs') }}: <strong>{{ formatCurrency(order.total_price) }}</strong></p>
				<span  v-if="!order.completed"><button class="button is-danger pull-right" @click="showConfirmationModal = true">{{ trans.translate('Bestelling annuleren') }}</button></span>
			</p>
		</div>
	</section>
</div>
</div>
</template>

<script>
	export default{
		mounted(){
			this.fetchOrderDetails();
		},
		props: ['id'],
		data(){
			return{
				order: [],
				showConfirmationModal: false,
				trans: Locale
			}
		},
		computed:{
			orderId(){
				return this.id;
			}
		},
		methods:{
			fetchOrderDetails(){
				this.$http.get('/promomateriaal/order/detail/'+this.orderId).then( (response) => {
					this.order = response.data;
				});
			},
			formatCurrency(value){
				return "€"+(value / 100).toFixed(2);
			},
			formatDate(date){
				return moment(date).format('D MMMM, YYYY');
			},
			cancelOrder(){
				setTimeout(function () { 
					this.$http.get('/promomateriaal/order/delete/' + this.order.id).then((response) => {
						if(response){
							this.$emit('actionSuccess', this.trans.translate("Uw bestelling werd successvol geannuleerd!"));
						}else{
							this.$emit('actionFailed', this.trans.translate("Er is iets foutgelopen bij het annuleren van uw bestelling, probeer het later opnieuw!"));
						}
					});
				}.bind(this), 1000);
			}
		}
	}
</script>