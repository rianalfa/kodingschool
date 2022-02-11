<?php

namespace App\Http\Livewire\User;

use App\Models\UserDetail;
use Livewire\Component;

class UpdateDetailInformationForm extends Component
{
    public $detail;

    protected $rules = [
        'detail.year' => 'nullable|between:1,4|size:1',
        'detail.class' => 'nullable|string|size:4',
        'detail.address' => 'nullable|string',
        'detail.phone' => 'nullable|numeric|starts_with:628|min:12|max:14',
        'detail.motto' => 'nullable|string',
        'detail.level_id' => 'required|exists:levels,id|min:1',
        'detail.point' => 'required|min:0',
    ];

    public function mount()
    {
        $this->detail = auth()->user()->detail ?? new UserDetail();
    }

    public function render()
    {
        return view('profile.update-detail-information-form');
    }

    public function updateProfileDetailInformation()
    {
        $this->validate();
        auth()->user()->detail()->save($this->detail);
    }
}
