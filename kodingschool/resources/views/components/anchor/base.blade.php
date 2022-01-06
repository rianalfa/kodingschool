<a
    {{ $attributes->merge(['href' => '#', 'class' => 'font-bold hover:underline text-sky-600 active:text-sky-900 focus:text-sky-900']) }}>
    {{ $slot }}
</a>
