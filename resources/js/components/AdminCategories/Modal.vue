<template>
	<div class="modal fade" id="categories_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						{{ `${is_create ? 'Crear' : 'Actualizar'} categoria` }}
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form @submit.prevent="storeCategory" enctype="multipart/form-data">
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="name" v-model="category.name">
							<div class="text-danger" v-if="errors && errors.name">{{ errors.name[0] }}</div>
						</div>

						<hr>
						<section class="d-flex justify-content-end">
							<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">{{ `${is_create ? 'Crear' : 'Actualizar'}`
							}}</button>
						</section>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			category: {},
			is_create: true,
			errors: {}
		}
	},
	props: ['category_data'],
	created() {
		this.index()
	},
	methods: {
		index() {
			this.setCategory()
		},
		setCategory() {
			if (!this.category_data)
				return
			this.category = this.category_data
			this.is_create = false
		},
		loadFormData() {
			const form_data = new FormData()
			if (this.category.name) form_data.append('name', this.category.name)
			return form_data
		},
		async storeCategory() {
			try {
				const category_form = this.loadFormData()
				if (this.is_create) {
					await axios.post('/Categories/CreateCategory', category_form)
					this.$parent.closeModal()

					swal.fire({
						icon: 'success',
						title: 'Categoria creada correctamente!',
					})
				}
				else {
					await axios.post(`/Categories/UpdateCategory/${this.category.id}`, category_form)
					this.$parent.closeModal()

					swal.fire({
						icon: 'success',
						title: 'Categoria actualizada!',
					})
				}
			} catch (error) {
				if (error.response.status == 422) {
					this.errors = error.response.data.errors
				}
				else {
					console.log(error)
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Algo salio mal!'
					})
				}
			}
		}
	},
};
</script>
