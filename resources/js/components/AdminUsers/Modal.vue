<template>
	<div class="modal fade" id="users_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">
						{{ `${is_create ? 'Crear' : 'Actualizar'} usuario` }}
					</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form @submit.prevent="storeUser" enctype="multipart/form-data">
						<div class="my-3">
							<label for="role" class="form-label">Rol</label>
							<select class="form-select" id="role" v-model="user.roles[0].name">
								<option v-for="(role, index) in roles" :key="index">{{ role }}
								</option>
							</select>
							<div class="text-danger" v-if="errors && errors.role">{{ errors.role[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="number_id" class="form-label">Cedula</label>
							<input type="number" class="form-control" id="number_id" v-model="user.number_id">
							<div class="text-danger" v-if="errors && errors.number_id">{{ errors.number_id[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="name" class="form-label">Nombres</label>
							<input type="text" class="form-control" id="name" v-model="user.name">
							<div class="text-danger" v-if="errors && errors.name">{{ errors.name[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="last_name" class="form-label">Apellidos</label>
							<input type="text" class="form-control" id="last_name" v-model="user.last_name">
							<div class="text-danger" v-if="errors && errors.last_name">{{ errors.last_name[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" v-model="user.email">
							<div class="text-danger" v-if="errors && errors.email">{{ errors.email[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="cellphone" class="form-label">Celular</label>
							<input type="number" class="form-control" id="cellphone" v-model="user.cellphone">
							<div class="text-danger" v-if="errors && errors.cellphone">{{ errors.cellphone[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Contraseña</label>
							<input type="password" class="form-control" id="password" v-model="user.password">
							<div class="text-danger" v-if="errors && errors.password">{{ errors.password[0] }}</div>
						</div>
						<div class="mb-3">
							<label for="password_confirmation" class="form-label">Confirmar contraseña</label>
							<input type="password" class="form-control" id="password_confirmation"
								v-model="user.password_confirmation">
							<div class="text-danger" v-if="errors && errors.password">{{ errors.password[0] }}</div>

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
			user: {},
			is_create: true,
			errors: {},
		};
	},
	props: ['user_data', 'roles'],
	created() {
		this.index()
	},
	methods: {
		index() {
			this.setUser()
		},
		setUser() {
			if (!this.user_data) {
				this.user.roles = [{ name: ''}];
				return
			}
			this.user = this.user_data
			this.is_create = false
		},
		loadFormData() {
			const form_data = new FormData()
			if (this.user.roles[0].name) form_data.append('role', this.user.roles[0].name)
			if (this.user.number_id) form_data.append('number_id', this.user.number_id)
			if (this.user.name) form_data.append('name', this.user.name)
			if (this.user.last_name) form_data.append('last_name', this.user.last_name)
			if (this.user.email)form_data.append('email', this.user.email)
			if (this.user.cellphone) form_data.append('cellphone', this.user.cellphone)
			if (this.user.password) form_data.append('password', this.user.password)
			if (this.user.password_confirmation) form_data.append('password_confirmation', this.user.password_confirmation)
			return form_data
		},
		async storeUser() {
			try {
				const user_form = this.loadFormData()
				if (this.is_create) {
					const response = await axios.post('/Users/CreateUser', user_form)
					console.log(response)
					this.$parent.closeModal()

					swal.fire({
						icon: 'success',
						title: 'Usuario Creado!',
					})
				}
				else {
					await axios.post(`/Users/UpdateUser/${this.user.id}`, user_form)
					this.$parent.closeModal()

					swal.fire({
						icon: 'success',
						title: 'Usuario Actualizado!',
					})
				}

			} catch (error) {
				if (error.response.status == 422) {
					this.errors = error.response.data.errors
				}
				else {
					console.log(error)
					swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Algo salio mal!'
					})
				}
			}
		},
	}
}
</script>

