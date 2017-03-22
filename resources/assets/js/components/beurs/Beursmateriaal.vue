<template>
	<div>
		<modal 
		v-if="showConfirmationModal" 
		@close="showConfirmationModal = false" 
		@modalconfirmed="placeOrder"
		:hasYesNoOptions="true"
		:body="$root.trans.translate('Bent u zeker dat u deze bestelling wilt plaatsen?')"
		>
	</modal>

	<notification></notification>

	<hero :title="$root.trans.translate('beursmateriaal')" :hasSubtitle="false" type="is-blue">
		<p class="has-padding">
			{{ $root.trans.translate('Vul de datum in van de beurs of het evenement om de beschikbare producten te zien.') }}
		</p>
		<p class="control has-icon has-icon-right is-fixed-width-centered-input " v-if="orderlist.length == 0">
			<datepicker :disabled="{'to': new Date()}"></datepicker>
			<i class="fa fa-calendar"></i>
		</p>
		<h1 class="title has-padding" v-else>{{ $root.trans.translate('Bestelling voor') }} {{ suggestedDate }}</h1>
		<p class="has-padding">{{ $root.trans.translate('Voor welk evenement wilt u dit materiaal bestellen?') }}</p>
		<p class="control has-icon has-icon-right is-fixed-width-centered-input">
			<input class="input is-medium is-transparant-underline-input" type="text" placeholder="" v-model="event">
			<i class="fa fa-location-arrow"></i>
		</p>
	</hero>

	<info-panel orderPrice="0" :noBudget="true"></info-panel>

	<div class="container">

		<alert v-if="event == ''" :close="false">
			{{ $root.trans.translate('U kunt pas bestellen indien u de naam van het evenement invult') }}
		</alert>

		<section class="section" v-if="orderlist.length > 0">

			<ul class="cart-list">
				<li v-for="item in orderlist" class="slideInLeft">
					<div class="cart-item-segment">
						<div class="cart-item-amount card-info-item">
							1
							<span class="anim-circle"></span>
						</div>
						<div class="cart-item-info-name card-info-item">
							<span v-translate-name="item"></span>
						</div>
						<div class="cart-item-controls">
							<a class="button button-round is-danger transitioning-icon" @click="removeItemFromOrder(item)">
								<span class="icon is-small has-stacked-icons has-animation">
									<i class="fa fa-remove"></i>
									<i class="fa fa-trash"></i>
								</span>
							</a>
						</div>
					</div>
				</li>
			</ul>
			<div class="cart-item-segment cart-list-summary" v-if="orderlist.length >= 1">
				<p>{{ $root.trans.translate('totaalprijs') }}: {{ $root.trans.translate('Gratis') }}</p>
				<button v-if="event != ''" class="button is-primary pull-right" @click="showConfirmationModal = true">{{ $root.trans.translate('Bestelling plaatsen') }}</button>
			</p>
		</div>


	</section>
</div>

<section v-if="availableItems.length > 0" class="section text-is-centered">
	<div class="container">
		<div class="heading">
			<h1 class="title is-title-centered-message">{{ $root.trans.translate('Beschikbare producten op') }} {{ suggestedDate }}</h1>
		</div>
		<hr>
		<div class="single-product-card" v-for="item in availableItems">
			<h3 class="has-text-centered"><span v-translate-name="item"></span></h3>
			<div class="single-product-card-image">
				<img :src="'/images/beursmateriaal/'+item.image+'.png'" alt="">
			</div>
			<div class="single-product-card-info">
				<div class="card-info-item">
					<a class="button button-round is-blue transitioning-icon" @click="addItemToOrder(item)">
						<span class="icon is-small has-stacked-icons has-animation">
							<i class="fa fa-shopping-cart"></i>
							<i class="fa fa-plus"></i>
						</span>
					</a>
				</div>
			</div>
		</div>
		<div class="is-clearfix"></div>
	</div>
</section>

<section v-else class="section text-is-centered">
	<div class="container">
		<p class="subtitle">
			<h1 class="is-light-centered-message">{{ $root.trans.translate('Geen datum geselecteerd') }}</h1>
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
				this.suggestedDate = moment(data).format('YYYY-MM-DD');
				this.filterItemsForAvailability();
			});
		},
		data(){
			return{
				suggestedDate: moment().format('YYYY-MM-DD'),
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
					Event.$emit('data-loaded');
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
				Event.$emit('itemAddedToCart', { 'message': this.$root.trans.translate('Het gekozen product werd toegevoegd aan uw winkelmandje') });
			},
			removeItemFromOrder(item){
				this.orderlist.splice(this.orderlist.indexOf(item), 1);
				this.availableItems.push(item);
				Event.$emit('itemRemovedFromCart', { 'message': this.$root.trans.translate('Het gekozen product werd verwijderd uit uw winkelmandje') });
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
							if(this.checkIfDateIsInBetween(moment(this.suggestedDate), moment(data.unavailable_from), moment(data.unavailable_to))){
								item.available = false;
								return true;
							}else{
								item.available = true;
							}
						});
					}else{
						this.availableItems.push(item);
					}

					this.$nextTick(() => {
			            $('.products').imagesLoaded( function() {
			              $('.products').masonry();
			            });
			          });

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
							this.$emit('actionSuccess', this.$root.trans.translate('Uw bestelling werd succesvol geplaatst!'));
						}else{
							this.$emit('actionFailed', this.$root.trans.translate('Er is iets foutgelopen bij het plaatsen van uw bestelling, probeer het later opnieuw!'));
						}
					});
				}.bind(this), 1000);
			}
		}
	}
</script>