<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark">
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="text-light float-start">Todo List</h5>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-danger me-2">{{ numberOfRemainingTasks }} Remaining</button>
                            <button class="btn btn-success">{{ numberOfCompletedTasks }} Completed</button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm float-end" @click="showPopup">ADD TASK
                                <font-awesome-icon icon="plus-square"/>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Title</th>
                                    <th>Note</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in items" :key="index" :class="[item.completed ? 'completed' : '']">
                                    <td>
                                        <input type="checkbox" @change="updateCheck(item)" 
                                        :value="item.id"
                                        :checked="item.completed">
                                    </td>
                                    <td>{{ item.title }}</td>
                                    <td>{{ item.note }}</td>
                                    <td>{{ item.due_date }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm me-2" @click="editItem(item)">Edit</button>
                                        <button class="btn btn-danger btn-sm" @click="removeItem(item)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

            
             <!-- Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ !editMode ? 'Add Task' : 'Edit Task' }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" class="form-control" v-model="taskData.title">
                                <span class="text-danger" v-show="taskErrors.title">Task Title is required</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="note">Task Notes</label>
                                <textarea class="form-control" rows="3" v-model="taskData.note"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="due_date">Task Due Date</label>
                                <input type="date" class="form-control" v-model="taskData.date">
                                <span class="text-danger" v-show="taskErrors.date">Task Due Date is required</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click= "!editMode ? storeTask() : editTask()" class="btn btn-primary"> {{ !editMode ? 'Submit Task' : 'Edit Task' }}</button>
                </div>
            </div>
        </div>
    </div>
        

</template>

<script>
import {Modal} from 'bootstrap';
import axios from 'axios';

let modal;

export default{
    data: function(){
        return {
            editMode:false,
            items:[],
            accept:[],
            taskData:{
                id:'',
                title:'',
                note:'',
                date:''
            },
            taskErrors:{
                title:false,
                date:false
            },
            numberOfCompletedTasks:0, 
            numberOfRemainingTasks:0
        }
   },
   mounted(){
    this.getList()
   },
    methods: {
        completedTasks(){
            axios.get('/api/completed')
            .then(response => {
                this.numberOfCompletedTasks = response.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        remainedTasks(){
            axios.get('/api/remained')
            .then(response => {
                this.numberOfRemainingTasks = response.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        showPopup(){
            this.editMode=false;
            this.taskData={
                id:'',
                title:'',
                note:'',
                date:''
            }
            this.taskErrors={
                title:false,
                date:false
            }
            modal= new Modal(document.getElementById('taskModal'))
            modal.show();
        },
        closePopup(){
            modal.hide()
        },
        checkDate(){
            axios.get('api/checkDate')
            .then(response => {
                //console.log(response);
            })
            .catch(error => {
                console.log(error);
            })
        },
        getList(){
            this.checkDate()
            this.remainedTasks()
            this.completedTasks()
            axios.get('api/items')

            .then(response => {
                this.items = response.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        storeTask(){
            this.taskData.title == '' ? this.taskErrors.title = true : this.taskErrors.title = false;
            this.taskData.date == '' ? this.taskErrors.date = true : this.taskErrors.date = false;

            if(this.taskData.title && this.taskData.date){
                axios.post('api/item/store',{item:this.taskData})
                .then(response => {
                    this.getList()
                })
                .catch(errors =>{
                    console.log(errors);
                })
                .finally(() => {
                    this.closePopup()
                });
            }
        },
        editTask(){
            this.taskData.title == '' ? this.taskErrors.title = true : this.taskErrors.title = false;
            this.taskData.date == '' ? this.taskErrors.date = true : this.taskErrors.date = false;

            if(this.taskData.title && this.taskData.date){
                axios.put('api/item/edit/' + this.taskData.id,{item:this.taskData})
                .then(response => {
                    this.getList()
                })
                .catch(errors =>{
                    console.log(errors);
                })
                .finally(() => {
                    this.closePopup()
                });
            }
        },
        updateCheck(item){
            axios.put('api/item/' + item.id,{
                item:item,
            })
            .then(response => {
                if(response.status == 200){
                    this.getList()
                }
            })
            .catch(error => {
                console.log(error);
            })
        },
        removeItem(item){
            axios.delete('api/item/' + item.id)
            .then(response => {
                if(response.status == 200){
                    this.getList()
                }
            })
            .catch(error => {
                console.log(error);
            })
        },
        editItem(item){
            this.editMode=true;
            this.taskData={
                id:item.id,
                title:item.title,
                note:item.note,
                date:item.due_date
            }
            this.taskErrors={
                title:false,
                date:false
            }

            modal= new Modal(document.getElementById('taskModal'))
            modal.show();
        },
    },
}
</script>

<style>
.completed{
    text-decoration: line-through;
    color: #999999;
}
</style>