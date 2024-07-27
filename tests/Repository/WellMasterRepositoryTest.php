<?php

namespace Tests\Repository;

use App\Repository\IWellMasterRepository;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WellMasterRepositoryTest extends TestCase
{
    private IWellMasterRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(IWellMasterRepository::class);
    }

    public function testPagingSearchWellMaster()
    {
        $params = [
            'field_name' => 'peTani',
            'ids_wellname' => 'peTani',
            'well_number' => '',
            'legal_well' => '',
            'wbs_number' => ''
        ];
        $wellMasters = $this->repository->pagingSearchWellMaster($params);

        $arr = [];
        for ($i = 0; $i < $wellMasters->perPage(); $i++) {
            $arr[$i] = $i;
        }
        self::assertSameSize($arr, $wellMasters->all());
        self::assertTrue(true);
    }
}
