<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'font-semibold text-sm tracking-widest bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 rounded-md active:bg-gray-200 focus:border-gray-300 focus:ring-gray-200 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
