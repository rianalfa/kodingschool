<?php

namespace App\Http\Livewire\Language;

use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ModalLanguage extends ModalComponent
{
    public $language;

    protected function rules() {
        return [
            'language.name' => ['required', Rule::unique('languages')->ignore($this->language->id)],
            'language.description' => 'nullable|string',
        ];
    }

    public function mount($id=null) {
        if ($id!=null) {
            $this->language = Language::whereId($id)->first();
        } else {
            $this->language = new Language();
        }
    }

    public function saveLanguage() {
        if (auth()->user()->hasRole('admin')) {
            $this->validate();
            $saved = $this->language->save();

            if ($saved) {
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
