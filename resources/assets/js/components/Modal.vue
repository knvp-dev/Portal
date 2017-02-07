<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
		  <div class="modal-content text-is-centered">
		    <div class="box">
		     <div class="modal-header"></div>
		     <div class="modal-body">
		     	<div class="modal-icon">
		     		<i class="fa" :class="iconType"></i>
		     	</div>
		     	<p>{{ body }}</p>
		     </div>
		     <div class="modal-controls">
			     <div v-if="!isWorking && hasYesNoOptions && !initialActionDone">
			     	<button class="button is-primary" @click="modalConfirmed">{{ trans.translate('Ja ga door') }}</button>
			     	<button class="button is-danger" @click="modalDeclined">{{ trans.translate('Nee') }}</button>
			     </div>
		     	<button class="button is-primary" v-if="canContinue" @click="redirectToOverview()">{{ trans.translate('Ga verder') }}</button>
		     	<div v-if="!isWorking && !canContinue && initialActionDone">
		     		<button class="button is-danger" @click="modalConfirmed">{{ trans.translate('probeer opnieuw') }}</button>
		     		<button class="button" @click="modalDeclined">{{ trans.translate('annuleren') }}</button>
		     	</div>
		     </div>
		    </div>
		  </div>
	  <button class="modal-close" @click="$emit('close')"></button>
	</div>
</template>

<style>
	.modal-icon{
		font-size:2em;
		margin:20px;
	}
	.modal-body, .modal-controls{
		padding:20px;
	}

</style>

<script>
	export default{
		mounted(){
			this.$parent.$on('actionSuccess', (msg) => {
				this.setSuccessState(msg);
			});
			this.$parent.$on('actionFailed', (msg) => {
				this.setFailureState(msg);
			});
		},
		props:['hasYesNoOptions', 'body'],
		data(){
			return{
				initialActionDone: false,
				canContinue: false,
				isWorking: false,
				iconType: "fa-exclamation",
				trans: Locale
			}
		},
		methods:{
			modalConfirmed(){
				this.initialActionDone = true;
				this.$emit('modalconfirmed');
				this.setLoadingState();
			},
			modalDeclined(){
				this.$emit('modaldeclined');
				this.$emit('close');
			},
			setLoadingState(msg){
				this.isWorking = true;
				this.iconType = "fa-gear fa-spin";
				this.body = this.trans.translate('Verzoek verwerken');
			},
			setSuccessState(msg){
				this.isWorking = false;
				this.canContinue = true;
				this.iconType = "fa-check";
				this.body = msg;
			},
			setFailureState(msg){
				this.isWorking = false;
				this.canContinue = false;
				this.iconType = "fa-times";
				this.body = msg;
			},
			redirectToOverview(){
				Event.$emit('close');
				window.location.href = "/overzicht";
			}
		}
	}
</script>