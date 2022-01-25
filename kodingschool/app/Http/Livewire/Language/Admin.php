<?php

namespace App\Http\Livewire\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Admin extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|unique:languages',
    ];

    public function mount()
    {
        abort_if(!User::findOrFail(Auth::user()->id)->hasRole('admin'), 401);
    }

    public function render()
    {
        return view('language.admin');
    }

    public function openModal($id) {
        $this->dispatchBrowserEvent('modal', [
            'type' => 'open',
            'id' => $id,
        ]);
    }

    public function closeModal($id) {
        $this->dispatchBrowserEvent('modal', [
            'type' => 'close',
            'id' => $id,
        ]);
    }

    public function addNewLanguage() {
        if (User::findOrFail(Auth::user()->id)->hasRole('admin')) {
            $this->openModal('modalTambahBahasa');
            $this->validate();

            $language = Language::create(['name' => $this->name]);
            if ($language) {
                $this->dispatchBrowserEvent('swal', [
                    'icon' => 'success',
                    'iconColor' => '#0ea5e9',
                    'title' => 'Berhasil!',
                    'text' => 'Bahasa baru berhasil ditambahkan.',
                    'timer' => 5000,
                    'buttonsStyling' => false,
                    'customClass' => [
                        'confirmButton' => 'font-semibold text-sm tracking-widest bg-sky-500 hover:bg-sky-400 text-white rounded-md active:bg-sky-400 focus:border-sky-400 focus:ring-sky-300 anchor-button py-2 px-4'
                    ],
                ]);
                $this->closeModal('modalTambahBahasa');
                $this->emitTo('language.grid', 'reloadLanguages');
            }
        }
    }
}
