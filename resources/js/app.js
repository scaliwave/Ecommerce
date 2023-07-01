// import './bootstrap';
// import { createApp } from 'vue';
// import VueRouter from 'vue-router';

// // components------------------------------------------------------
// import ProductsList from './components/Products/Index.vue';
// import AllProductsOFCategory from './components/Products/ProducDetails.vue';


// const app = createApp({
// 	components: {
// 		ProductsList
// 	}
// });


// app.mount('#app');

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// components ---------------------------------------------
import ProductsList from './components/Products/Index.vue';
import AllProductsOFCategory from './components/Products/AllProductsOFCategory.vue';

const app = createApp({
  components: {
    ProductsList,
    AllProductsOFCategory
  }
});

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/AllProductsOFCategory/:id',
      name: 'all-products-of-category',
      component: AllProductsOFCategory
    }
  ]
});

app.use(router);

app.mount('#app');
