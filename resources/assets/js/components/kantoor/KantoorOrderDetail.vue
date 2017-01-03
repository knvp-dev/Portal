<template>
	<div>
	<hero title="Overzicht bestelling kantoormateriaal" :hasSubtitle="true" :subtitle="'Gesplaatst op '+formatDate(order.created_at)" type="is-blue">
		<div class="tag is-primary" v-if="order.completed">Status: Voltooid</div>
		<div class="tag" v-else>Status: In behandeling</div>
	</hero>
		<div class="container mb-50">
			<section class="section">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Product</th>
							<th>Stuks per pakket</th>
							<th>Aantal</th>
							<th>Totaalprijs</th>
						</tr>
					</thead>

					<tbody>
						<tr v-for="product in order.products">
							<td>{{ product.id }}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.pack }}</td>
							<td>{{ product.pivot.amount }}</td>
							<td>Gratis</td>
						</tr>
					</tbody>
				</table>
				<div class="content">

					<blockquote class="has-2m-lineheight">
						Deze bestelling is gratis
						<span v-if="!order.completed"><button class="button is-danger pull-right">Bestelling annuleren</button></span>
					</blockquote>
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
				order: []
			}
		},
		computed:{
			orderId(){
				return this.id;
			}
		},
		methods:{
			fetchOrderDetails(){
				this.$http.get('/kantoormateriaal/order/detail/'+this.orderId).then( (response) => {
					this.order = response.data;
				});
			},
			formatDate(date){
				return moment(date).format('D MMMM, YYYY');
			}
		}
	}
</script>