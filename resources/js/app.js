import './bootstrap';

import {createApp} from 'vue';
import App from './vue/allTasks'

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faPlusSquare,faTrash,faEdit } from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(faPlusSquare,faTrash,faEdit)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

createApp(App)
.component('font-awesome-icon', FontAwesomeIcon)
.mount('#app');
