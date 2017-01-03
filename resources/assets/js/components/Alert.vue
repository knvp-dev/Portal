<template>

	<section class="section">
	  <div class="notification is-primary has-text-centered">
	  	<button v-if="close" class="delete" @click="$emit('close')"></button>
	  	<slot></slot>
	  </div>
	</section>

</template>

<script>
	export default{
		data(){
			return{
				showAlert: false
			}
		},
		props: ['close']
	}
</script>