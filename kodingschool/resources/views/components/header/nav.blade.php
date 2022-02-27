<x-header-layout :title="$title">
    <x-header.item menu="Beranda" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" />
    <x-header.item menu="Belajar" href="{{ route('study.last') }}" :active="request()->routeIs('study.*')" />
    <x-header.item menu="Peringkat" href="{{ route('leaderboard') }}" :active="request()->routeIs('leaderboard')" />

    @role('admin')
        <x-header.item menu="Users" href="{{ route('users') }}" :active="request()->routeIs('users')" />
    @endrole
</x-header-layout>
