<template>
  <div class="container-kanban ml-4">

    <div class="kanban-list ml-2 mr-2" v-for="(list, index) in taskLists" :key="list.id">
        <input type="text" v-model="list.name" @blur="renameList(list)" v-on:keyup.enter="renameList(list)" :tabindex="100 + index" class="input-heading mb-2" />

        <div class="list-group" group="tasks" v-dragula="list.tasks" bag="taskbag" :move="movedTask">
            <div class="card mb-4 shadow-sm" v-for="task in list.tasks" :key="task.id">

                <svg class="bd-placeholder-img card-img-top" width="100%" height="40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" v-bind:aria-label="task.name"><rect width="100%" height="100%" v-bind:fill="task.definition.color ? task.definition.color : task.hex"></rect></svg>

                <div class="card-body" @click="editTask(task)">
                    <h4 contenteditable @blur="cardUpdate">{{ task.name }}</h4>
                    <p class="card-text text-muted description">{{ task.description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted" v-if="task.checklist && task.checklist.length > 0">
                          {{ checklistCompleted(task) }} of {{ task.checklist ? task.checklist.length : 0 }} completed
                        </small>
                        <small class="text-muted" v-if="task.people && task.people.length > 0">
                          {{ task.people.length }} {{ task.people.length === 1 ? 'person' : 'people' }}
                        </small>
                    </div>
                </div>
            </div>
            <button slot="footer" v-if="list.tasks.length == 0" @click="removeList(list.id, index)" class="btn btn-secondary btn-add-task mb-3">Remove List</button>
            <button slot="footer" @click="addTask(list.id)" class="btn btn-secondary btn-add-task">Add Task</button>
        </div>
    </div>

    <div class="kanban-list ml-2 mr-2">
        <input type="text" class="input-heading mb-2" v-model="newList" @keyup.enter="addList()" placeholder="New List" />

        <div class="list-group" group="tasks" bag="taskbag">
            <button slot="footer" @click="addList()" class="btn btn-secondary btn-add-task">Add List</button>
        </div>
    </div>

    <div id="modal-overlay" class="modal-overlay" @click="cancelTask()" v-bind:class="{ 'show': showModal }"></div>
    <div id="modal-kanban" class="modal modal-kanban" v-bind:class="{ 'show': showModal }" tabindex="-1" role="dialog" v-on:keyup.esc="saveTask()">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" v-bind:style="{ 'background-color': currentTask.definition ? currentTask.definition.hex : currentTask.hex }">
            <input type="text" v-model="currentTask.name" class="modal-title input-heading" tabindex="100" />
            <button type="button" class="close" @click="cancelTask()" tabindex="199" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body description">
            <form>
              <div class="form-group">
                <label for="description" class="sr-only">Description</label>
                <textarea id="description" name="description" v-model="currentTask.description" class="form-control" tabindex="101"></textarea>
              </div>
              <div class="row">
                <div class="col-6 form-group checklist">
                  <section>
                    <h4 class="mt-3">Checklist</h4>
                    <ul>
                      <li v-for="(item, index) in currentTask.checklist" :key="item.id" class="d-flex align-auto">
                        <input 
                          type="checkbox" 
                          v-model="item.completed" 
                          @click="completeChecklistItem(item)" 
                          class="input-checkbox" 
                        />
                        <input 
                          type="text" 
                          name="newChecklistItem" 
                          v-model="item.name" 
                          v-on:keyup.enter="updateChecklistItem(item)" 
                          @focus="checklistItemFocus(item)"
                          @blur="updateChecklistItem(item)" 
                          class="input-checkbox"
                          :tabindex="110 + index" 
                        />
                      </li>
                      <li class="d-flex align-auto">
                        <input 
                          type="text" 
                          name="newChecklistItem" 
                          v-model="currentChecklistItem.name" 
                          v-on:keyup.enter="addChecklistItem()" 
                          @blur="addChecklistItem()"  
                          class="input-checkbox input-indent"
                          placeholder="Add Item"
                          tabindex="150"                          
                        />
                      </li>
                    </ul>
                  </section>
                </div>
                <div class="col-6">
                  <div class="form-group people">
                    <section>
                      <h4 class="mt-3">Definition</h4>
                      <div class="d-flex definition-list-icons">
                        <select id="definition" class="form-control custom-select" name="definition" v-model="currentTask.definition" @change="changeDefinition">
                          <option selected>None</option>
                          <option v-for="definition in availableDefinitions" :key="definition.id" :value="definition.id">
                            {{ definition.name }}
                          </option>
                        </select>
                      </div>
                    </section>
                  </div>
                  <div class="form-group people">
                    <section>
                      <h4 class="mt-3">People</h4>
                      <div class="d-flex people-list-icons">
                        <div v-for="person in orderedCurrentTaskPeople" :key="person.id" @click="removePerson(person)" class="mb-2 select-person">
                          <person-icon-component v-bind:name="person.name" status="added"></person-icon-component>
                        </div>
                        <div v-for="person in orderedAvailablePeople" :key="person.id" @click="addPerson(person)" @mouseover="hoverPerson()" class="mb-2 select-person">
                          <person-icon-component v-bind:name="person.name" status="available"></person-icon-component>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cancelTask()">Cancel</button>
            <button type="button" class="btn btn-primary" @click="saveTask()">Save Changes</button>
          </div>
        </div>
      </div>
    </div>

    <div id="sidebar-hamburger" @click="toggleSidebar()">
      <span>=</span>
    </div>

    <aside class="sidebar" :class="showSidebar ? 'active' : ''">
      <section>
        <h4>Available People</h4>
        <div v-for="person in orderedAvailablePeople" :key="person.id" @mouseover="hoverPerson()" class="mb-2 d-flex list-person">
          <person-icon-component v-bind:name="person.name" status="available"></person-icon-component>
          <label>{{ person.name }}</label>
        </div>
      </section>

      <section>
        <h4 class="mt-4">Task Definitions</h4>
         <div v-for="definition in availableDefinitions" :key="definition.id">
           <color-label-component v-bind:name="definition.name" v-bind:color="definition.color"></color-label-component>
         </div>
      </section>

      <section>
        <h4>Save New Template</h4>
        <div class="alert alert-info" role="alert" v-show="templateStatus != ''">
          {{ templateStatus }}
        </div>
        <div class="form-group">
          <input type="text" class="form-control form-control-dark" v-model="templateName" name="templateName" id="templateName" placeholder="Template Name" />
        </div>
        <div class="form-group">
          <button @click="saveTemplate()" class="btn btn-primary form-control form-control-dark">Save Template</button>
        </div>
      </section>
    </aside>

  </div>

</template>
<script>
import { VueDragula } from "vue-dragula"
export default {
  props: ['projectId', 'treatmentId'],
  data() {
    this.loadTasks();
    this.loadPeople();
    this.loadDefinitions();
   return {
      name: "task-lists",
      display: "Task Lists",
      order: 1,
      taskLists: [],
      currentTask: {
        people: [],
        definition: {
          hex: '#676767'
        }
      },
      currentField: null,
      currentPersonIdx: null,
      projectPeople: [],
      availablePeople: [],
      projectDefinitions: [],
      availableDefinitions: [],
      currentChecklistItem: {
        id: 0,
        name: ''
      },
      showModal: false,
      showPeople: false,
      showSidebar: false,
      updateTasklists: false,
      templateName: '',
      templateStatus: '',
      newList: ''
    }
  },
  created: function() {
    var _this = this;
    Vue.vueDragula.eventBus.$on('drop', function (args) {
      _this.updateTasklists = true;
    });
    this.interval = setInterval(() => {
      if (this.updateTasklists) {
        this.saveTasklists();
        this.updateTasklists = false;
      }
    }, 4000);
  },
  computed: {
    colWidth: function() {
      return 12 / this.taskLists.length;
    },
    orderedAvailablePeople: function() {
      if (this.currentTask.people === undefined) {
        this.currentTask.people = [];
      }

      let currentTaskPeople = _.orderBy(this.currentTask.people, 'id');
      let availablePeople = _.orderBy(this.availablePeople, 'name');

      var currentTaskPeopleIds = [];
      if (currentTaskPeopleIds !== null) {
        currentTaskPeopleIds = currentTaskPeople.map(function (person) {
          return person.id;
        });
      }

      for (var i = 0; i < availablePeople.length; i++) {
        if (currentTaskPeopleIds.indexOf(availablePeople[i].id) > -1) {
          availablePeople.splice(i, 1);
        }
      }

      return availablePeople;
    },
    orderedCurrentTaskPeople: function() {
      return _.orderBy(this.currentTask.people, 'name');
    },
    personRole: {
      get() {
        console.log(this.currentPersonIdx);
        if (this.currentPersonIdx === undefined || this.currentPersonIdx === null) {
          this.currentPersonIdx = 0;
        }
        if (this.currentTask.people[this.currentPersonIdx].pivot == undefined) {
          return 'tsts';
        }
        return this.currentTask.people[this.currentPersonIdx].pivot.name;
      },
      set(newVal) {
        if (this.currentTask.people[this.currentPersonIdx].pivot == undefined) {
          this.currentTask.people[this.currentPersonIdx].pivot = {};
        }
        this.currentTask.people[this.currentPersonIdx].pivot.name = newVal;
      }
    }
  },
  methods: {
    loadTasks: function() {
      axios.get('/api/treatments/' + this.treatmentId + '/tasks')
      .then(res => {
        var _this = this
        this.taskLists = [...res.data]
        var taskListArray = Object.keys(this.taskLists).map(function (key) { return _this.taskLists[key]; });

        return { 
          taskLists: taskListArray
        }
      }).catch(err => {
        console.log(err)
      });
    },
    loadPeople: function() {
      axios.get('/api/projects/' + this.projectId + '/people')
      .then(res => {
        this.projectPeople = [...res.data]
        this.availablePeople = [...res.data]
        var projectPeopleArray = Object.keys(projectPeople).map(function (key) { return projectPeople[key]; });

        return { 
          projectPeople: projectPeopleArray
        }
      }).catch(err => {
        console.log(err)
      });
    },
    loadDefinitions: function() {
      axios.get('/api/projects/' + this.projectId + '/definitions')
      .then(res => {
        this.projectDefinitions = [...res.data]
        this.availableDefinitions = [...res.data]
        var projectDefinitionArray = Object.keys(projectDefinitions).map(function (key) { return projectDefinitions[key]; });

        return { 
          projectDefinitions: projectDefinitionArray
        }
      }).catch(err => {
        console.log(err)
      });
    },
    saveTasklists: function() {
      const taskListData = [];

      for (const idx in this.taskLists) {
        let taskIds = this.taskLists[idx].tasks.map(function (task) {
          return task.id;
        });
        taskListData.push({
          id: this.taskLists[idx].id,
          tasks: taskIds
        });
      }
      let postData = {
        task_lists: taskListData
      }

      axios.post('/api/treatments/' + this.treatmentId + '/tasks', postData)
      .catch(err => {
        console.log(err)
      });
    },
    addList: function() {
      let postData = {
        name: this.newList
      }

      axios.post('/api/treatments/' + this.treatmentId + '/tasklists', postData)
        .then((response) => {
          console.log(response);

          let newList = {
            treatment_id: this.treatmentId,
            name: this.newList,
            tasks: []
          }

          this.taskLists.push(response.data.data);
          this.newList = '';
        })
      .catch(err => {
        console.log(err)
      });
    },
    removeList: function(id, index) {
      console.log('remove task list');
      console.log(id);

      axios.delete('/api/tasklists/' + id)
        .then((response) => {
          this.taskLists.splice(index, 1);
        })
      .catch(err => {
        console.log(err)
      });
    },
    addTask: function(index) {
      this.currentTask = {};
      this.currentTask.task_list_id = index;
      this.currentTask.projectId = Number(this.projectId);
      this.showPeople = true;
      this.showModal = true;
      document.body.classList.add('no-scroll');
    },
    editTask: function(task) {
      this.currentTask = task; 
      this.showPeople = false;
      this.showModal = true;
      document.body.classList.add('no-scroll');
    },
    cancelTask: function() {
      this.showModal = false;
      this.currentTask = {
        people: [],
        definition: {}
      };
      document.body.classList.remove('no-scroll');
    },
    saveTask: function(el) {
      let postPeople = this.currentTask.people.map(function (person) {
        return person.id;
      });

      var postChecklist = [];
      for(var i = 0; i < this.currentTask.checklist.length; i++) {
        let checklist = {
          name: this.currentTask.checklist[i].name,
          completed: this.currentTask.checklist[i].completed
        }

        postChecklist.push(checklist);
      }

      let postData = {
        project_id: Number(this.projectId),
        task_list_id: this.currentTask.task_list_id,
        definition_id: this.currentTask.definition_id,
        name: this.currentTask.name,
        description: this.currentTask.description,
        people: postPeople,
        checklist: postChecklist
      }

      if (this.currentTask.id > 0) {
        postData.id = this.currentTask.id;

        axios.post('/api/tasks/' + this.currentTask.id, postData)
        .catch(err => {
          console.log(err)
        });
      } else {
        axios.post('/api/tasks', postData)
        .then((response) => {
          //apply id and other api variables          
          this.currentTask.id = response.id;
          //this.currentTask.hex = response.hex;
          //this.currentTask.color = response.hex;

          //add task to list in display
          let taskListIds = this.taskLists.map(function (list) {
            return list.id;
          });
          let taskListIndex = taskListIds.indexOf(this.currentTask.task_list_id);
          this.taskLists[taskListIndex].tasks.push(this.currentTask);
        })
        .catch(err => {
          console.log(err)
        });
      }

      document.body.classList.remove('no-scroll');
      this.showModal = false;
    },
    movedTask: function(el) {
      let taskIds = [];
      for (var i = 0; i < el.relatedContext.list.length; i++) {
        taskIds[i] = el.relatedContext.list[i].id;
      }

      let data = {
        'list_id': el.relatedContext.element.id,
        'list_name': el.relatedContext.element.name,
        'task_ids': taskIds
      }

      axios.post('/api/tasklists/' + this.currentTask.task_list_id, data)
      .catch(err => {
        console.log(err)
      });
    },
    changeDefinition: function() {
      for (var i = 0; i < this.availableDefinitions.length; i++) {
        if (this.availableDefinitions[i].id == this.currentTask.definition) {
          this.currentTask.hex = this.availableDefinitions[i].color;
          this.currentTask.definition_id = this.availableDefinitions[i].id;
          break;
        }
      }
    },
    checklistCompleted: function(task) {
      if (task.checklist === undefined) {
        return 0;
      }

      let completedItems = task.checklist
        .filter(function (item) {
          return item.completed == 1;
        });

      return completedItems.length;
    },
    addPerson: function(person) {
      if (this.currentTask.people == undefined) {
        this.currentTask.people = [];
      }
      this.currentTask.people.push(person);
      this.showPeople = true;
      let personIdx = this.availablePeople.indexOf(person);
      this.availablePeople.splice(personIdx, 1);
    },
    removePerson: function(person) {
      let personIdx = this.currentTask.people.indexOf(person);
      this.currentTask.people.splice(personIdx, 1);
      this.availablePeople.push(person);
    },
    updateCurrentPerson: function(person) {
      this.currentPersonIdx = person.id;
    },
    renameList: function(el) {
      let postData = {
        name: el.name
      }

      axios.post('/api/tasklists/' + el.id, postData)
      .then(res => {
        //console.log(res)
      }).catch(err => {
        console.log(err)
      });
    },
    cardUpdate: function(el) {
      //console.log(el);
    },
    hoverPerson: function(el) {
      //console.log(el);
    },
    addChecklistItem: function() {
      if (this.currentChecklistItem.name != '') {
        if (this.currentTask.checklist == null) {
          this.currentTask.checklist = [];
        }
        let newItem = {
          id: Math.floor(Math.random() * Math.floor(9999)),
          name: this.currentChecklistItem.name,
          completed: false
        }
        this.currentTask.checklist.push(newItem);
        this.currentChecklistItem.name = '';
        this.currentChecklistItem.completed = false;
      }
    },
    updateChecklistItem: function(item) {
      console.log(item)
    },
    checklistItemFocus: function(checklistItem) {
      console.log('got focus');
      if (checklistItem.name == '') {
        console.log('delete this checklist item');
      }
    },
    completeChecklistItem: function(el) {
      //console.log(el);
    },
    setCurrentField: function(thisField) {
      this.currentField = thisField;
    },
    saveTemplate: function() {
      let postData = {
        name: this.templateName
      }

      axios.post('/api/template/' + this.treatmentId, postData)
      .then(res => {
        console.log(res)
        this.templateStatus = 'Template saved'
      }).catch(err => {
        console.log(err)
      });      
    },
    focusInput: function (inputRef) {
      // $refs is an object that holds the DOM references to your inputs
      this.$refs[inputRef].focus();
    },
    toggleSidebar: function(ev) {
      this.showSidebar = !this.showSidebar;
      ev.preventDefault();
    },
    log: function(evt) {
      //window.console.log(evt);
    }
  }
};
</script>

<style scoped>
</style>