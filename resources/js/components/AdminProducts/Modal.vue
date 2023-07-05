<template>
	<div class="modal fade" id="products_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						{{ `${is_create ? 'Crear' : 'Actualizar'} Producto` }}
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form @submit.prevent="storeProduct">
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="name" v-model="product.name">
						</div>
						<div class="mb-3">
							<label for="price" class="form-label">Precio</label>
							<input type="number" class="form-control" id="name" v-model="product.price">
						</div>
						<div class="mb-3">
							<label for="stock" class="form-label">Stock</label>
							<input type="number" class="form-control" id="name" v-model="product.stock">
						</div>
						<div class="mb-3">
							<label for="description" class="form-label">Descripción</label>
							<textarea class="form-control" id="description" rows="3"
								v-model="product.description"></textarea>
						</div>
						<div class="my-3">
							<label for="categories" class="form-label">Categoría</label>
							<v-select :options="categories" v-model="product.category_id" :reduce="category => category.id"
								label="name" :clearable="false">
							</v-select>
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
			is_create: true,
			categories: [],
			product: {},
		};
	},
	props: {},
	created() {
		this.index()
	},
	methods: {
		index() {
			this.getCategories()
		},
		async getCategories() {
			const { data } = await axios.get('/api/Categories/GetAllCategories')
			this.categories = data.categories
		},
		async storeProduct() {
			try {
				if (this.is_create) {
					axios.post('/Products/SaveProduct', this.product)
				}
				else {
					await axios.put(`/Products/UpdateProduct/${this.product.id}`, this.product)
				}
				swal.fire({
					icon: 'success',
					title: 'Felicidades!',
					text: 'Producto almacenado'
				})
				this.$parent.closeModal()
			} catch (error) {
				console.log(error)
				swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Something went wrong!'
				})
			}
		}
	},
};
</script>

