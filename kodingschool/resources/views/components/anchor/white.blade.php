<a
    {{ $attributes->merge(['href' => '#', 'class' => 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 active:bg-gray-200 focus:border-gray-300 focus:ring-gray-200 anchor-button rounded py-2 px-4']) }}>
    {{ $slot }}
</a>
