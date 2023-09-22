<script setup>
import {Modal} from 'bootstrap';
import axios from 'axios';
import TaskModal from './taskModal.vue';
import { onMounted } from 'vue';


/* export  default{
    data: function () {
        return {
            item: {
                name: ""
            }
        };
    }, 
    
     methods: {
        addItem() {
            if (this.item.name == '')
                return;
            axios.post('api/item/store', {
                item: this.item
            })
                .then(response => {
                if (response.status == 201) {
                    this.item.name = '';
                }
            })
                .catch(error => {
                console.log(error);
            });
        }
    }, 
} */

let modal;
onMounted(() => {
    modal= new Modal(document.getElementById('taskModal'))
})

const showPopup = () => {
    modal.show();
}

const closePopup = () => {
    modal.hide()
}

</script>

<template>
    <!-- <div class="addItem">
        <input type="text" v-model="item.name"/>
        <font-awesome-icon icon="plus-square"
        @click="addItem()" 
        :class="[ item.name ? 'active' : 'inactive' , 'plus']"/>
    </div> -->

    <div>
        <button class="btn btn-primary" @click="showPopup">ADD TASK
            <font-awesome-icon icon="plus-square"
            @click="addItem()" 
            :class="plus"/>
        </button>
        <TaskModal @close-popup="closePopup"></TaskModal>
    </div>
</template>



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