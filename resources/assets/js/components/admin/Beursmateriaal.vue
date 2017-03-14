<template>
	<div class="container">
		<section class="section">
			<div id='calendar'></div>
		</section>
	</div>
</template>

<script>
	export default {
		mounted(){
			this.fetchUnvailabilities();
		},
		data(){
			return {
				unavailabilities: [],
				events : []
			}
		},
		methods: {
			fetchUnvailabilities(){
				this.$http.get('/admin/beursmateriaal/unavailabilities/all')
				.then( (response) => {
					this.unavailabilities = response.data;
					this.createEventObjects();
					Event.$emit('data-loaded');
				})
			},
			createEventObjects(){
				_.forEach(this.unavailabilities, (data) => {
					this.events.push({
						title: data.beurs_item.name_nl + ": uitgeleend aan " + data.user.name + " voor: " + data.order.event + " op " + data.order.date_of_use ,
						start: data.unavailable_from,
						allDay: true,
						end: data.unavailable_to
					});
				});
				
				$('#calendar').fullCalendar({
					events: this.events
				});
			}
		}
	}
</script>