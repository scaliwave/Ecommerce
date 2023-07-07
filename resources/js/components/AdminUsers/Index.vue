<template>
	<div class="card mx-5 my-5">

		<div class="card-header d-flex justify-content-between">
			<h2>usuarios</h2>
			<button @click="openModal" class="btn btn-primary">Crear Usuario</button>
		</div>

		<div class="card-body">
			<section class="table-responsive" v-if="load">
				<table class="table">
					<thead>
						<tr>
							<th>CC</th>
							<th>Nombres</th>
							<th>Apellidos</th>
							<th>Celular</th>
							<th>Correo</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(user, index) in users" :key="index">
							<th>{{ user.number_id }}</th>
							<td>{{ user.name }}</td>
							<td>{{ user.last_name }}</td>
							<td>{{ user.cellphone }}</td>
							<td>{{ user.email }}</td>
							<td>
								<button class="btn btn-warning me-2" @click="editUser(user)">Editar</button>
								<button class="btn btn-danger" @click="deleteUser(user)">Eliminar</button>
							</td>
						</tr>
					</tbody>
				</table>
			</section>

			<!-- Load -->
			<section v-else class="d-flex justify-content-center my-3 text-primary">
				<div class="spinner-border" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</section>

			<!-- Modal -->
			<section v-if="load_modal">
				<modal :user_data="this.user" :roles="this.roles"/>
			</section>
		</div>
	</div>
</template>


<script>
import Modal from './Modal.vue';

export default {
	data() {
		return {
			load: false,
			load_modal: false,
			users: [],
			user: null,
			roles: [],
		};
	},
	components: {
		Modal
	},
	created() {
		this.index()
		this.getAllRoles()
	},
	methods: {
		async index() {
			await this.getUsers()
		},
		async getAllRoles() {
			try {
				const { data } = await axios.get('/Users/GetAllRoles')
				this.roles = data.roles
			} catch (error) {
				console.log(error);
			}
		},
		async getUsers() {
			this.load = false
			try {
				const { data } = await axios.get('/Users/GetAllUsers')
				this.users = data.users
				this.load = true
			} catch (error) {
				console.log(error);
			};
		},
		editUser(user) {
			this.user = user
			this.openModal()
		},
		async deleteUser(user) {
			try {
				const result = await swal.fire({
					icon: 'info',
					title: '¿Quieres eliminar el usuario?',
					showCancelButton: true,
					confirmButtonText: 'Eliminar'
				})
				if (!result.isConfirmed) return

				await axios.delete(`/Users/DeleteUser/${user.id}`)
				this.getUsers()
				swal.fire({
					icon: 'success',
					title: 'Felicidades!',
					text: 'Usuario Eliminado'
				})
			} catch (error) {
				console.log(error);
				swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Algo salio mal!'
				})
			}
		},
		openModal() {
			this.load_modal = true
			setTimeout(() => {
				this.modal = new bootstrap.Modal(document.getElementById('users_modal'), {
					keyboard: false
				})
				this.modal.show()

				//limpiar datos del modal
				const modal = document.getElementById('users_modal')
				modal.addEventListener('hidden.bs.modal', () => {
					this.load_modal = false
					this.user = null
				})
			}, 200)
		},
		closeModal() {
			this.modal.hide()
			this.getUsers()
		}
	}
}
</script>

