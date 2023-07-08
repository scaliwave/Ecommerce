<template>
	<div class="container">
		<div class="row my-5" v-for="(products, index) in productsByCategory" :key="index">
			<div class="d-flex align-items-center mb-2">
				<h3>{{ index }}</h3>
				<a @click="getAllProducts(index)" class="mx-2 text-decoration-none" style="cursor: pointer">
					<h6>Ver todas</h6>
				</a>
			</div>

			<div v-for="product in products" :key="product.id" class="col-md card mx-2" @click="openModal(product.id)"
				style="cursor: pointer">
				<div class="row mt-3">
					<img v-if="(product.image)" :src="'/storage/images/' + product.image" alt="producto" class="img-fluid">
					<img v-else
						src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
						alt="producto" class="img-fluid">
				</div>
				<div class="my-3">
					<h3>$ {{ getNumberFormat(product.price) }}</h3>
					<h5>{{ product.name }}</h5>
					<p class="text-success mt-2" v-if="shouldShowFreeShipping(index)">Envío gratis</p>
					<p class="text-danger mt-2" v-else>Oferta!</p>

				</div>
			</div>
		</div>

		<!-- Modal -->
		<section v-if="load_modal">
			<modal-product :product_id="product_id" :is_auth="is_auth" :id_user="id_user" />
		</section>

		<!-- Load -->
		<section v-if="!load_data" class="d-flex justify-content-center my-3">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</section>
	</div>
</template>

<script>
import ModalProduct from './ModalProduct.vue';

export default {
	props: ['is_logged', 'active_user'],
	components: {
		ModalProduct
	},
	data() {
		return {
			productsByCategory: {},
			load_modal: false,
			modal: null,
			content: null,
			product_id: null,
			is_auth: false,
			id_user: null,
			load_data: false,
		}
	},
	created() {
		this.index()
	},
	methods: {
		index() {
			this.getProductsBycategory()
			this.authUser()
		},
		async getProductsBycategory() {
			try {
				const { data } = await axios.get('Products/GetProductsByCategories');
				this.productsByCategory = { ...data.productsByCategory };
				this.load_data = true;
			} catch (error) { console.error(error) }
		},
		// Datos del usuario activo
		authUser() {
			this.is_auth = this.is_logged
			this.id_user = this.active_user
		},
		openModal(productId) {
			this.product_id = productId
			this.content = 'productDetails'
			this.load_modal = true

			setTimeout(() => {
				//openModal
				this.modal = new bootstrap.Modal(document.getElementById('product_modal'), {
					keyboard: false,
				})
				this.modal.show()

				//limpiar datos del modal
				const modal = document.getElementById('product_modal')
				modal.addEventListener('hidden.bs.modal', () => {
					this.load_modal = false
				})
			}, 200)
		},
		// formatea el precio del producto
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		},
		shouldShowFreeShipping(index) {
			// Generar un número aleatorio entre 0 y 1
			const random = Math.random();

			// Establecer un umbral para mostrar el párrafo
			const threshold = 0.8;

			// Si el número aleatorio es menor que el umbral, mostrar el párrafo
			return random < threshold;
		},
		getAllProducts(category) {
			window.location.href = `/Products/GetAllProductsOFCategory/${category}`
		}
	}

}
</script>

