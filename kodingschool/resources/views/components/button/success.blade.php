<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'bg-green-500 hover:bg-green-400 text-white font-bold rounded active:bg-green-400 focus:border-green-400 focus:ring-green-300 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
