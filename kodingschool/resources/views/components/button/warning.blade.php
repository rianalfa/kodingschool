<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'font-semibold text-sm tracking-widest bg-yellow-400 hover:bg-yellow-300 text-white font-bold rounded-md active:bg-yellow-300 focus:border-yellow-300 focus:ring-yellow-300 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
