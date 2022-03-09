<x-livewire-tables::table.cell>
    {{ $row->name }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->email }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->username }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->year }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->class }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->created_at }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    {{ $row->updated_at }}
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    <x-anchor.black href="{{ route('user.profile', $row->id) }}">Detail</x-anchor.black>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
    <x-badge.primary class="px-2 py-1 {{ auth()->user()->hasRole('super') ? 'cursor-pointer hover:scale-110' : 'cursor-default' }}"
        wire:click="$emit('{{ auth()->user()->hasRole('super') ? 'openModal' : '' }}', 'user.role-modal', {{ json_encode(['id' => $row->user->id]) }})">
        {{ $row->user->hasRole('user') ? 'user' : 'admin' }}
    </x-badge.primary>
</x-livewire-tables::table.cell>

