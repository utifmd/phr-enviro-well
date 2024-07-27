<?php

namespace App\Livewire\WellMasters;

use App\Livewire\Forms\WellMasterForm;
use App\Models\WellMaster;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public WellMasterForm $form;

    public function mount(WellMaster $wellMaster)
    {
        $this->form->setWellMasterModel($wellMaster);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.well-master.show', ['wellMaster' => $this->form->wellMasterModel]);
    }
}
