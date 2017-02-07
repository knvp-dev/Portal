<template>
	<div>
	<hero title="Overzicht Kantoormateriaal" :hasSubtitle="false" type="is-blue"></hero>
	<notification></notification>
		<div class="modal editModal">
			<div class="modal-background"></div>
			<div class="box">
			<div class="modal-content">
				<div class="content">
					<h1>{{ productToEdit.name_nl }}</h1>
					<hr>
					<p>Item code: <strong>{{ productToEdit.code }}</strong></p>
					<div class="form-input">
						<label class="label">Naam (NL)</label>
						<p class="control">
							<input class="input" type="text" placeholder="Naam NL" v-model="productToEdit.name_nl">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Naam (FR)</label>
						<p class="control">
							<input class="input" type="text" placeholder="Naam FR" v-model="productToEdit.name_fr">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Stock</label>
						<p class="control">
							<input class="input" type="text" placeholder="Stock" v-model="productToEdit.stock">
						</p>
					</div>
					<div class="form-input">
						<label class="label">Pakket</label>
						<p class="control">
							<input class="input" type="text" placeholder="Pakket" v-model="productToEdit.pack">
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
				<!-- <h3 class="title is-title-centered-message">Kantoormateriaal</h3> -->
				<ul class="cart-list">
					<li v-for="item in kantoormateriaal" class="slideInLeft">
						<div class="cart-item-segment">
							<div class="cart-item-amount card-info-item">
								{{ item.id }}
								<span class="anim-circle"></span>
							</div>
							<div class="cart-item-info-name card-info-item">
								{{ item.name_nl }}
							</div>
							<div class="cart-item-info-pack card-info-item">
								{{ item.pack }} stuks per pakket
							</div>
							<div class="cart-item-info-stock card-info-item" v-if="item.stock <= 10">
								<strong class="is-red">{{ item.stock }} in stock</strong>
							</div>
							<div class="cart-item-info-stock card-info-item" v-else>
								{{ item.stock }} in stock
							</div>
							<div class="cart-item-controls">
								<a class="button button-round is-warning transitioning-icon" @click="openEditModal(item)">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-pencil"></i>
										<i class="fa fa-pencil"></i>
									</span>
								</a>
								<a class="button button-round is-primary transitioning-icon" data-lity :data-lity-target="'/images/kantoormateriaal/'+item.image+'.png'">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-eye"></i>
										<i class="fa fa-eye"></i>
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
			this.fetchKantoormateriaal();
		},
		data(){
			return{
				kantoormateriaal: [],
				productToEdit: ''
			}
		},
		methods: {
			fetchKantoormateriaal(){
				this.$http.get('/admin/kantoormateriaal/all')
				.then((response) => {
					console.log(response.data);
					this.kantoormateriaal = response.data;
				});
			},
			openEditModal(product){
				this.productToEdit = product;
				$('.editModal').addClass("is-active");
			},
			saveChanges(){
				this.$http.post('/admin/kantoormateriaal/update', {'product': this.productToEdit})
					.then((response) => {
						console.log('Saved changes');
						$('.editModal').removeClass("is-active");
						Event.$emit('itemAddedToCart', { 'message': this.productToEdit.name_nl + " werd succesvol geupdated" });
					});
			},
			cancel(){
				$('.editModal').removeClass("is-active");
			}
		}
		
	}
</script>