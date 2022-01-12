<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'font-semibold text-sm tracking-widest bg-gray-200 hover:bg-gray-300 text-gray-600 rounded-md active:bg-gray-300 focus:border-gray-500 focus:ring-gray-300 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
