<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Request extends Component
{

    public $mode = 'sent';
    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    public function render()
    {
        return view('livewire.request');
    }
}
