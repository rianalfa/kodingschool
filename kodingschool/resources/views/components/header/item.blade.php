@props(['menu' => 'Menu Item', 'active' => false])

<a {{ $attributes->merge(['href']) }} @class([
    'border-blue-500 font-bold' => $active,
    'hover:text-blue-500 border-white hover:border-blue-300 cursor-pointer font-medium ' => !$active,
    'flex items-center border-b-2 px-3 text-sm text-gray-700 ',
])>{{ $menu }}</a>
