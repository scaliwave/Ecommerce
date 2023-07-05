<x-app>
    <all-products-list
	:products="{{ json_encode($products) }}"
	:category_name="{{ json_encode($category_name) }}"
    :is_logged="{{ json_encode($is_logged) }}"
	:active_user="{{ json_encode($id_user) }}" />
</x-app>
