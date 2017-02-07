<template>
	<div>
		<hero title="Email handtekeningen" :hasSubtitle="false" type="is-blue"></hero>
		<notification></notification>

		<div class="container">

			<section class="section">
				<h3 class="title is-title-centered-message">Functie toevoegen</h3>
				<button v-if="!showFuncties" @click="showFuncties = true" class="button is-primary button-centered">Nieuwe functie toevoegen</button>
				<div class="columns is-horizontally-centered" v-if="showFuncties">
				<div class="column">
					<ul>
						<li v-for="functie in functies">
							<strong>NL</strong> {{ functie.name_nl }} / <strong>FR</strong> {{ functie.name_fr }}
						</li>
					</ul>
				</div>
					<div class="column">
						<div class="form-input">
							<label class="label">Functie (NL)</label>
							<p class="control">
								<input class="input" type="text" placeholder="Functie" v-model="functie_nl">
							</p>
						</div>
						<div class="form-input">
							<label class="label">Functie (FR)</label>
							<p class="control">
								<input class="input" type="text" placeholder="Functie" v-model="functie_fr">
							</p>
						</div>
						<div class="form-input">
							<p class="control">
							<button type="submit" class="button is-primary" @click="saveNewFunction">Opslaan</button>
							</p>
						</div>
					</div>
				</div>
			</section>

			<section class="section">
				<h3 class="title is-title-centered-message">Emailhandtekeningen</h3>
				<ul class="cart-list">
					<li v-for="emailhandtekening in emailhandtekeningen" class="slideInLeft">
						<div class="cart-item-segment">
							<div class="cart-item-amount card-info-item">
								{{ emailhandtekening.id }}
								<span class="anim-circle"></span>
							</div>
							<div class="cart-item-info-name card-info-item">
								{{ emailhandtekening.firstname + " " + emailhandtekening.name }}
							</div>
							<div class="cart-item-info-pack card-info-item">
								{{ emailhandtekening.function }}
							</div>
							<div class="cart-item-controls">
								<a class="button button-round is-primary transitioning-icon" data-lity :data-lity-target="'/images/emailhandtekeningen/'+emailhandtekening.image" style="background:#fff">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-eye"></i>
										<i class="fa fa-eye"></i>
									</span>
								</a>
								<a class="button button-round is-success spin-icon" @click="approveEmailhandtekening(emailhandtekening.id)">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-check"></i>
										<i class="fa fa-check"></i>
									</span>
								</a>
								<a class="button button-round is-danger transitioning-icon" @click="removeEmailhandtekening(emailhandtekening.id)">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-remove"></i>
										<i class="fa fa-trash"></i>
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
			this.getFuncties();
			this.fetchEmailhandtekeningen();
			console.log('admin emailhandtekening initialized');
		},
		data(){
			return{
				emailhandtekeningen: [],
				functie_nl: '',
				functie_fr: '',
				functies: [],
				showFuncties: false
			}
		},
		methods:{
			fetchEmailhandtekeningen(){
				this.$http.get('/admin/emailhandtekeningen/unapproved')
				.then((response) => {
					this.emailhandtekeningen = response.data;
				});
			},
			removeEmailhandtekening(emailhandtekening_id){
				this.$http.get('/emailhandtekeningen/delete/'+emailhandtekening_id)
				.then((response) => {
					Event.$emit('itemRemovedFromCart', { 'message': "Emailhandtekening succesvol verwijderd." });
					this.fetchEmailhandtekeningen();
				});
			},
			saveNewFunction(){
				if(this.functie_nl != "" && this.functie_fr != "")
				{
					this.$http.post('/admin/emailhandtekeningen/function/save', {'functie_nl': this.functie_nl, 'functie_fr': this.functie_fr})
					.then( (response) => {
						this.functie = '';
						Event.$emit('itemAddedToCart', { 'message': "Functie succesvol aangemaakt!" });
						this.getFuncties();
					});
				}
			},
			getFuncties(){
				this.$http.get('/functies').then((response) => {
					this.functies = response.data;
				})
			},
			approveEmailhandtekening(id){
				this.$http.get('/admin/emailhandtekeningen/approve/'+ id)
					.then((response) => {
						console.log('ok');
						this.fetchEmailhandtekeningen();
					});
			}
		}
	}
</script>