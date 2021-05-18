<template>
    <div class="d-flex color-label mb-2">
        <div v-bind:style="{ backgroundColor: color }" class="mr-2"></div>
        <label>{{ name }}</label>
    </div>
</template>
<script>
export default {
  props: ['name', 'color'],
  data() {
    return { }
  },
  computed: {
    colors: function() {
        let colors = {
            background: this.color,
            foreground: 'white'
        }
        return colors
    }
  },
  methods: {
    hoverColor: function() {
        
    }
  }
}
</script>
<style scoped lang="scss">
.color-label {
	div {
		width: 50px;
		height: 50px;
        min-width: 50px;
        display: block;
        cursor: pointer;
        border-radius: 25px;
    }
    label {
        margin-top: 10px;
    }
}
</style>
