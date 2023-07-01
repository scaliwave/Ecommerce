<template>
	<div class="container-responsive">
		<div class="row my-5" v-for="(products, index) in productsByCategory" :key="index">
			<div class="d-flex align-items-center">
				<h3>{{ index }}</h3>
				<a href="" class="mx-2">Ver más</a>
			</div>

			<div v-for="product in products" :key="product.id" class="d-flex col card mx-2" @click="getEvent(product.id)">
				<div class="container">
					<img src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
						class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
						alt="">
					<div>
						<hr>
						<h4>$ {{ getNumberFormat(product.price)}}</h4>
						{{ product.name }}

					</div>
					<i class="bi bi-cart3"></i>
				</div>
			</div>
		</div>

		<section v-if="load_modal">
			<Modal :content="content" :productId="productId"/>
		</section>
	</div>
</template>

<script>
import Modal from './Modal.vue';

export default {
	components: {
		Modal
	},
	data() {
		return {
			productsByCategory: {},
			load_modal: false,
			modal: null,
			content: null,
			productId: null,
		}
	},
	created() {
		this.index()
	},
	methods: {
		async index() {
			try {
				const { data } = await axios.get('Products/GetProductsByCategory');
				this.productsByCategory = data;
			} catch (error) {
				console.error(error);
			}
		},
		getEvent(productIndex) {
			this.productId = productIndex
			this.content = 'productDetails'
			this.load_modal = true

			setTimeout(() => {
				this.modal = new bootstrap.Modal(document.getElementById('product_modal'), {
					keyboard: false,
				})
				this.modal.show()
			}, 200)

		},
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		}
	}

}
</script>

