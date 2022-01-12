<x-header-layout :title="$title">
    <x-header.item menu="Beranda" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" />
    <x-header.item menu="Belajar" :active="request()->routeIs('study.*')" />
    <x-header.item menu="Peringkat" href="{{ route('leaderboard') }}" :active="request()->routeIs('leaderboard')" />
</x-header-layout>
