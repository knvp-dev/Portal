<template>
	<div>
		<hero :title="$root.trans.translate('overzicht')" :hasSubtitle="false" type="is-blue"></hero>
		<notification></notification>
		<div class="container">
			<section class="section">
				<h3 class="title is-title-centered-message">{{ $root.trans.translate('Emailhandtekening aanmaken') }}</h3>
				<button v-if="!showCreate" @click="showCreate = true" class="button is-primary button-centered">{{ $root.trans.translate('nieuwe emailhandtekening aanmaken') }}</button>
				<transition name="slide">
					<div class="create-emailhandtekening-wrapper" v-show="showCreate">
						<div class="columns is-horizontally-centered">
							<div class="column">
								<form class="signature-form" method="POST" action="/emailhandtekeningen/create" @submit.prevent="createEmailhandtekening">
									<div class="form-input">
										<label class="label">{{ $root.trans.translate('naam') }}</label>
										<p class="control">
											<input class="input" type="text" :placeholder="$root.trans.translate('naam')" v-model="formdata.name">
											<span class="help is-danger" v-if="errors.name">{{ errors.name }}</span>
										</p>
									</div>

									<div class="form-input">
										<label class="label">{{ $root.trans.translate('voornaam') }}</label>
										<p class="control">
											<input class="input" type="text" :placeholder="$root.trans.translate('voornaam')" v-model="formdata.firstname">
											<span class="help is-danger" v-if="errors.firstname">{{ errors.firstname }}</span>
										</p>
									</div>
									<div class="form-input">
										<label class="label">{{ $root.trans.translate('functie') }}</label>
										<p class="control">
											<span class="select">
												<select v-model="formdata.function" @change="checkFunction">
													<option v-for="functie in functies" v-translate-name="functie"></option>
												</select>
											</span>
											<span class="help is-danger" v-if="errors.function">{{ errors.function }}</span>
										</p>
									</div>

									<div class="form-input" v-if="formdata.function == 'Office manager' || formdata.function == 'District manager'">
										<label class="label">GSM ( +32 (0)4xx xx xx xx )</label>
										<p class="control">
											<input class="input" type="text" placeholder="+32 (0)4xx xx xx xx" v-model="formdata.gsm">
											<span class="help is-danger" v-if="errors.gsm">{{ errors.gsm }}</span>
										</p>
									</div>

									<div class="form-input">
										<p class="control">
											<button type="submit" class="button is-primary">{{ $root.trans.translate('indienen') }}</button>
										</p>
									</div>

								</form>
							</div>
							<div class="column">
								<div class="canvas-wrapper">
									<canvas width="448" height="192" id="canvas" style="font-family:opensans;" 
									v-insert-data = "{
										fullname: fullName,
										data: formdata,
										user: user
									}"
									></canvas>
								</div>

							</div>
						</div>
						
					</div>
				</transition>
			</section>

			<section class="section">
				<h3 class="title is-title-centered-message">{{ $root.trans.translate('Emailhandtekeningen') }}</h3>
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
							<div class="cart-item-controls" v-if="emailhandtekening.approved">
								<a class="button button-round is-primary spin-icon" :href="'/emailhandtekeningen/download/'+ emailhandtekening.id">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-download"></i>
										<i class="fa fa-download"></i>
									</span>
								</a>
								<a class="button button-round is-danger transitioning-icon" @click="removeEmailhandtekening(emailhandtekening.id)">
									<span class="icon is-small has-stacked-icons has-animation">
										<i class="fa fa-remove"></i>
										<i class="fa fa-trash"></i>
									</span>
								</a>
							</div>
							<div class="cart-item-controls" v-else>
								<span class="tag is-small"><i class="fa fa-refresh icon is-small is-icon-left"></i> {{ $root.trans.translate('In behandeling') }}</span>
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
		mounted() {
			this.getEmailHandtekeningen();
			this.getUserdata();
			this.getFuncties();
		},
		data() {
			return {
				formdata: {
					name: '',
					firstname: '',
					function: '',
					gsm: ''
				},
				user: [],
				functies: [],
				errors: {},
				emailhandtekeningen: [],
				showCreate: false
			}
		},
		methods: {
			getUserdata(){
				this.$http.get('/userdata').then((response) => {
					this.user = response.data;
				});
			},
			getEmailHandtekeningen(){
				Event.$emit('start-loading');
				this.$http.get('/emailhandtekeningen/get')
				.then((response) => {
					this.emailhandtekeningen = response.data;
					Event.$emit('data-loaded');
				})
			},
			getFuncties(){
				this.$http.get('/functies').then((response) => {
					this.functies = response.data;
				})
			},
			checkFunction(){
				if(this.formdata.function != "Office manager")
				{
					this.formdata.gsm = "";
				}
			},
			createEmailhandtekening(){
				if(this.validateForm()){
					this.$http.post('/emailhandtekeningen/create', {'formdata':this.formdata , 'image': this.createEmailhandtekeningImage()})
					.then((response) => { 
						this.getEmailHandtekeningen();
						Event.$emit('itemAddedToCart', { 'message': this.$root.trans.translate("Emailhandtekening succesvol aangemaakt") });
						this.showCreate = false;
						this.formdata.name = '';
						this.formdata.firstname = '';
						this.formdata.function = '';
						this.formdata.gsm = '';
					})
					.catch((error) => { console.log(error) });
				}
			},
			validateForm(){
				this.errors = {};
				(this.formdata.name == "") ? this.errors.name = this.$root.trans.translate("Uw naam is niet ingevuld") : false ;
				(this.formdata.firstname == "") ? this.errors.firstname = this.$root.trans.translate("Uw voornaam is niet ingevuld") : false;
				(this.formdata.function == "") ? this.errors.function = this.$root.trans.translate("U hebt geen functie gekozen") : false;
				(this.formdata.function == "Office manager" || this.formdata.function == "District manager" && this.formdata.gsm == "") ? this.errors.gsm = this.$root.trans.translate("Uw gsm nummer is niet ingevuld") : false;
				return (_.isEmpty(this.errors)) ? true : false;
			},
			createEmailhandtekeningImage(){
				return document.getElementById("canvas").toDataURL('image/png');
			},
			removeEmailhandtekening(emailhandtekening_id){
				this.$http.get('/emailhandtekeningen/delete/'+emailhandtekening_id)
				.then((response) => {
					Event.$emit('itemRemovedFromCart', { 'message': this.$root.trans.translate("Emailhandtekening succesvol verwijderd") });
					this.getEmailHandtekeningen();
				});
			}
		},
		computed: {
			fullName(){
				return this.formdata.firstname + " " + this.formdata.name;
			}
		},
		directives: {
			insertData: (canvasElement, binding) => {
				var ctx = canvasElement.getContext("2d");

				// Clear the canvas
				ctx.clearRect(0, 0, 448, 192);

				ctx.fillStyle = "white";
				ctx.fillRect(0, 0, canvasElement.width, canvasElement.height);

				var img = new Image;
				img.onload = function() {
					ctx.drawImage(img, -5,42);
				}
				img.src = "/images/emailhandtekeningen_templates/" + binding.value.user.entity + ".png";

	            // Name
	            ctx.fillStyle = "black";
	            ctx.font = "14px opensans_semibold";
	            ctx.fillText(binding.value.fullname, 20, 15);

	            // Function
	            ctx.fillStyle = "black";
	            ctx.font = "14px opensans_italic";
	            ctx.fillText(binding.value.data.function + " " + binding.value.user.name + " " + binding.value.user.entity_extra, 20, 32);

	            // Address
	            ctx.fillStyle = "black";
	            ctx.font = "12px opensans";
	            ctx.fillText(binding.value.user.address +", " + binding.value.user.postalcode +" "+ binding.value.user.city, 171, 83);

	            ctx.fillStyle = "black";
	            ctx.font = "12px opensans";
	            ctx.fillText(binding.value.user.phone, 171, 99);

	            if(binding.value.data.gsm != "")
	            {
	            	ctx.fillStyle = "black";
	            	ctx.font = "12px opensans";
	            	ctx.fillText("• " + binding.value.data.gsm, 278, 99);
	            }

	            ctx.fillStyle = "black";
	            ctx.font = "12px opensans";
	            ctx.fillText(binding.value.user.email +" • www.konvert.be", 171, 115);
	            
	        }
	    }
	}
</script>

<style>
	.canvas-wrapper{
		margin:50px;
		display:flex;
	}

	.form-input{
		padding:10px;
	}

	.signature-form{
		margin:50px;
	}

	.slide-enter-active {
		animation: slide-in .5s;
	}
	.slide-leave-active {
		animation: slide-out .2s;
	}
	@keyframes slide-in {
		0% {
			opacity: 0;
			transform: translate(-300px,0);
		}
		100% {
			opacity: 1;
			transform: translate(0,0)
		}
	}
	@keyframes slide-out {
		0% {
			opacity: 1;
		}
		100% {
			opacity: 0;
		}
	}
</style>