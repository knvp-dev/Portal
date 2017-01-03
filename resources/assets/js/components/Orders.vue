<template>
	<div>
		<hero title="Overzicht van alle bestellingen" :hasSubtitle="false" type="is-blue"></hero>

		<div class="container">
			<div class="tabs is-centered mt-50 mb-50">
				<ul>
					<li @click="fetchOrders('promo')" :class="{'is-active': activeType == 'promo'}"><a>Promomateriaal</a></li>
					<li @click="fetchOrders('kantoor')" :class="{'is-active': activeType == 'kantoor'}"><a>Kantoormateriaal</a></li>
					<li @click="fetchOrders('beurs')" :class="{'is-active': activeType == 'beurs'}"><a>Beursmateriaal</a></li>
				</ul>
			</div>

			<div class="filters mb-20 is-clickable">
				<span class="tag" :class="{'is-success': activeStatus == 2}" @click="fetchOrders(activeType)">Alle</span>
				<span class="tag" :class="{'is-success': activeStatus == 0}" @click="filterOrders(0)">In behandeling</span>
				<span class="tag" :class="{'is-success': activeStatus == 1}" @click="filterOrders(1)">Voltooid</span>
			</div>

			<table class="table">
				<thead>
					<tr>
						<th>Bestelnummer</th>
						<th>Aangevraagd op</th>
						<th>Aantal producten</th>
						<th>Prijs</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr v-for="order in orders">
						<td>{{ order.id }}</td>
						<td>{{ formatDate(order.created_at) }}</td>
						<td>{{ order.products.length }} </td>
						<td>{{ (order.total_price) ? formatCurrency(order.total_price) : 'Gratis' }}</td>
						<td v-if="order.completed"><span class="tag is-success is-small is-icon-left"><i class="fa fa-check icon is-small"></i> Verzonden</span></td>
						<td v-else><span class="tag is-small"><i class="fa fa-refresh icon is-small is-icon-left"></i> In behandeling</span></td>
						<td><a @click="showOrderDetail(order.id)">Detail</a></td>
					</tr>

				</tbody>
			</table>
		</div>
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
				activeType: 'promo',
				activeStatus: 2
			}
		},
		methods: {
			fetchOrders(type){
				this.activeStatus = 2;
				this.activeType = type;
				this.$http.get('/'+type+'materiaal/orders').then((response) => {
					this.orders = response.data;
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