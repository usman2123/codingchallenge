<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NetworkConnections extends Component
{
    public $showSuggestion = true;
    public $showRequest = false;
    public $showReceivedRequest = false;
    public $showConnections = false;

    public function render()
    {
        return view('livewire.network-connections');
    }

    public function showTab($tab){
        $this->showSuggestion = false;
        $this->showRequest = false;
        $this->showReceivedRequest = false;
        $this->showConnections = false;

        $this->$tab = true;
    }
}
