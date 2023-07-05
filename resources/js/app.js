import './bootstrap';
import { createApp } from 'vue';
import vSelect from 'vue-select';

// components------------------------------------------------------
import ProductsList from './components/Products/Index.vue';
import AllProductsList from './components/Products/AllProductsOFCategory.vue';
import ShoppingCart from './components/ShoppingCart/Index.vue';
import ProductsAdmin from './components/AdminProducts/Index.vue';


const app = createApp({
	components: {
		ProductsList,
		AllProductsList,
		ShoppingCart,
		ProductsAdmin
	}
});

app.component('v-select', vSelect)
app.mount('#app');

