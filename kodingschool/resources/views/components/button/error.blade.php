<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'bg-red-500 hover:bg-red-400 text-white font-bold rounded active:bg-red-400 focus:border-red-400 focus:ring-red-300 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
