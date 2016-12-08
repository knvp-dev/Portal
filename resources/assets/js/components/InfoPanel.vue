<template>
	<div class="container mb-50">
	  <div class="columns has-text-centered">
		  <div class="column">
		    <div class="info-tile">
		    <span class="fat-cash"><strong class="is-large-size"><i class="fa fa-euro"></i></strong></span>
		    <h2 class="has-padding">Resterend budget</h2>
		    <span class="fat-cash" v-if="noBudget"><strong class="is-medium-size">Deze producten zijn gratis</strong></span>
		    <span class="fat-cash" v-else><i class="fa fa-euro"></i> <strong class="is-medium-size odometer is-budget-odo" id="odometer">{{ remainingBudget }}</strong></span>
		    </div>
		  </div>
		  <div class="column">
		    <div class="info-tile">
		    <span class="fat-cash"><strong class="is-large-size"><i class="fa fa-clock-o"></i></strong></span>
			    <h2 class="has-padding">Interne post vertrekt</h2>
			    <span class="fat-cash"><strong class="is-medium-size"><countdown></countdown></strong></span>
		    </div>
		  </div>
		</div>
	</div>
</template>

<script>
	export default {
		mounted(){
			this.getUserdata();
		},
		props: ["orderPrice", "noBudget"],
		data(){
			return{
				user: '',
				budgetLeft: 0
			}
		},
		methods: {
			getUserdata(){
				this.$http.get('/userdata').then((response) => {
					this.user = response.data;
					console.log(this.user.start_budget);
				});
			},
			animateBudget(amount){
				$('.is-budget-odo').text(amount);
			}
		},
		computed: {
			remainingBudget(){
				var budget = (((this.user.budget / 100) - this.orderPrice)).toFixed(2)
				this.animateBudget(budget);
				return budget;
			},
			budgetPercentage(){
				return Math.round(((this.remainingBudget * 100) / this.user.start_budget) * 100);
			}
		}
	}
</script>