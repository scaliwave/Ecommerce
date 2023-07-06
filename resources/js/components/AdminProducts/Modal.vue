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
					<form @submit.prevent="storeProduct" enctype="multipart/form-data">
						<div class="mb-3">
							<label for="images" class="form-label">Imagen</label>
							<input type="file" class="form-control" id="file" accept="image/*" @change="loadImage">
							<div class="text-danger" v-if="errors && errors.image">{{ errors.image[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="name" class="form-label">Nombre</label>
							<input type="text" class="form-control" id="name" v-model="product.name">
							<div class="text-danger" v-if="errors && errors.name">{{ errors.name[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="price" class="form-label">Precio</label>
							<input type="number" class="form-control" id="price" v-model="product.price">
							<div class="text-danger" v-if="errors && errors.price">{{ errors.price[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="stock" class="form-label">Stock</label>
							<input type="number" class="form-control" id="stock" v-model="product.stock">
							<div class="text-danger" v-if="errors && errors.stock">{{ errors.stock[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="description" class="form-label">Descripción</label>
							<textarea class="form-control" id="description" rows="3"
								v-model="product.description"></textarea>
							<div class="text-danger" v-if="errors && errors.description">{{ errors.description[0] }}</div>
						</div>
						<div class="my-3">
							<label for="categories" class="form-label">Categoría</label>
							<v-select :options="categories" v-model="product.category_id" :reduce="category => category.id"
								label="name" :clearable="false">
							</v-select>
							<div class="text-danger" v-if="errors && errors.category_id">{{ errors.category_id[0] }}</div>
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
			file: null,
			errors: {},
		};
	},
	props: ['product_data'],
	created() {
		this.index()
	},
	methods: {
		index() {
			this.getCategories()
			this.setProduct()
		},
		setProduct() {
			if (!this.product_data) return
			this.product = { ...this.product_data }
			this.is_create = false
		},
		loadImage(event) {
			this.file = event.target.files[0]
		},
		loadFormData() {
			const form_data = new FormData()
			if (this.file) form_data.append('image', this.file, this.file.name)
			form_data.append('name', this.product.name)
			form_data.append('description', this.product.description)
			form_data.append('price', this.product.price)
			form_data.append('stock', this.product.stock)
			form_data.append('category_id', this.product.category_id)
			return form_data
		},
		async getCategories() {
			const { data } = await axios.get('/Categories/GetAllCategories')
			this.categories = data.categories
		},
		async storeProduct() {
			try {
				const product = this.loadFormData()
				console.log(product)
				if (this.is_create) {
					await axios.post('/Products/SaveProduct', product)
					this.$parent.closeModal()

					swal.fire({
						icon: 'success',
						title: 'Felicidades!',
						text: 'Producto Almacenado'
					})
				}
				else {
					await axios.post(`/Products/UpdateProduct/${this.product.id}`, product)
					this.$parent.closeModal()

					swal.fire({
						icon: 'success',
						title: 'Felicidades!',
						text: 'Producto Actualizado'
					})
				}

			} catch (error) {
				if (error.response.status === 422) {
					this.errors = error.response.data.errors
				}
				else {
					console.log(error)
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong!'
					})
				}
			}
		},
		// cambiar formato del precio
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		}
	},
};
</script>

