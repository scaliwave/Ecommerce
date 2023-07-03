<template>
	<div class="container-responsive ">
		<div class="row my-4 " v-for="(products, index) in productsByCategory" :key="index" >
			<div class="d-flex align-items-center">
				<h3>{{ index }}</h3>
				<a href="" class="mx-2 text-decoration-none">Ver más</a>
			</div>

			<div v-for="product in products" :key="product.id" class="d-flex col card mx-2 shadow p-4 mb-5 bg-body-tertiary rounded" @click="openModal(product.id)" style="cursor: pointer">
				<div class="container" >
					<img src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
						class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
						alt="">
					<div>
						<hr>
						<h4>$ {{ getNumberFormat(product.price) }}</h4>
						{{ product.name }}

					</div>
					<i class="bi bi-cart3"></i>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<section v-if="load_modal">
			<modal-product :product_id="product_id" :is_auth="is_auth" :id_user="id_user" />
		</section>

		<!-- Load -->
		<section v-if="!load_data" class="d-flex justify-content-center my-3">
			<div class="spinner-border" role="status">
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
				const { data } = await axios.get('Products/GetProductsByCategory');
				this.productsByCategory = { ...data };
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
		}
	}

}
</script>

