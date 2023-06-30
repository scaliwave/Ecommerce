<template>
	<section class="container-responsive">
		<div class="row my-5" v-for="(products, index) in productsByCategory" :key="index">
			<div class="d-flex align-items-center">
				<h3>{{ index }}</h3>
				<a href="" class="mx-2">Ver más</a>
			</div>

			<div v-for="product in products" :key="product.id" class="d-flex col card mx-2">
				<div class="container">
					<img src="https://www.apcomputadores.com/wp-content/uploads/computador-de-mesa-dell-3681-sff-18-5-core-i3-4gb-ram-ddr4-1tb-hdd-600x600.jpg.webp"
						class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
						alt="">
					<div>
					<hr>
						<h4>${{ product.price }}</h4>
						{{ product.name }}
					</div>

				</div>

			</div>
		</div>
	</section>
</template>

<script>
export default {
	// props: [],
	// components: {
	// 	SectionComponent
	// },
	data() {
		return {
			productsByCategory: {},
		}
	},
	created() {
		this.index()
	},
	methods: {
		async index() {
			try {
				const response = await axios.get('Products/GetProductsByCategory');
				this.productsByCategory = response.data;
			} catch (error) {
				console.error(error);
			}
		}
	}

}
</script>

