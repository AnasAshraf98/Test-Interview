<template>

    <!-- Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Task</h1>
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
                            <label for="date">Task Due Date</label>
                            <input type="date" class="form-control" v-model="taskData.date">
                            <span class="text-danger" v-show="taskErrors.date">Task Due Date is required</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" @click="storeTask" class="btn btn-primary">Submit Task</button>
            </div>
        </div>
  </div>
</div>
</template>
<script>

import axios from 'axios';

export default{
    data: function(){
        return{
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
    methods:{
        storeTask(){
            this.taskData.title == '' ? this.taskErrors.title = true : this.taskErrors.title = false;
            this.taskData.date == '' ? this.taskErrors.date = true : this.taskErrors.date = false;

            if(this.taskData.title && this.taskData.date){
                axios.post('api/item/store',{item:this.taskData})
                .then(response => {
                    this.$emit('load-list');
                })
                .catch(errors =>{
                    console.log(errors);
                })
                .finally(() => {
                    this.$emit('close-popup')
                });
            }
        }
    },
}
</script>

<style scoped>
.addItem{
    display: flex;
    justify-content: center;
    align-items: center;
}
input{
    background: #f7f7f7;
    border: 0px;
    outline: none;
    padding: 5px;
    margin-right: 10px;
    width: 100%;
}
.plus{
    font-size: 20px;
}
.active{
    color: #00ce25;
}
.inactive{
    color: #999999;
}
</style>