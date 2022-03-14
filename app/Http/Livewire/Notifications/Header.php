<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;

class Header extends Component
{
    public $totalUnreadNotifications;

    protected $listeners = [
        'readNotifications' => 'readNotifications'
    ];

    public function mount()
    {
        $this->totalUnreadNotifications = auth()->user()->unreadnotifications()->count();
    }

    public function readNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->totalUnreadNotifications = 0;
    }

    public function render()
    {
        return view('components.header.notifications');
    }
}
