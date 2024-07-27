<div class="space-y-6">
    <div>
        <x-input-label for="field_name" :value="__('Field Name')"/>
        <x-text-input wire:model="form.field_name" id="field_name" name="field_name" type="text" class="mt-1 block w-full" autocomplete="field_name" placeholder="Field Name"/>
        @error('form.field_name')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="ids_wellname" :value="__('Ids Wellname')"/>
        <x-text-input wire:model="form.ids_wellname" id="ids_wellname" name="ids_wellname" type="text" class="mt-1 block w-full" autocomplete="ids_wellname" placeholder="Ids Wellname"/>
        @error('form.ids_wellname')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="well_number" :value="__('Well Number')"/>
        <x-text-input wire:model="form.well_number" id="well_number" name="well_number" type="text" class="mt-1 block w-full" autocomplete="well_number" placeholder="Well Number"/>
        @error('form.well_number')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="legal_well" :value="__('Legal Well')"/>
        <x-text-input wire:model="form.legal_well" id="legal_well" name="legal_well" type="text" class="mt-1 block w-full" autocomplete="legal_well" placeholder="Legal Well"/>
        @error('form.legal_well')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="job_type" :value="__('Job Type')"/>
        <x-text-input wire:model="form.job_type" id="job_type" name="job_type" type="text" class="mt-1 block w-full" autocomplete="job_type" placeholder="Job Type"/>
        @error('form.job_type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="job_sub_type" :value="__('Job Sub Type')"/>
        <x-text-input wire:model="form.job_sub_type" id="job_sub_type" name="job_sub_type" type="text" class="mt-1 block w-full" autocomplete="job_sub_type" placeholder="Job Sub Type"/>
        @error('form.job_sub_type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="rig_type" :value="__('Rig Type')"/>
        <x-text-input wire:model="form.rig_type" id="rig_type" name="rig_type" type="text" class="mt-1 block w-full" autocomplete="rig_type" placeholder="Rig Type"/>
        @error('form.rig_type')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="rig_no" :value="__('Rig No')"/>
        <x-text-input wire:model="form.rig_no" id="rig_no" name="rig_no" type="text" class="mt-1 block w-full" autocomplete="rig_no" placeholder="Rig No"/>
        @error('form.rig_no')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="wbs_number" :value="__('Wbs Number')"/>
        <x-text-input wire:model="form.wbs_number" id="wbs_number" name="wbs_number" type="text" class="mt-1 block w-full" autocomplete="wbs_number" placeholder="Wbs Number"/>
        @error('form.wbs_number')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="actual_drmi" :value="__('Actual Drmi')"/>
        <x-text-input wire:model="form.actual_drmi" id="actual_drmi" name="actual_drmi" type="text" class="mt-1 block w-full" autocomplete="actual_drmi" placeholder="Actual Drmi"/>
        @error('form.actual_drmi')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="actual_spud" :value="__('Actual Spud')"/>
        <x-text-input wire:model="form.actual_spud" id="actual_spud" name="actual_spud" type="text" class="mt-1 block w-full" autocomplete="actual_spud" placeholder="Actual Spud"/>
        @error('form.actual_spud')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="actual_drmo" :value="__('Actual Drmo')"/>
        <x-text-input wire:model="form.actual_drmo" id="actual_drmo" name="actual_drmo" type="text" class="mt-1 block w-full" autocomplete="actual_drmo" placeholder="Actual Drmo"/>
        @error('form.actual_drmo')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input wire:model="form.status" id="status" name="status" type="text" class="mt-1 block w-full" autocomplete="status" placeholder="Status"/>
        @error('form.status')
            <x-input-error class="mt-2" :messages="$message"/>
        @enderror
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>
