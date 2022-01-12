<?php

namespace App\Http\Livewire\Matter;

use App\Models\Matter;
use Livewire\Component;

class Detail extends Component
{
    public $matter;

    protected $listeners = [
        'reloadMatterDetail' => 'reload',
    ];

    public function mount() {
        $this->matterCode();
    }

    private function getCode($str) {
        $arr = [];
        $i=0;
        $str = strtok($str, "```");
        while ($str !== false) {
            if ($i%2 == 0) {
                $i++;
            } else {
                array_push($arr, $str);
                $i++;
            }

            $str = strtok("```");
        }

        return $arr;
    }

    public function matterCode() {
        $this->matter->code = $this->getCode($this->matter->matter);
        $this->matter->codeInstruction = $this->getCode($this->matter->instruction);
        $this->matter->instruction = explode("```", $this->matter->instruction);
        $this->matter->matter = explode ("```", $this->matter->matter);
    }

    public function reload($id) {
        $this->matter = Matter::whereId($id)->first();
        $this->matterCode();
    }

    public function render()
    {
        return view('matter.detail');
    }
}
