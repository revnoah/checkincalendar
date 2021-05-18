<template>
    <div class="wizard">
        <form>
            <div class="inner">
                <div class="step" v-show="step==1">
                    <h3 class="mb-2">Select Template</h3>
                    <p class="info">Get started quickly by using a pre-formatted template or start from scratch.</p>
                    <div class="form-group">
                        <label for="template-id">Template Name</label>
                        <select id="template-id" name="template-id" class="form-control" v-model="templateId" @change="makeFormDirty()">
                            <option v-for="template in templates" :key="template.id" :value="template.id">
                                {{ template.name }} {{ template.id }}
                            </option>
                        </select> 
                    </div>
                </div>
                <div class="step" v-show="step==2">
                    <h3 class="mb-2">Add Treatment</h3>
                    <div class="form-group">
                        <label for="treatment-name">Treatment Name</label>
                        <input id="treatment-name" name="treatment-name" type="text" class="form-control" v-model="treatment.name" @change="makeFormDirty()" autofocus ref="step1" />
                    </div>
                    <div class="form-group">
                        <label for="treatment-logline">Logline</label>
                        <input id="treatment-logline" name="treatment-logline" type="text" class="form-control" v-model="treatment.logline" @change="makeFormDirty()" />                    
                    </div>
                    <div class="form-group">
                        <label for="treatment-synopsis">Synopsis</label>
                        <textarea id="treatment-synopsis" name="treatment-synopsis" class="form-control" v-model="treatment.synopsis" @change="makeFormDirty()"></textarea>
                    </div>
                </div>
                <div class="step" v-show="step==3">
                    <h3 class="mb-2">Setup Lists</h3>
                    <div class="form-group">
                        <label for="list-name">List Name</label>
                        <input id="list-name" name="list-name" type="text" class="form-control" v-model="list.name" @change="makeFormDirty()" ref="step2" />
                    </div>
                    <div class="form-group">
                        <label for="list-number">Number of Lists</label>
                        <input id="list-number" name="list-number" type="text" class="form-control" v-model="list.number" @change="makeFormDirty()" />
                    </div>
                </div>
                <div class="step" v-show="step==4">
                    <h3 class="mb-2">Define Tasks</h3>
                    <div v-for="def in definitions" :key="def.name">
                        <div class="form-group">
                            <input 
                                type="text" 
                                class="form-control" 
                                v-model="def.name" 
                                @change="makeFormDirty()" 
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="definition-name" 
                            name="definition-name" 
                            type="text" 
                            class="form-control" 
                            v-model="definition.name" 
                            v-on:keyup.enter="addDefinition()" 
                            @blur="addDefinition()" 
                            @change="makeFormDirty()" 
                            placeholder="Add Definition"
                            ref="step3" 
                        />
                    </div>
                </div>
                <div class="step" v-show="step==5">
                    <h3 class="mb-2">Add People</h3>
                    <div v-for="peep in people" :key="peep.name">
                        <div class="form-group">
                            <input 
                                type="text" 
                                class="form-control" 
                                v-model="peep.name" 
                                @change="makeFormDirty()" 
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <input id="person-name" 
                            name="person-name" 
                            type="text" 
                            class="form-control" 
                            v-model="person.name" 
                            v-on:keyup.enter="addPerson()" 
                            @blur="addPerson()" 
                            @change="makeFormDirty()" 
                            placeholder="Add Person"
                            ref="step4" 
                        />
                    </div>
                </div>
                <div class="step" v-show="step==6">
                    <h3 class="mb-2">{{ treatment.name }}</h3>
                    <div>
                        <p><strong>Logline</strong>: {{ treatment.logline }}</p>
                        <p><strong>Synopsis</strong>: {{ treatment.synopsis }}</p>
                        <p><strong>{{ list.name }}s</strong>: {{ list.number }}</p>
                        <p><strong>People</strong>:
                            <span v-for="(person, idx) in people" :key="person.name">
                                {{ idx > 0 ? ', ' : '' }}{{ person.name}}
                            </span>
                        </p>
                        <p><strong>Task Definitions</strong>:
                            <span v-for="(definition, idx) in definitions" :key="definition.name">
                                {{ idx > 0 ? ', ' : '' }}{{ definition.name }}
                            </span>
                        </p>
                    </div>
                </div>
                <div v-show="step < 6" class="form-group">
                    <button type="button" name="prev" class="btn btn-secondary" @click="prevCard()">Back</button>
                    <button type="button" name="next" class="btn btn-primary ml-2 float-right" @click="nextCard($event)">Next Step</button>
                </div>
                <div v-show="step == 6" class="form-group">
                    <button type="button" name="prev" class="btn btn-secondary" @click="prevCard()">Back</button>
                    <button type="button" name="next" class="btn btn-primary ml-2 float-right" @click="save()">Finish</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
  props: ['projectId'],
  data() {
    this.loadTemplates();
    return { 
        formDirty: false,
        step: 1,
        project: {
            id: 0,
            name: '',
            description: ''
        },
        templateId: 0,
        treatment: {
            name: '',
            logline: '',
            synopsis: ''
        },
        list: {
            number: 3,
            name: 'Act'
        },
        definition: {
            name: ''
        },
        definitions: [],
        person: {
            name: '',
            email: ''
        },
        people: [],
        templates: []
    }
  },
  created: function() {
    var _this = this;
    window.onbeforeunload = function () {
        if (_this.formDirty) {
            return 'Are you sure? You have unsaved changes.';
        }
    }
  },
  computed: {
  },
  methods: {
    makeFormDirty: function() {
        if (!this.formDirty) {
            this.formDirty = true;
        }
    },
    save: function() {
        console.log('saving project: ' + this.projectId);

      let postData = {
          treatment: this.treatment,
          list: this.list,
          definitions: this.definitions,
          people: this.people,
          templateId: this.templateId
      }

      axios.post('/api/treatments/wizard', postData)
      .then(res => {
        this.formDirty = false;
        this.showField = '';         
      })
      .catch(err => {
        console.log(err)
      });
    },
    cancel: function() {
        this.formDirty = false;
    },
    prevCard: function() {
        this.step--;
        this.stepSettings();
    },
    nextCard: function(ev) {
        this.step++;
        this.stepSettings();
        ev.preventDefault();
    },
    stepSettings: function() {
        //skip directly to review
        if (this.step == 3 && this.templateId > 0) {
            this.step = 6;
        }

        switch (this.step) {
            case 1:
                break;
            case 2:
                if (this.treatment.name == '') {
                    this.treatment.name = this.project.name;
                }
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                break;
            case 6:
                break;
        }
        this.focusInput('step' + this.step);
    },
    focusInput: function (inputRef) {
      // $refs is an object that holds the DOM references to your inputs
      //this.$refs[inputRef].focus();
    },
    addDefinition: function() {
        if (this.definition.name != '') {
            this.definitions.push(this.definition);
            this.definition = {
                name: ''
            };
        }
    },
    addPerson: function() {
        if (this.person.name != '') {
            this.people.push(this.person);
            this.person = {
                name: '',
                email: ''
            };
        }
    },
    loadTemplates: function() {
      axios.get('/api/templates')
      .then(res => {
        this.templates = [...res.data.data]
        return this.templates
      }).catch(err => {
        console.log(err)
      });

    }
  }
}
</script>
<style scoped>
</style>
