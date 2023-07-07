<template>
	<div class="card mx-5 my-5 shadow">

		<div class="card-header d-flex justify-content-between">
			<h2>Productos</h2>
			<button @click="openModal" class="btn btn-primary">Crear Producto</button>
		</div>

		<div class="card-body">
			<section class="table-responsive" v-if="load">
				<table-component :products_data="products" />
			</section>

			<!-- Load -->
			<section v-else class="d-flex justify-content-center my-3 text-primary">
				<div class="spinner-border" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</section>

			<!-- Modal -->
			<section v-if="load_modal">
				<modal :product_data="this.product"/>
			</section>
		</div>
	</div>
</template>


<script>
import TableComponent from './Table.vue'
import Modal from './Modal.vue';

export default {
	components: {
		TableComponent,
		Modal
	},
	data() {
		return {
			load_modal: false,
			modal: null,
			products: [],
			load: false,
			product: null,
		}
	},
	created() {
		this.index()
	},
	methods: {
		async index() {
			await this.getProducts()
		},
		async getProducts() {
			try {
				this.load = false
				const { data } = await axios.get('/Products/GetAllProducts')
				this.products = data.products
				this.load = true
			} catch (error) {
				console.log(error);
			}
		},
		openModal() {
			this.load_modal = true
			setTimeout(() => {
				this.modal = new bootstrap.Modal(document.getElementById('products_modal'), {
					keyboard: false
				})
				this.modal.show()

				//limpiar datos del modal
				const modal = document.getElementById('products_modal')
				modal.addEventListener('hidden.bs.modal', () => {
					this.load_modal = false
					this.product = null
				})
			}, 200)
		},
		closeModal() {
			this.modal.hide()
			this.getProducts()
		},
		editProduct(product) {
			this.product = product
			this.openModal()
		}
	}
}
</script>
