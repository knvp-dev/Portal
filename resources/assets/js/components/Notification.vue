<template>
	<transition name="fade">
	<div class="notify" v-show="show" :class="state">
		<span class="notify-icon"><i class="fa" :class="icon"></i></span>
		<p class="notify-message">
			{{ message }}
		</p>
	</div>
</transition>
</template>
<script>
	export default {
		data() {
			return {
				show: false,
				message: '',
				icon: 'fa-check',
				state: "notification-blue",
				
			}
		},
		mounted(){
			Event.$on('itemAddedToCart', (product) => {
				this.setNotificationData(
					"fa-check",
					"notification-blue",
					true,
					product.message
				);
			});

			Event.$on('itemRemovedFromCart', (product) => {
				this.setNotificationData(
					"fa-remove",
					"notification-red",
					true,
					product.message
				);
			})
		},
		methods:{
			setNotificationData(icon, state, show, message){
				this.icon = icon;
				this.state = state;
				this.show = show;
				this.message = message;

				setTimeout(
				() => this.show = false,
				3000
				)
			}
		}
	}
</script>

<style>
	.notify{
		border-radius:0;
		border-top-left-radius: 45px;
		border-bottom-left-radius: 45px;
		z-index:1;
		display: flex;
		max-width: 300px;
		font-size:.9em;
		align-items: center;
		position: fixed;
		right: 0px;
		bottom: 100px;
		color: white;
		text-transform: uppercase;
		padding: 15px;
	}

	.notification-blue{
		background-color: #00a3e0!important;
	}

	.notification-red{
		background-color: #FF3860!important;
	}

	.notify-icon{
		padding: 0px 25px 0 10px;
	}

	.fade-enter-active {
		animation: fade-in .5s;
	}
	.fade-leave-active {
		animation: fade-out .5s;
	}
	@keyframes fade-in {
		0% {
			transform: translate(300px,0);
		}
		100% {
			transform: translate(0,0)
		}
	}
	@keyframes fade-out {
		0% {
			transform: translate(0,0)
		}
		100% {
			transform: translate(300px,0);
		}
	}
</style>