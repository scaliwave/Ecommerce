<template>
	<table class="table">
		<thead>
			<tr>
				<th>Imagen</th>
				<th>Nombre</th>
				<th>precio</th>
				<th>Stock</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(product, index) in products" :key="index">
				<th>{{ product.image }}</th>
				<td>{{ product.name }}</td>
				<td>$ {{ getNumberFormat(product.price) }}</td>
				<td>{{ product.stock }}</td>
				<td>
					<button class="btn btn-warning me-2" @click="getProduct(product)">Editar</button>
					<button class="btn btn-danger" @click="deleteProduct(product)">Eliminar</button>
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
import Swal from 'sweetalert2';

export default {
	props: ['products_data'],
	data() {
		return {
			products: [],
		}
	},
	created() {
		this.index()
	},
	methods: {
		index() {
			this.products = [...this.products_data]
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
				if(!result.isConfirmed) return

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


