<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
		  <div class="modal-content text-is-centered animated fadeIn">
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
			     	<button class="button is-primary is-outlined" @click="modalConfirmed">Yes</button>
			     	<button class="button is-danger is-outlined" @click="modalDeclined">No</button>
			     </div>
		     	<button class="button is-primary is-outlined" v-if="canContinue" @click="$emit('close')">Continue</button>
		     	<div v-if="!isWorking && !canContinue && initialActionDone">
		     		<button class="button is-danger is-outlined" @click="modalConfirmed">Try again</button>
		     		<button class="button is-outlined" @click="modalDeclined">Cancel</button>
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
		props:['hasYesNoOptions'],
		data(){
			return{
				body: "Bent u zeker dat u deze bestelling wilt plaatsen?",
				initialActionDone: false,
				canContinue: false,
				isWorking: false,
				iconType: "fa-exclamation"
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
				this.body = "Verzoek verwerken...";
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
			}
		}
	}
</script>