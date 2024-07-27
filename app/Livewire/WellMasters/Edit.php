<?php

namespace App\Livewire\WellMasters;

use App\Livewire\Forms\WellMasterForm;
use App\Models\WellMaster;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public WellMasterForm $form;

    public function mount(WellMaster $wellMaster)
    {
        $this->form->setWellMasterModel($wellMaster);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('well-masters.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.well-master.edit');
    }
}
