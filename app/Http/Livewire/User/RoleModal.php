<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Exception;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class RoleModal extends ModalComponent
{
    public $user;
    public $role;

    public function mount($id) {
        $this->user = User::whereId($id)->first();
        $this->role = $this->user->hasRole('admin') ? 'admin' : '';
    }

    public function saveRole() {
        if (auth()->user()->hasRole('super')) {
            $removedRole = $this->role!='admin' ? 'admin' : 'user';
            $newRole = $this->role!='admin' ? 'user' : 'admin';
            try {
                $this->user->removeRole($removedRole);
                $this->user->assignRole($newRole);
                $this->emit('success', 'Role berhasil disimpan');
            } catch (Exception $e) {
                $this->emit('error', 'Role gagal disimpan');
            }
            $this->emit('closeModal');
        } else {
            $this->emit('error', 'Anda bukan super admin');
        }
    }

    public function render()
    {
        return view('user.role-modal');
    }
}
