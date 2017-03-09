<template>
	<div>
		
		<div class="container">
			<section class="section">
				<div class="section-header has-text-centered">
					<h1 class="title is-title-centered-message">{{ $root.trans.translate('Overzicht bestellingen') }} {{ office.name }}</h1>
				</div>

				<div class="tabs is-centered mb-50">
					<ul>
						<li @click="fetchOrders('promo')" :class="{'is-active': activeType == 'promo'}"><a>{{ $root.trans.translate('promomateriaal') }}</a></li>
						<li @click="fetchOrders('kantoor')" :class="{'is-active': activeType == 'kantoor'}"><a>{{ $root.trans.translate('kantoormateriaal') }}</a></li>
						<li @click="fetchOrders('beurs')" :class="{'is-active': activeType == 'beurs'}"><a>{{ $root.trans.translate('beursmateriaal') }}</a></li>
					</ul>
				</div>

				<ul class="cart-list">
					<li v-for="order in orders" class="slideInLeft">
						<div class="cart-item-segment">
							<div class="cart-item-amount">
								{{ order.id }}
								<span class="anim-circle"></span>
							</div>
							<div class="cart-item-info">
								{{ order.products.length }} {{ $root.trans.translate('product(en)') }}
							</div>
							<div class="cart-item-info">
								{{ $root.trans.translate('Aangevraagd op') }} {{ formatDate(order.created_at) }}
							</div>
							<div class="cart-item-info">
								{{ (order.total_price) ? formatCurrency(order.total_price) : $root.trans.translate('Gratis') }}
							</div>
							<div class="cart-item-info">
								{{ order.event }}
							</div>
							<div class="cart-item-info">
								<span v-if="order.completed" class="tag is-success is-small is-icon-left"><i class="fa fa-check icon is-small"></i> {{ $root.trans.translate('Voltooid') }}</span>
								<span v-else class="tag is-small"><i class="fa fa-refresh icon is-small is-icon-left"></i> {{ $root.trans.translate('In behandeling') }}</span>
							</div>
							<div class="cart-item-controls">
								<a class="button button-round is-primary transitioning-icon" @click="showOrderDetail(order.id)">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-ellipsis-h"></i>
										<i class="fa fa-arrow-right"></i>
									</span>
								</a>
							</div>
						</div>
					</li>
				</ul>

				<span class="is-light-centered-message" v-if="orders.length == 0">{{ $root.trans.translate('Geen bestellingen') }}</span>
			</div>

		</section>
	</div>
</template>

<script>
	export default{
		mounted(){
			this.fetchOrders(this.activeType);
		},
		data(){
			return {
				orders: [],
				activeType: 'promo'
			}
		},
		props: ['office'],
		watch:{
			office(){
				this.activeType = 'promo';
				this.fetchOrders(this.activeType);
			}
		},
		methods: {
			fetchOrders(type){
				this.orders = [];
				this.activeType = type;
				this.$http.get('/dm/'+type+'materiaal/orders/'+this.office.id).then((response) => {
					this.orders = response.data;
				});
			},
			formatDate(date){
				return moment(date).format('D MMMM, YYYY');
			},
			formatCurrency(value){
				return "€"+(value / 100).toFixed(2);
			},
			showOrderDetail(order_id){
				window.location.href = "/"+this.activeType+"materiaal/detail/"+order_id;
			}
		}
	}

</script>