<template>
    <div class="item">
        <input type="checkbox" @change="updateCheck()" v-model="item.completed">
        <span :class="[item.completed ? 'completed' : '' , 'ItemText']"> {{ item.title }} </span>
        <button @click="removeItem()" class="trashcan">
            <font-awesome-icon icon="trash"/>
        </button>
        <button @click="editItem(item)">
            <font-awesome-icon icon="edit" />
        </button>
    </div>
</template>

<script>
import axios from 'axios';
import taskModal from './taskModal.vue';
import {Modal} from 'bootstrap';

let modal;

export default{
    props:['item'],
    data: function(){
        return{
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
    methods:{
        updateCheck(){
            axios.put('api/item/' + this.item.id,{
                item:this.item,
            })
            .then(response => {
                if(response.status == 200){
                    this.$emit('itemChanged');
                }
            })
            .catch(error => {
                console.log(error);
            })
        },
        removeItem(){
            axios.delete('api/item/' + this.item.id)
            .then(response => {
                if(response.status == 200){
                    this.$emit('itemChanged');
                }
            })
            .catch(error => {
                console.log(error);
            })
        },
        editItem(item){
            this.taskData={
                title:item.title,
                note:item.note,
                date:item.date
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
.itemText{
    width: 100%;
    margin-left: 20px;
}
.item{
    display: flex;
    justify-content: left;
    align-items: center;
}
.trashcan{
    background: #e6e6e6;
    border: none;
    color: #ff0000;
    outline: none;
}
</style>