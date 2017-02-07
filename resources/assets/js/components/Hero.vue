<template>
	<div class="container-fluid">
	  <section class="hero is-small has-text-centered is-bold" :class="type">
	    <div class="hero-body">
	      <div class="container">
	        <h1 class="title">{{ title }}</h1>
	          <h2 class="subtitle" v-if="hasSubtitle">
	            {{ subtitle }}
	          </h2>
	          <slot></slot>
	      </div>
	    </div>
	  </section>
	</div>
</template>

<script>
	export default{
		props: ['title', 'subtitle', 'type', 'hasSubtitle']
	}
</script>