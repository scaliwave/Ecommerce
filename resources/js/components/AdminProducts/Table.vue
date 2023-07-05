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
					<button class="btn btn-warning me-2">Editar</button>
					<button class="btn btn-danger">Eliminar</button>
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
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
		// cambiar formato del precio
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		}
	}
};
</script>


