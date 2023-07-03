<x-app>
	<shopping-cart :products= "{{ json_encode($products) }}" :id_user= "{{ json_encode($id_user) }}" />
</x-app>
