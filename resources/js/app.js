import './bootstrap';
import { createApp } from 'vue';
import vSelect from 'vue-select';

// components------------------------------------------------------
import ProductsList from './components/Products/Index.vue';
import AllProductsOFCategory from './components/Products/AllProductsOFCategory.vue';
import ShoppingCart from './components/ShoppingCart/Index.vue';


const app = createApp({
	components: {
		ProductsList,
		AllProductsOFCategory,
		ShoppingCart
	}
});

app.component('v-select', vSelect)
app.mount('#app');

