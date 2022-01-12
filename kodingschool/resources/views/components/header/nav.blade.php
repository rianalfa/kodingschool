<x-header-layout :title="$title">
    <x-header.item menu="Beranda" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" />
    <x-header.item menu="Videos" href="#" />
    <x-header.item menu="Seminar" href="#" />
</x-header-layout>
