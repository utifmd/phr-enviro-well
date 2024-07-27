<?php

namespace App\Livewire\Forms;

use App\Models\WellMaster;
use Livewire\Form;

class WellMasterForm extends Form
{
    public ?WellMaster $wellMasterModel;
    
    public $field_name = '';
    public $ids_wellname = '';
    public $well_number = '';
    public $legal_well = '';
    public $job_type = '';
    public $job_sub_type = '';
    public $rig_type = '';
    public $rig_no = '';
    public $wbs_number = '';
    public $actual_drmi = '';
    public $actual_spud = '';
    public $actual_drmo = '';
    public $status = '';

    public function rules(): array
    {
        return [
			'field_name' => 'required|string',
			'ids_wellname' => 'string',
			'well_number' => 'required|string',
			'legal_well' => 'required|string',
			'job_type' => 'required|string',
			'job_sub_type' => 'required|string',
			'rig_type' => 'required|string',
			'rig_no' => 'required|string',
			'wbs_number' => 'required|string',
			'actual_drmi' => 'required',
			'status' => 'required|string',
        ];
    }

    public function setWellMasterModel(WellMaster $wellMasterModel): void
    {
        $this->wellMasterModel = $wellMasterModel;
        
        $this->field_name = $this->wellMasterModel->field_name;
        $this->ids_wellname = $this->wellMasterModel->ids_wellname;
        $this->well_number = $this->wellMasterModel->well_number;
        $this->legal_well = $this->wellMasterModel->legal_well;
        $this->job_type = $this->wellMasterModel->job_type;
        $this->job_sub_type = $this->wellMasterModel->job_sub_type;
        $this->rig_type = $this->wellMasterModel->rig_type;
        $this->rig_no = $this->wellMasterModel->rig_no;
        $this->wbs_number = $this->wellMasterModel->wbs_number;
        $this->actual_drmi = $this->wellMasterModel->actual_drmi;
        $this->actual_spud = $this->wellMasterModel->actual_spud;
        $this->actual_drmo = $this->wellMasterModel->actual_drmo;
        $this->status = $this->wellMasterModel->status;
    }

    public function store(): void
    {
        $this->wellMasterModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->wellMasterModel->update($this->validate());

        $this->reset();
    }
}
