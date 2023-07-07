<template>
	<table class="table" id="productsTable">
		<thead>
			<tr>
				<th>Imagen</th>
				<th>Nombre</th>
				<th>precio</th>
				<th>Stock</th>
				<th>Categoria</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(product, index) in products" :key="index">
				<td v-if="(product.image)"><img :src="'/storage/images/' + product.image" class="img-fluid"
						style="width: 80px;" alt=""></td>

				<td v-else><img
						src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
						class="img-fluid" style="width: 80px;" alt=""></td>
				<td>{{ product.name }}</td>
				<td>$ {{ getNumberFormat(product.price) }}</td>
				<td>{{ product.stock }}</td>
				<td>{{ product.category_id }}</td>
				<td>
					<button class="btn btn-warning me-2" @click="getProduct(product)">Editar</button>
					<button class="btn btn-danger" @click="deleteProduct(product)">Eliminar</button>
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
export default {
	data() {
		return {
			products: [],
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
				const { data } = await axios.get('/Products/GetAllProducts')
				this.products = data.products
			} catch (error) {
				console.log(error);
			}
			$('#productsTable').DataTable()
		},
		async getProduct(product) {
			try {
				// const { data } = await axios.get(`/Products/GetAProduct/${product_id}`)
				this.$parent.editProduct(product)
			} catch (error) {
				console.log(error)
			}
		},
		async deleteProduct(product) {
			try {
				const result = await swal.fire({
					icon: 'info',
					title: '¿Quieres eliminar el producto?',
					showCancelButton: true,
					confirmButtonText: 'Eliminar'
				})
				if (!result.isConfirmed) return

				await axios.delete(`/Products/DeleteAProduct/${product.id}`)
				this.$parent.getProducts()
				swal.fire({
					icon: 'success',
					title: 'Felicidades!',
					text: 'Producto Eliminado'
				})
			} catch (error) {
				console.log(error);
			}
		},
		// cambiar formato del precio
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		}
	}
};
</script>


