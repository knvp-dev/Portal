<template>
	<div>
		<modal 
		v-if="showConfirmationModal" 
		@close="showConfirmationModal = false" 
		@modalconfirmed="placeOrder"
		:hasYesNoOptions="true"
		>
	</modal>

	<hero title="Beursmateriaal" :hasSubtitle="false" type="is-blue">
		<p class="has-padding">
			Vul de datum in van de beurs of het evenement om de beschikbare producten te zien.
		</p>
		
		<p class="control has-icon has-icon-right is-fixed-width-centered-input " v-if="orderlist.length == 0">
			<datepicker :disabled="{'to': new Date()}"></datepicker>
			<i class="fa fa-calendar"></i>
		</p>
		<h1 class="title has-padding" v-else>Bestelling voor {{ suggestedDate }}</h1>
		<p class="has-padding">Voor welk evenement wilt u dit materiaal bestellen?</p>
		<p class="control has-icon has-icon-right is-fixed-width-centered-input ">
			<input class="input is-medium is-transparant-underline-input" type="text" placeholder="" v-model="event">
			<i class="fa fa-location-arrow"></i>
		</p>
	</hero>



	<div class="container mb-50">

		<alert v-if="event == ''" :close="false">
			U kunt pas bestellen indien u de naam van het evenement invult.
		</alert>

		<info-panel user="username" :noBudget="true"></info-panel>

		<section class="section" v-if="orderlist.length > 0">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Product</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<tr v-for="item in orderlist">
						<td>{{ item.id }}</td>
						<td>{{ item.name }}</td>
						<td>
							<button class="button is-danger" @click="removeItemFromOrder(item)">
								<span class="icon is-small has-icon">
									<i class="fa fa-remove"></i>
								</span>
							</button>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="content">

				<blockquote class="has-2m-lineheight">
					U heeft <strong>{{ orderlist.length }}</strong> product(en) geselecteerd voor een evenement op <strong>{{ suggestedDate }}</strong>.
					<span v-if="event != ''"><button class="button is-primary pull-right" @click="showConfirmationModal = true">Bestelling plaatsen</button></span>
				</blockquote>
			</div>
		</section>
	</div>

	<section v-if="availableItems.length > 0" class="section text-is-centered">
		<div class="container">
			<div class="heading">
				<h1 class="title">Beschikbare producten op {{ suggestedDate }}</h1>
			</div>
			<hr>
			<div class="card product-card" v-for="item in availableItems">
				<div class="card-image">
					<figure class="image is-4by4">
						<img :src="'/images/promomateriaal/shoppertas.png'" alt="">
					</figure>
				</div>

				<div class="card-content">
					<div class="content">
						{{ item.name }}
						<br>	
					</div>
				</div>

				<footer class="card-footer">
					<a class="card-footer-item is-primary" @click="addItemToOrder(item)">Toevoegen</a>
				</footer>
			</div>
			<div class="is-clearfix"></div>
		</div>
	</section>

	<section v-else class="section text-is-centered">
		<div class="container">
			<p class="subtitle">
				<h1 class="title">Er zijn geen beschikbare producten gevonden</h1>
			</p>
		</div>
	</section>


</div>
</template>

<script>
	export default{
		mounted(){
			this.fetchItems();

			Event.$on('selected', (data) => {
				this.suggestedDate = moment(data).format('DD-MM-YYYY');
				this.filterItemsForAvailability();
			});
		},
		data(){
			return{
				suggestedDate: moment().format('DD-MM-YYYY'),
				beursmateriaal: [],
				availableItems: [],
				orderlist: [],
				showConfirmationModal: false,
				event: ''
			}
		},
		methods:{
			fetchItems(){
				this.$http.get('/beursmateriaal/get').then((response) => {
					this.beursmateriaal = response.body;
				});
			},
			weekOfMonth(m) {
				console.log(m.isoWeek() - moment(m).startOf('month').week() + 1 );
			},
			getMondays() {
				var d = new Date(),
				month = d.getMonth(),
				mondays = [];
				var index = 1;

				d.setDate(1);

			    // Get the first Monday in the month
			    while (d.getDay() !== 1) {
			    	d.setDate(d.getDate() + 1);
			    }

			    // Get all the other Mondays in the month
			    while (d.getMonth() === month) {
			    	mondays.push({"number": index, "date": new Date(d.getTime())});
			    	d.setDate(d.getDate() + 7);
			    	index++;
			    }

			    return mondays;
			},
			addItemToOrder(item){
				this.orderlist.push(item);
				this.availableItems.splice(this.availableItems.indexOf(item), 1);
			},
			removeItemFromOrder(item){
				this.orderlist.splice(this.orderlist.indexOf(item), 1);
				this.availableItems.push(item);
			},
			checkIfDateIsInBetween(givenDate, startDate, endDate){
				return moment(givenDate).isBetween(startDate, endDate);
			},
			filterItemsForAvailability(){

				this.availableItems = [];

				_.forEach(this.beursmateriaal, (item) => {
					if(item.unavailability.length > 0){
						_.some(item.unavailability, (data) => {
							item.available = true;
							if(this.checkIfDateIsInBetween(this.suggestedDate, data.unavailable_from, data.unavailable_to)){
								item.available = false;
								return true;
							}else{
								item.available = true;
							}
						});
					}else{
						this.availableItems.push(item);
					}

				});

				_.some(this.beursmateriaal, (item) => {
					if(item.available){
						this.availableItems.push(item);
					}
					
				});
			},
			placeOrder(){
				setTimeout(function () { 
					this.$http.post('/beursmateriaal/order/create', {'orderitems': this.orderlist, 'date': this.suggestedDate, 'event': this.event }).then((response) => {
						if(response){
							this.$emit('actionSuccess', "Uw bestelling werd successvol geplaatst!");
						}else{
							this.$emit('actionFailed', "Er is iets foutgelopen bij het plaatsen van uw bestelling, probeer het later opnieuw!");
						}
					});
				}.bind(this), 1000);
			}
		}
	}
</script>