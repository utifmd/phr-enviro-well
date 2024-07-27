<?php

namespace Tests\Models;

use App\Models\WellMaster;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WellMasterTest extends TestCase
{
    private function readCSV($csvFile, $delimiter = ','): ?array
    {
        $line_of_text = null;
        $file_handle = fopen($csvFile, 'r');
        while ($csvRow = fgetcsv($file_handle, null, $delimiter)) {
            $line_of_text[] = $csvRow;
        }
        fclose($file_handle);
        return $line_of_text;
    }

    public function testPostWellMasterFromCsvFile()
    {
        $csvFileName = "well_masters.csv";
        $csvFile = public_path('csv/' . $csvFileName);
        $wellMasters = $this->readCSV($csvFile);

        self::assertIsArray($wellMasters);

        $dataInput = [
            'field_name', 'ids_wellname', 'well_number', 'legal_well', 'job_type', 'job_sub_type', 'rig_type', 'rig_no', 'wbs_number', 'actual_drmi', 'actual_spud', 'actual_drmo', 'status'
        ];
        foreach ($wellMasters as $wellMaster){
            $dataOutput = [];
            $exploded = explode(';', collect($wellMaster)->first());
            foreach ($exploded as $i => $item) {
                $dataOutput[$dataInput[$i] ?? $i] = $item;
            }
            /*Log::debug(json_encode($dataOutput));
            if ($idx == 2) break;*/
            WellMaster::query()->create($dataOutput);
        }
        self::assertTrue(true);
    }

    public function testGetKeyOfArray()
    {
        $params = [
            'field_name' => '2',
            'ids_wellname' => 'peTani',
            'well_number' => '1',
            'legal_well' => '4',
            'wbs_number' => '5',
        ];
        // Log::debug('testGetKeyOfArray: key: '.array_key_first($params). ' | value: '. $params['field_name']);
        foreach ($params as $key => $param) {
            Log::debug('testGetKeyOfArray: key: '.$key. ' | value: '. $param);
        }
        self::assertTrue(true);
    }
}
