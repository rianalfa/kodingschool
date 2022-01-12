<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'font-semibold text-sm tracking-widest bg-gray-700 hover:bg-gray-600 text-white rounded-md active:bg-gray-600 focus:border-gray-600 focus:ring-gray-300 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
