@props(['menu' => 'Menu Item', 'active' => false])

<li @class( [ 'bg-gray-100 hover:bg-gray-100 hover:text-gray-800'=> $active,
    'hover:bg-gray-200 hover:text-gray-800' => !$active,
    'relative px-6 py-3 flex items-center transition'
    ])>
    @if ($active)
        <span class="absolute inset-y-0 left-0 w-0.5 bg-blue-500 rounded-tr-lg rounded-br-lg"></span>
    @endif
    <a class="inline-flex items-center w-full text-sm font-semibold" {{ $attributes->merge(['href']) }}>
        <span class="ml-4 capitalize">{{ $menu }}</span>
    </a>
</li>
