<?php

namespace App\Http\Livewire\Chapter;

use App\Models\Chapter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Admin extends Component
{
    public $language;
    public $name;
    public $number;

    protected $rules = [
        'name' => 'required|unique:chapters|max:25',
        'number' => 'required',
    ];

    public function mount($id) {
        $this->language = $id;
    }

    public function render()
    {
        return view('chapter.admin');
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

    public function addNewChapter() {
        if (User::findOrFail(Auth::user()->id)->hasRole('admin')) {
            $this->openModal('modalTambahChapter');
            $this->validate();

            $chapter = Chapter::create([
                'name' => $this->name,
                'language_id' => $this->language,
                'number' => $this->number,
            ]);

            if ($chapter) {
                $this->dispatchBrowserEvent('swal', [
                    'icon' => 'success',
                    'iconColor' => '#0ea5e9',
                    'title' => 'Berhasil!',
                    'text' => 'Bab baru berhasil ditambahkan.',
                    'timer' => 5000,
                    'buttonsStyling' => false,
                    'customClass' => [
                        'confirmButton' => 'font-semibold text-sm tracking-widest bg-sky-500 hover:bg-sky-400 text-white rounded-md active:bg-sky-400 focus:border-sky-400 focus:ring-sky-300 anchor-button py-2 px-4'
                    ],
                ]);

                $this->closeModal('modalTambahChapter');
                $this->emitTo('language.show', 'reloadAll');
            }
        }
    }
}
