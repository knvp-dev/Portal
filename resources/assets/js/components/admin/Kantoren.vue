<template>
	<div>

	<hero title="Overzicht Kantoren" :hasSubtitle="false" type="is-blue"></hero>
	<notification></notification>
		<div class="modal editModal">
			<div class="modal-background"></div>
			<div class="box">
			<div class="modal-content">
				<div class="content">
					<h1>{{ officeToEdit.name }}</h1>
					<hr>
					<div class="form-input">
						<label class="label">Naam</label>
						<p class="control">
							<input class="input" type="text" placeholder="Naam" v-model="officeToEdit.name">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Adres</label>
						<p class="control">
							<input class="input" type="text" placeholder="Adres" v-model="officeToEdit.address">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Postcode</label>
						<p class="control">
							<input class="input" type="text" placeholder="Postcode" v-model="officeToEdit.postalcode">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Gemeente</label>
						<p class="control">
							<input class="input" type="text" placeholder="Gemeente" v-model="officeToEdit.city">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Email</label>
						<p class="control">
							<input class="input" type="text" placeholder="Email" v-model="officeToEdit.email">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Telefoon</label>
						<p class="control">
							<input class="input" type="text" placeholder="Telefoon" v-model="officeToEdit.phone">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Budget (x100)</label>
						<p class="control">
							<input class="input" type="text" placeholder="Budget" v-model="officeToEdit.budget">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Extra ( Food, Logistics, ... )</label>
						<p class="control">
							<input class="input" type="text" placeholder="Extra" v-model="officeToEdit.entity_extra">
						</p>
					</div>
					<div class="form-input">
							<p class="control">
							<button type="submit" class="button is-primary" @click="saveChanges">Opslaan</button>
							<button type="submit" class="button is-text" @click="cancel">annuleren</button>
							</p>
						</div>
				</div>
			</div>
			</div>
			<button class="modal-close"></button>
		</div>
		<div class="container">
			<section class="section">
				<!-- <h3 class="title is-title-centered-message">Kantoren</h3> -->
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
								€{{ (kantoor.budget / 100 ).toFixed(2) }}
							</div>
							<div class="cart-item-info-stock card-info-item">
								{{ kantoor.entity_extra }}
							</div>
							<div class="cart-item-controls">
								<a class="button button-round is-warning transitioning-icon" @click="openEditModal(kantoor)">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-pencil"></i>
										<i class="fa fa-pencil"></i>
									</span>
								</a>
							</div>
						</div>
					</li>
				</ul>
			</section>
		</div>
	</div>
</template>
<script>
	export default {
		mounted(){
			this.fetchKantoren();
			console.log('init');
		},
		data(){
			return{
				kantoren: [],
				officeToEdit: ''
			}
		},
		methods: {
			fetchKantoren(){
				this.$http.get('/admin/kantoren/all')
				.then((response) => {
					console.log(response.data);
					this.kantoren = response.data;
				});
			},
			openEditModal(office){
				this.officeToEdit = office;
				$('.editModal').addClass("is-active");
			},
			saveChanges(){
				this.$http.post('/admin/kantoren/update', {'office': this.officeToEdit})
					.then((response) => {
						console.log('Saved changes');
						$('.editModal').removeClass("is-active");
						Event.$emit('itemAddedToCart', { 'message': this.officeToEdit.name + " werd succesvol geupdated" });
					});
			},
			cancel(){
				$('.editModal').removeClass("is-active");
			}
		}
		
	}
</script>