<template>
	<div class="card mx-5 my-5 shadow">

		<div class="card-header d-flex justify-content-between">
			<h2>Categorias</h2>
			<button @click="openModal" class="btn btn-primary">Crear Categoria</button>
		</div>

		<div class="card-body">
			<section class="table-responsive" v-if="load">
				<table class="table" id="categoriesTable">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(category, index) in categories" :key="index">
							<th>{{ index }}</th>
							<td>{{ category.name }}</td>
							<td>
								<button class="btn btn-warning me-2" @click="editCategory(category)">Editar</button>
								<button class="btn btn-danger" @click="deleteCategory(category)">Eliminar</button>
							</td>
						</tr>
					</tbody>
				</table>
			</section>

			<!-- Load -->
			<section v-else class="d-flex justify-content-center my-3 text-primary">
				<div class="spinner-border" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</section>

			<!-- Modal -->
			<section v-if="load_modal">
				<modal :category_data="this.category" />
			</section>
		</div>
	</div>
</template>

<script>
import Modal from './Modal.vue';
export default {
	data() {
		return {
			load: false,
			load_modal: false,
			categories: [],
			category: null

		};
	},
	props: {},
	components: {
		Modal
	},
	created() {
		this.index()
	},
	methods: {
		async index() {
			await this.getAllCategories()

		},
		async getAllCategories() {
			this.load = false
			try {
				const { data } = await axios.get('/Categories/GetAllCategories')
				this.categories = data.categories
				this.load = true

			} catch (error) {
				console.log(error);
			}
			setTimeout(() => {this.dataTables()},150)

		},
		dataTables() {
			$('#categoriesTable').DataTable()
		},
		editCategory(category) {
			this.category = category
			this.openModal()
		},
		async deleteCategory(category) {
			try {
				const result = await swal.fire({
					icon: 'info',
					title: '¿Quieres eliminar la categoria?',
					showCancelButton: true,
					confirmButtonText: 'Eliminar'
				})
				if (!result.isConfirmed) return

				await axios.delete(`/Categories/DeleteCategory/${category.id}`)
				this.getAllCategories()
				swal.fire({
					icon: 'success',
					title: 'Felicidades!',
					text: 'Categoria Eliminada'
				})
			} catch (error) {
				console.log(error);
				swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Algo salio mal!'
				})
			}
		},
		openModal() {
			this.load_modal = true
			setTimeout(() => {
				this.modal = new bootstrap.Modal(document.getElementById('categories_modal'), {
					keyboard: false
				})
				this.modal.show()

				//limpiar datos del modal
				const modal = document.getElementById('categories_modal')
				modal.addEventListener('hidden.bs.modal', () => {
					this.load_modal = false
					this.category = null
				})
			}, 200)
		},
		closeModal() {
			this.modal.hide()
			this.getAllCategories()

		}
	},
};
</script>
