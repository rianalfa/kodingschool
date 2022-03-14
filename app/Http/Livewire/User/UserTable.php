<?php

namespace App\Http\Livewire\User;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use App\Models\UserDetail;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class UserTable extends DataTableComponent
{
    public string $defaultSortColumn = 'name';
    public string $defaultSortDirection = 'desc';

    public function columns(): array
    {
        return [
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Username", "username")
                ->sortable(),
            Column::make("Tingkat", "year")
                ->sortable(),
            Column::make("Kelas", "class")
                ->sortable()
                ->searchable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make("Detail"),
            Column::make("Posisi"),
        ];
    }

    public function filters(): array {
        return [
            'year' => Filter::make('Tingkat')
                            ->select([
                                '' => 'Any',
                                1 => 'I',
                                2 => 'II',
                                3 => 'III',
                                4 => 'IV',
                            ]),
        ];
    }

    public function query(): Builder
    {
        return UserDetail::query()
            ->join('users', 'user_details.user_id', '=', 'users.id')
            ->when($this->getFilter('year'), fn ($query, $year) => $query->where('year', $year));
    }

    public function rowView(): string
    {
        return 'user.user-table';
    }
}
