<template>
	<div class="modal fade" id="product_modal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">

					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form @submit.prevent="addCart" v-if="is_load" class="d-flex">

						<!-- seccion izquierda -->
						<div class="card" style="width: 20rem;">

							<img v-if="(data.image)" :src="'/storage/images/' + data.image" class="card-img-top"
								alt="imagen">
							<img v-else
								src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
								class="card-img-top" alt="imagen">

							<div class="card-body">
								<h2 class="card-title">{{ data.name }}</h2>
								<h4 class="mt-3">$ {{ getNumberFormat(data.price) }}</h4>
								<hr>

								<h5>Descripción:</h5>
								<p class="card-text">{{ data.description }}</p>
							</div>
						</div>
						<!-- seccion derecha -->
						<div class="mx-3 d-flex flex-column">
							<p>Hasta 48 cuotas</p>
							<img src="/mastercard.jpg" style="height: 80px" alt="">
							<h5 class="my-3">Stock disponible: {{ data.stock }}</h5>

							<section v-if="!is_added" class="mb-3 d-flex flex-column">
								<label for="cant" class="form-label">Cantidad</label>
								<input type="number" v-model="product_cant" @input="validateCant" class="form-control"
									id="formGroupExampleInput" placeholder="1">

								<!-- advertencia: cantidad max.superada -->
								<p class="text-danger" v-if="warning_cant">Cantidad max. superada</p>

								<button type="submit" class="btn btn-primary mt-3">Agregar al carrito</button>
							</section>

							<!-- ¡añadido al carrito! -->
							<section v-else class="d-flex flex-column justify-content-center">
								<h4 class="text-success text-center">¡Añadido con exito!</h4>
								<a @click="getMyCart" class="d-flex justify-content-center text-decoration-none"
									style="cursor: pointer">Ver
									carrito</a>
							</section>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		product_id: {
			type: Number,
			required: false
		},
		is_auth: {
			type: Boolean,
			required: false
		},
		id_user: {
			type: Number,
			required: false
		}
	},
	data() {
		return {
			data: null,
			is_load: false,
			product_cant: 1,
			warning_cant: false,
			is_added: false,
		};
	},
	created() {
		this.index()
	},
	methods: {
		async index() {
			try {
				const { data } = await axios.get(`/Products/GetAnProduct/${this.product_id}`);
				this.data = data.product
				// Esperar a que carguen los datos para mostrarlos
				this.is_load = true;
			} catch (error) { console.log(error) }
		},
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		},
		async addCart() {
			if (this.is_auth) {
				if (this.product_cant <= this.data.stock) {
					this.warning_cant = false
					const data = {
						product_id: this.product_id,
						user_id: this.id_user,
						cant: this.product_cant,
						price: this.data.price * this.product_cant
					}
					try {
						await axios.post('/ShoppingCart/AddOrUpdateShoppingCart', data)
						this.is_added = true
					} catch (error) {
						if (error.response.status == 400) {
							swal.fire({
								icon: 'error',
								title: 'La cantidad supera el stock en tu carrito!',
							})
						}
						else console.log(error)

					}
				} else {
					this.warning_cant = true
				}
			} else {
				window.location.href = '/login'
			}
		},
		//validar que no exista cantidad negativa
		validateCant() {
			if (this.product_cant <= 0)
				this.product_cant = 1
		},
		getMyCart() {
			window.location.href = '/ShoppingCart/MyCart'
		}
	}
}
</script>
