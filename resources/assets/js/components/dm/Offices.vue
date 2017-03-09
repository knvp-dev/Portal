<template>
	<div class="container">

	<div class="modal editModal">
			<div class="modal-background"></div>
			<div class="box">
			<div class="modal-content">
				<div class="content">
					<h1>{{ officeToEdit.name }}</h1>
					<hr>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('naam') }}</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('naam')" v-model="officeToEdit.name">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('adres') }}</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('adres')" v-model="officeToEdit.address">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('postcode') }}</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('postcode')" v-model="officeToEdit.postalcode">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('gemeente') }}</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('gemeente')" v-model="officeToEdit.city">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('email') }}</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('email')" v-model="officeToEdit.email">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('telefoon') }}</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('telefoon')" v-model="officeToEdit.phone">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('budget') }} (x100)</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('budget')" v-model="officeToEdit.budget">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('advertisement budget') }} (x100)</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('advertisement budget')" v-model="officeToEdit.advertisement_budget">
						</p>
					</div>
					<div class="form-input">
						<label class="label">{{ $root.trans.translate('extra') }} ( Food, Logistics, ... )</label>
						<p class="control">
							<input class="input" type="text" :placeholder="$root.trans.translate('extra')" v-model="officeToEdit.entity_extra">
						</p>
					</div>
					<div class="form-input">
							<p class="control">
							<button type="submit" class="button is-primary" @click="saveChanges">{{ $root.trans.translate('opslaan') }}</button>
							<button type="submit" class="button is-text" @click="cancel">{{ $root.trans.translate('annuleren') }}</button>
							</p>
						</div>
				</div>
			</div>
			</div>
			<button class="modal-close"></button>
		</div>

		<section class="section">
			<h1 class="title is-title-centered-message">{{ $root.trans.translate('Budgetten') }}</h1>
			<canvas id="myChart" width="1500" height="300"></canvas>
		</section>

		<section class="section">
			<h3 class="title is-title-centered-message">{{ $root.trans.translate('mijn kantoren') }}</h3>
			<ul class="cart-list">
				<li v-for="kantoor in kantoren" class="slideInLeft">
					<div class="cart-item-segment">
						<div class="cart-item-amount card-info-item">
							{{ kantoor.id }}
							<span class="anim-circle"></span>
						</div>
						<div class="cart-item-info-name card-info-item">
							{{ kantoor.name }}
						</div>
						<div class="cart-item-info-pack card-info-item">
							{{ kantoor.address }}
						</div>
						<div class="cart-item-info-stock card-info-item">
							{{ kantoor.phone }}
						</div>
						<div class="cart-item-info-stock card-info-item">
							{{ kantoor.entity_extra }}
						</div>
						<div class="cart-item-controls">
							<a class="button button-round is-warning transitioning-icon" @click="showOfficeOrders(kantoor)">
								<span class="icon is-small has-stacked-icons has-animation">
									<i class="fa fa-shopping-cart"></i>
									<i class="fa fa-shopping-cart"></i>
								</span>
							</a>
							<a class="button button-round is-primary transitioning-icon" @click="showOfficeDetails(kantoor)">
								<span class="icon is-small has-stacked-icons has-animation">
									<i class="fa fa-cog"></i>
									<i class="fa fa-cog"></i>
								</span>
							</a>
						</div>
					</div>
				</li>
			</ul>
		</section>

		<dm-orders :office="selectedOffice"></dm-orders>
		
	</div>
</template>
<script>
	export default{
		mounted(){
			this.fetchOffices();
		},
		data(){
			return{
				kantoren: [],
				orders: [],
				data: [],
				selectedOffice: '',
				officeToEdit: ''
			}
		},
		methods:{
			fetchOffices(){
				this.$http.get('/dm/offices').then((response) => {
					this.kantoren = response.data;
					this.selectedOffice = this.kantoren[0];
					this.officeToEdit = this.kantoren[0];
					let that = this;
					let names = [];
					let dat = [];
					let adv = [];

					_.forEach(this.kantoren, function(value){
						let budget = value.budget/100;
						let advertisement_budget = value.advertisement_budget/100;
						dat.push(budget);
						adv.push(advertisement_budget);
						names.push(value.name);
					});

					that.data.push({
							type: 'bar',
							label: "Budget",
							data: dat,
							backgroundColor: '#00a3e0'
						},
						{
							type: 'bar',
							label: "Advertisement budget",
							data: adv,
							backgroundColor: '#C4373C'
						});

					let ctx = document.getElementById("myChart").getContext("2d");

					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: names,
							datasets: that.data
						}
					});

				});
			},
			showOfficeOrders(kantoor){
				this.selectedOffice = kantoor;
			},
			showOfficeDetails(office){
				this.officeToEdit = office;
				$('.editModal').addClass("is-active");
			},
			saveChanges(){
				console.log(this.officeToEdit);
				this.$http.post('/dm/kantoren/update', {'office': this.officeToEdit})
					.then((response) => {
						console.log('Saved changes');
						$('.editModal').removeClass("is-active");
					});
			},
			cancel(){
				$('.editModal').removeClass("is-active");
			}
		}
	}
</script>