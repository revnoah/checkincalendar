<template>
    <div>
        <div v-if="!formEdit" @click="toggleSelection('name')" class="form-toggle">
            <h3 v-if="showField!='name'">{{ name }}</h3>
            <h5 class="mt-2">{{ logline }}</h5>
            <h4 class="mt-2">Synopsis</h4>
            <p>{{ synopsis }}</p>
        </div>
        <form v-if="formEdit">
            <div class="form-group">
                <input @change="makeFormDirty()" type="text" ref="treatment-name" v-model="name" class="form-control form-control-dark" tabindex="10" />
            </div>
            <div class="form-group">
                <h4 class="mt-2">Logline</h4>
                <textarea id="logline" name="logline" @change="makeFormDirty()" v-model="logline" class="form-control form-control-dark" tabindex="11"></textarea>
            </div>
            <div class="form-group">
                <h4 class="mt-2">Synopsis</h4>
                <textarea id="synopsis" name="synopsis" @change="makeFormDirty()" v-model="synopsis" class="form-control form-control-dark" tabindex="12"></textarea>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-secondary" @click="cancel()">Cancel</button>
                <button type="button" class="btn btn-primary" :disabled="!formDirty" @click="save()">Save Changes</button>
            </div>
        </form>
    </div>
</template>
<script>
export default {
  props: ['treatmentId', 'name', 'logline', 'synopsis'],
  data() {
    return { 
      showField: false,
      formEdit: false,
      formDirty: false,
      originalValues: {}
    }
  },
  created: function() {
    this.originalValues = {
        name: this.name,
        logline: this.logline,
        synopsis: this.synopsis
    }        
  },
  computed: {
  },
  methods: {
    toggleSelection: function(fieldName) {
        this.formEdit = true;
        this.showField = fieldName;
        this.$refs.treatment-name.focus();
    },
    clearSelection: function() {
        this.showField = '';
    },
    makeFormDirty: function() {
        if (!this.formDirty) {
            this.formDirty = true;
        }
    },
    save: function() {
      let postData = {
        name: this.name,
        logline: this.logline,
        synopsis: this.synopsis
      }

      axios.post('/api/treatments/info/' + this.treatmentId, postData)
      .then(res => {
        this.formEdit = false;
        this.showField = '';         
      })
      .catch(err => {
        console.log(err)
      });
    },
    cancel: function() {
        this.name = this.originalValues.name;
        this.logline = this.originalValues.logline;
        this.synopsis = this.originalValues.synopsis;

        this.formEdit = false;
        this.showField = '';
    }
  }
}
</script>
<style scoped>
</style>
