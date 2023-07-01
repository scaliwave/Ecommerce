<template>
	<div>
		<div class="modal fade" id="product_modal" aria-hidden="true" v-if="content === 'productDetails'">

			<!-- Contenido 1 -->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">

						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

						<div v-if="is_load" class="d-flex">
							<div class="card" style="width: 18rem;">
								<img src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
									class="card-img-top" alt="imagen">
								<div class="card-body">
									<h2 class="card-title">{{ data.name }}</h2>
									<hr>
									<h4>$ {{ getNumberFormat(data.price) }}</h4>
									<h5 class="mt-3">Descripción:</h5>
									<p class="card-text">{{ data.description }}</p>
								</div>
							</div>
							<div class="mx-2">
								<p>Hasta 48 cuotas</p>
								<h5>Cantidad en stock: {{ data.stock }}</h5>
								<button type="button" class="btn btn-primary">Agregar al carrito</button>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>

		<!-- Contenido 2 -->
		<div v-else>

		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			data: null,
			is_load: false,
		};
	},
	props: {
		content: {
			type: String,
			required: true
		},
		productId: {
			type: Number,
			default: null
		}
	},

	components: {},

	created() {
		this.index()
	},

	mounted() { },

	methods: {
		async index() {
			try {
				const { data } = await axios.get(`Products/GetAnProduct/${this.productId}`);
				this.data = data.product
				this.is_load = true;
			} catch (error) {
				console.log(error);
			};

		},
		getNumberFormat(price) {
			return new Intl.NumberFormat("es-CL").format(price)
		}

	}
}
</script>


