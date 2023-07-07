<template>
	<div class="card mx-5 my-5 shadow">

		<div class="card-header d-flex justify-content-between">
			<h2>Productos</h2>
			<button @click="openModal" class="btn btn-primary">Crear Producto</button>
		</div>

		<div class="card-body">
			<table-component ref="table" />
		</div>

		<!-- Modal -->
		<section v-if="load_modal">
			<modal :product_data="product" />
		</section>
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
			product: null,
		}
	},
	methods: {
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
			this.$refs.table.datatable.destroy()
			this.$refs.table.index()
		},
		editProduct(product) {
			this.product = product
			this.openModal()
		}
	}
}
</script>
