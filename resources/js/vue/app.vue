<template>
    <div class="todoListContainer">
        <div class="heading">
            <h2 id="title">Todo List</h2>
            <div>
                <button class="btn btn-primary" @click="showPopup">ADD TASK
                    <font-awesome-icon icon="plus-square"/>
                </button>
            </div>
            <task-modal @close-popup="closePopup" @load-list="getList"/>
        </div>
        <list-view @reloadList="getList" :items="items"/>
    </div>
</template>

<script>
import axios from 'axios';
import listView from './listView.vue';
import taskModal from './taskModal.vue';
import {Modal} from 'bootstrap';

let modal;

export default{
   components: {
    taskModal,
    listView,
   },
   data: function(){
        return {
            items:[],
            taskData:{
                title:'',
                note:'',
                date:''
            },
            taskErrors:{
                title:false,
                date:false
            }   
        }
   },
   methods: {
    showPopup(){
        this.taskData={
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
    getList(){
        axios.get('api/items')
        .then(response => {
            this.items = response.data;
        })
        .catch(error => {
            console.log(error);
        })
    }
   },
   created(){
    this.getList()
   },
}
</script>

<style scoped>
.todoListContainer{
    width: 350px;
    margin: auto;
}

.heading{
    background: #e6e6e6;
    padding: 10px;
}

#title{
    text-align: center;
}
</style>