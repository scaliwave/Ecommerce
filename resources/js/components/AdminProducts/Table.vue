<template>
	<section>
		<table class="table" id="productsTable" @click="getEvent">
			<thead>
				<tr>
					<th>#</th>
					<th>Imagen</th>
					<th>Nombre</th>
					<th>Precio</th>
					<th>Stock</th>
					<th>Categoria</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</section>
</template>

<script>
export default {
	data() {
		return {
			products: [],
			datatable: {},
		}
	},
	mounted() {
		this.index()
	},
	methods: {
		async index() {
			this.mountDataTable()
		},
		mountDataTable() {
			this.datatable = $('#productsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: '/Products/GetAllProductsDataTable'
				},
				columns: [
					{data: 'id'},
					{
						data: 'image',
						render: function (data, type) {
							if (type === 'display' && data) {
								return '<img src="/storage/images/' + data + '" alt="Imagen del producto" width="50" height="50">';
							} else {
								return data;
							}
						}
					},
					{ data: 'name' },
					{ data: 'price' },
					{ data: 'stock' },
					{ data: 'category.name', searchable: false },
					{ data: 'action' }
				]
			})
		},
		getEvent(event) {
			const button = event.target
			if (button.getAttribute('role') == 'edit') {
				this.getProduct(button.getAttribute('data-id'))
			}
			if (button.getAttribute('role') == 'delete') {
				this.deleteProduct(button.getAttribute('data-id'))
			}
		},
		async getProduct(product_id) {
			try {
				const { data } = await axios.get(`/Products/GetAProduct/${product_id}`)
				this.$parent.editProduct(data.product)

			} catch (error) {
				console.log(error)
			}
		},
		async deleteProduct(product_id) {
			try {
				const result = await swal.fire({
					icon: 'info',
					title: '¿Quieres eliminar el producto?',
					showCancelButton: true,
					confirmButtonText: 'Eliminar'
				})
				if (!result.isConfirmed) return

				await axios.delete(`/Products/DeleteAProduct/${product_id}`)
				this.$parent.closeModal()
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


