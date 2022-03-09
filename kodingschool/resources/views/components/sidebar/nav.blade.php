<x-sidebar-layout>
    <x-sidebar.item menu="Beranda" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" />
    <x-sidebar.item menu="Belajar" href="{{ route('study.last') }}" :active="request()->routeIs('study.*')" />
    <x-sidebar.item menu="Peringkat" href="{{ route('leaderboard') }}" :active="request()->routeIs('leaderboard')" />

    @auth
        @if (auth()->user()->hasRole('admin'))
            <x-sidebar.item menu="Users" href="{{ route('users') }}" :active="request()->routeIs('users')" />
        @endif
    @endauth
</x-sidebar-layout>
