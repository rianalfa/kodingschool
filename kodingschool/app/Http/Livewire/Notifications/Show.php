<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    private $notifications;
    private const PAGINATE = 10;

    public function reload()
    {
        $this->notifications = auth()->user()->notifications()->paginate(self::PAGINATE);
    }

    public function render()
    {
        $this->reload();
        return view('notifications', ['notifications' => $this->notifications])
            ->layoutData(['title' => "List Notifications"]);
    }
}
