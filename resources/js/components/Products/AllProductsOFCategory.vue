<template>
	<div class="container-responsive card shadow p-5">
		<h3 class="mb-4">Todos los articulos de {{ category }}</h3>
		<div class="list-group">
			<div class="list-group-item" v-for="(product, index) in products_data" :key="product.id">
				<div class="d-flex align-items-center">
					<div class="d-flex" style="width: 150px; height: 150px">
					<img v-if="(product.image)" :src="'/storage/images/' + product.image" class="img-fluid"
							style="height: 150px">
						<img v-else
							src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
							class="img-fluid" style="height: 150px">
					</div>

					<div class="mx-3" style="cursor: pointer" @click="openModal(product.id)">
						<h5 class="mb-3">{{ product.name }}</h5>
						<h4>$ {{ getNumberFormat(product.price) }}</h4>
						<h6 class="text-success mt-2">Envio gratis</h6>
					</div>
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
	data() {
		return {
			products_data: [],
			category: '',
			load_modal: false,
			modal: null,
			content: null,
			product_id: null,
			is_auth: false,
			id_user: null,
			load_data: false,
		}
	},
	props: ['products', 'category_name', 'is_logged', 'active_user'],
	components: {
		ModalProduct
	},
	created() {
		this.index()
	},
	methods: {
		index() {
			setTimeout(() => {
				this.products_data = this.products
				this.load_data = true
			}, 250)
			this.load_data = false
			this.category = this.category_name
			this.authUser()
		},
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
	}
};
</script>
