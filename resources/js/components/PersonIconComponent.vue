<template>
    <div data-toggle="tooltip" data-placement="bottom" v-bind:title="name">
        <svg class="bd-placeholder-img mr-2" 
            width="50" height="50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" 
            focusable="false" role="img" aria-label="User icon"
            >
            <g>
                <circle cx="25" cy="25" r="25" v-bind:fill="colors.background"></circle>
                <text 
                    x="25" 
                    y="31" 
                    text-anchor="middle" 
                    alignment-baseline="central" 
                    class="initials" 
                    v-bind:fill="colors.foreground"
                >{{ initials }}</text>
            </g>
        </svg>
    </div>
</template>
<script>
export default {
  props: ['name', 'status', 'image'],
  data() {
    return { }
  },
  computed: {
    colors: function() {
        let colors = {}
        if (this.status == 'added') {
            colors = {
                background: 'black',
                foreground: 'white'
            }
        } else {
            colors = {
                background: 'lightgrey',
                foreground: 'white'
            }
        }
        return colors
    },
    initials: function() {
        let words = this.name.split(/[- ]+/)
        let letters = words[0].substr(0, 1)
        if (words.length > 1) {
            letters += words[words.length - 1].substr(0, 1)
        }
        return letters.toUpperCase()
    }
  },
  methods: {
    toggleSelection: function() {
    }
  }
}
</script>
<style scoped>
    .initials {
        font-size: 20px;
        font-weight: 600;
    }
</style>
