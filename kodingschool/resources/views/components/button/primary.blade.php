<button
    {{ $attributes->merge([
    'type' => 'button',
    'class' => 'bg-sky-500 hover:bg-sky-400 text-white font-bold rounded active:bg-sky-400 focus:border-sky-400 focus:ring-sky-300 anchor-button py-2 px-4',
]) }}>
    {{ $slot }}
</button>
