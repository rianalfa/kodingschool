@props(['menu' => 'Menu Item', 'active' => false])

<a {{ $attributes->merge(['href']) }} @class([
    'border-white text-lg font-bold' => $active,
    'hover:text-sky-200 hover:border-sky-200 border-sky-700 cursor-pointer font-medium ' => !$active,
    'flex items-center border-b-2 px-3 text-white ',
])>{{ $menu }}</a>
