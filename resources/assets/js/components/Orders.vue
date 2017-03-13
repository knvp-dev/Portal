<template>
	<div>
		<hero :title="trans.translate('Overzicht van alle bestellingen')" :hasSubtitle="false" type="is-blue"></hero>
		<info-panel :orderPrice="0"></info-panel>
		<div class="container">
			<section class="section">
				<div class="section-header has-text-centered">
					<h1 class="title is-title-centered-message">{{ trans.translate('Overzicht bestellingen') }}</h1>
				</div>

				<div class="tabs is-centered mb-50">
					<ul>
						<li @click="fetchOrders('promo')" :class="{'is-active': activeType == 'promo'}"><a>{{ trans.translate('promomateriaal') }}</a></li>
						<li @click="fetchOrders('kantoor')" :class="{'is-active': activeType == 'kantoor'}"><a>{{ trans.translate('kantoormateriaal') }}</a></li>
						<li @click="fetchOrders('beurs')" :class="{'is-active': activeType == 'beurs'}"><a>{{ trans.translate('beursmateriaal') }}</a></li>
					</ul>
				</div>

				<div class="filters mb-20 is-clickable">
					<span class="tag" :class="{'is-primary': activeStatus == 2}" @click="fetchOrders(activeType)">{{ trans.translate('Alle') }}</span>
					<span class="tag" :class="{'is-primary': activeStatus == 0}" @click="filterOrders(0)">{{ trans.translate('In behandeling') }}</span>
					<span class="tag" :class="{'is-primary': activeStatus == 1}" @click="filterOrders(1)">{{ trans.translate('Voltooid') }}</span>
				</div>

				<ul class="cart-list">
					<li v-for="order in orders" class="slideInLeft">
						<div class="cart-item-segment">
							<div class="cart-item-amount">
								{{ order.id }}
								<span class="anim-circle"></span>
							</div>
							<div class="cart-item-info">
								{{ order.products.length }} {{ trans.translate('product(en)') }}
							</div>
							<div class="cart-item-info">
								{{ trans.translate('Aangevraagd op') }} {{ formatDate(order.created_at) }}
							</div>
							<div class="cart-item-info">
								{{ (order.total_price) ? formatCurrency(order.total_price) : trans.translate('Gratis') }}
							</div>
							<div class="cart-item-info">
								{{ order.event }}
							</div>
							<div class="cart-item-info">
								<span v-if="order.completed" class="tag is-success is-small is-icon-left"><i class="fa fa-check icon is-small"></i> {{ trans.translate('Voltooid') }}</span>
								<span v-else class="tag is-small"><i class="fa fa-refresh icon is-small is-icon-left"></i> {{ trans.translate('In behandeling') }}</span>
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

				<span class="is-light-centered-message" v-if="orders.length == 0">{{ trans.translate('Geen bestellingen') }}</span>
			</div>

		</section>
	</div>
</template>

<script>
	export default{
		mounted(){
			Event.$emit('start-loading');
			this.fetchOrders(this.activeType);
		},
		data(){
			return {
				orders: [],
				activeType: 'promo',
				activeStatus: 2,
				trans: Locale
			}
		},
		methods: {
			fetchOrders(type){
				this.activeStatus = 2;
				this.activeType = type;
				this.$http.get('/'+type+'materiaal/orders').then((response) => {
					this.orders = response.data;
					Event.$emit('data-loaded');
				});
			},
			formatDate(date){
				return moment(date).format('D MMMM, YYYY');
			},
			formatCurrency(value){
				return "€"+(value / 100).toFixed(2);
			},
			filterOrders(status){
				this.activeStatus = status;
				this.$http.get('/'+this.activeType+'materiaal/orders/'+status).then((response) => {
					this.orders = response.data;
				});
			},
			showOrderDetail(order_id){
				window.location.href = "/"+this.activeType+"materiaal/detail/"+order_id;
			}
		}
	}

</script>