<template>
	<div class="container card shadow p-4 mb-5 bg-body-tertiary rounded">
		<h5>Tu Carrito</h5>
		<hr>
		<section v-if="!no_products">
			<table class="table">
				<tbody>
					<tr v-for="(product, index) in products_data" :key="index">
						<td class="align-middle">
							<div class="d-flex ">
								<img src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
									class="img-fluid" style="width: 60px;" alt="">


							</div>
							<button class="btn text-primary" @click="deleteProduct(product.product.id)">Eliminar</button>


						</td>
						<td class="align-middle">
							<h4>{{ product.product.name }}</h4>
						</td>
						<td class="align-middle">
							<div class="col-auto">

								<!-- input quantity -->
								<input type="number" class="form-control mt-4" id="input" v-model="product.cant"
									@input="verify_cant(product.cant, product.product.stock, product.product.price, product.product.id, index)"
									:min="1" :max="product.product.stock">

								<section v-if="warning_quantity === -1 && id_shopping === index">
									<p class="text-center mt-2 opacity-50 text-danger">puedes comprar desde 1u.</p>
								</section>

								<section v-else-if="warning_quantity === 1 && id_shopping === index">
									<p class="text-center mt-2 opacity-50 text-danger">supera la cantidad max.</p>
								</section>

								<section v-else>
									<p class="text-center mt-2 opacity-50">{{ product.product.stock }} disponibles</p>
								</section>

							</div>
						</td>

						<td class="align-middle">
							<!-- price -->
							<section v-if="id_shopping !== index">
								<h3>$ {{ getNumberFormat(product.price) }}</h3>
							</section>

							<section v-else-if="id_shopping === index && price_unit !== null">
								<h3>$ {{ getNumberFormat(price_unit) }}</h3>
							</section>

							<section v-else-if="id_shopping === index && price_unit === null">
								<h3>$ {{ getNumberFormat(product.product.price) }}</h3>
							</section>
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Total -->
			<div class="container  text-end">
				<div class="row align-items-center">
					<div class="col"></div>
					<div class="col"></div>
					<div class="col"></div>
					<div class="col">
						<h3>Total</h3>
					</div>
					<div class="col me-5">
						<h3>$ {{ getNumberFormat(total) }}</h3>
					</div>
				</div>
				<hr>
			</div>
		</section>

		<section v-else>
			<div class="d-flex flex-column align-items-center">
				<h4 class="text-center mt-3 mb-5 text-primary">¡Aun no tienes productos para mostrar!</h4>
				<a href="/"><button class="btn btn-primary">voler</button></a>
			</div>

			<hr>
		</section>
	</div>
</template>

<script>
export default {
	data() {
		return {
			products_data: [],
			id_shopping: null,
			no_products: false,
			warning_quantity: null,
			price_unit: null,
			total: 0,
			active_user: null
		};
	},
	props: ['products', 'id_user'],
	created() {
		this.index()
	},
	methods: {
		index() {
			this.products_data = [...this.products]
			// verificar si hay productos
			if (this.products_data.length == 0)
				this.no_products = true;

			this.active_user = this.id_user;
			this.calculateTotal()
		},
		// verificar la cantidad del input
		verify_cant(quantity, stock, price, product_id, index) {
			this.id_shopping = index;
			if (quantity < 1)
				this.warning_quantity = -1

			else if (quantity > stock)
				this.warning_quantity = 1

			else {
				this.warning_quantity = null
				this.calculate_price(quantity, price, product_id)
			}
		},
		async calculate_price(quantity, price, product_id) {
			const new_price = quantity * price
			const data = {
				product_id: product_id,
				user_id: this.active_user,
				cant: quantity,
				price: new_price
			}
			// actualiza el carrito en BD
			try {
				const response = await axios.put(`/ShoppingCart/UpdateShoppingCart/${this.active_user}`, data)

				// se cambia el precio de ese id de producto seleccionado
				this.price_unit = new_price
				// se actualiza el precio del producto seleccionado dentro del arreglo de productos
				const product = this.products_data[this.id_shopping]
				product.price = new_price

				this.calculateTotal()
			} catch (error) { console.log(error) }
		},
		calculateTotal() {
			let total = 0
			this.products_data.forEach(product => {
				total += product.price
			})
			this.total = total
		},
		async deleteProduct(product_id) {
			try {
				await axios.delete(`/ShoppingCart/DeleteShoppingCart/${this.active_user}/${product_id}`)

				// recargar la pagina
				location.reload();

			} catch (error) { console.log(error) }
		},
		// cambiar formato del precio
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		}
	},
};
</script>

