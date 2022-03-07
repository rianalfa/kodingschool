<?php

namespace App\Http\Livewire\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class ModalLanguage extends ModalComponent
{
    use WithFileUploads;

    public $language;
    public $image;

    protected function rules() {
        return [
            'language.name' => 'required|max:25|unique:languages,name,'.$this->language->id.',id',
            'language.description' => 'nullable|string',
            'language.type' => 'required',
            'image' => 'nullable|image|max:4096',
        ];
    }

    public function mount($id=null) {
        $this->language = Language::whereId($id)->first() ?? new Language();
        if (Storage::exists('images/languages/'.$id.'.jpeg')) {
            $this->emit('success', 'image exist');
        }
    }

    public function saveLanguage() {
        if (auth()->user()->hasRole('admin')) {
            $this->validate();
            $saved = $this->language->save();

            if ($saved) {
                if (!empty($this->image)) $this->image->storeAs('images/languages', $this->language->id.'.jpeg');

                $this->emit('success', 'Bahasa berhasil disimpan');
                $this->emitTo('language.grid', 'reloadLanguages');
            } else {
                $this->emit('error', 'Bahasa gagal disimpan');
            }
        } else {
            $this->emit('error', 'Anda bukan admin');
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('language.modal-language');
    }
}
