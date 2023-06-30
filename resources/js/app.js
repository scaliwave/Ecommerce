import './bootstrap';
import { createApp } from 'vue';

// components------------------------------------------------------
import ProductsList from './components/Products/Index.vue';

const app = createApp({
	components: {
		ProductsList
	}
});


app.mount('#app');
