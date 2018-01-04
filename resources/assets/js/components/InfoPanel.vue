<template>
	<div class="container-fluid mb-50 has-shadow">
	  <div class="columns has-text-centered columns-panel">
	  
		  <div class="column">
		    <div class="info-tile">
		    <span class="fat-cash"><strong class="is-large-size"><i class="fa fa-clock-o"></i></strong></span>
			    <h2 class="has-padding">{{ day }}</h2>
			    <span class="fat-cash"><strong class="is-medium-size">{{ time }}</strong></span>
		    </div>
		  </div>

		  <div class="column">
		    <div class="info-tile">
		    <span class="fat-cash"><strong class="is-large-size"><i class="fa fa-euro"></i></strong></span>
		    <h2 class="has-padding">{{ $root.trans.translate('Resterend budget') }}</h2>
		    <span class="fat-cash" v-if="noBudget"><strong class="is-medium-size">{{ $root.trans.translate('Deze producten zijn gratis') }}</strong></span>
		    <span class="fat-cash budgetcount animated" v-else><i class="fa fa-euro"></i> <strong class="is-medium-size odometer is-budget-odo" id="odometer">{{ remainingBudget }}</strong></span>
		    </div>
		  </div>

		  <div class="column">
		    <div class="info-tile">
		    <span class="fat-cash"><strong class="is-large-size"><i class="fa fa-facebook"></i></strong></span>
			    <h2 class="has-padding">{{ $root.trans.translate('Resterend facebook budget') }}</h2>
			    <span class="fat-cash"><i class="fa fa-euro"></i> <strong class="is-medium-size odometer is-advertisement-budget-odo" id="odometer">{{ remainingAdvertisementBudget }}</strong></span>
		    </div>
		  </div>

		</div>
	</div>
</template>

<script>
	export default {
		mounted(){
			window.setInterval( () => {
				this.time = moment().format("HH:mm:ss");
				this.day = moment().format("DD MMMM, YYYY");
			}, 1000);
			this.getUserdata();
			Event.$on('not-enough-budget', () => {
				$('.budgetcount').addClass("shake").delay(1500).queue(function() {  // Wait for 1.5 seconds.
		            $('.budgetcount').removeClass("shake").dequeue();
		        });
			});
		},
		props: ["orderPrice", "noBudget"],
		data(){
			return{
				user: {},
				budgetLeft: 0,
				advertisement_budget: 0,
				day: moment().format("DD MMMM, YYYY"),
				time: moment().format("HH:mm:ss")
			}
		},
		methods: {
			getUserdata(){
				this.$http.get('/userdata').then((response) => {
					this.user = response.data;
				});
			},
			animateBudget(amount){
				$('.is-budget-odo').text(amount);
			},
			animateAdvertisementBudget(amount){
				$('.is-advertisement-budget-odo').text(amount);
			}
		},
		computed: {
			remainingBudget(){
				var budget = (((this.user.budget / 100) - this.orderPrice)).toFixed(2)
				if(budget <= 0){
					budget = 0;
				}
				this.animateBudget(budget);
				return budget;
			},
			budgetPercentage(){
				return Math.round(((this.remainingBudget * 100) / this.user.start_budget) * 100);
			},
			remainingAdvertisementBudget(){
				var budget = (this.user.advertisement_budget / 100).toFixed(2);
				if(budget <= 0){
					budget = 0;
				}
				this.animateAdvertisementBudget(budget);
				return budget;
			},
			advertisementBudgetPercentage(){
				return Math.round(((this.remainingAdvertisementBudget * 100) / this.user.advertisement_start_budget) * 100);
			}
		}
	}
</script>