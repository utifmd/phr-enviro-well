<?php

namespace Tests\Service;

use App\Models\User;
use App\Service\IWellService;
use App\Utils\Enums\PostTypeEnum;
use App\Utils\Enums\UserRoleEnum;
use App\Utils\Enums\WorkOrderShiftEnum;
use App\Utils\Enums\WorkOrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WellServiceTest extends TestCase
{
    private IWellService $service;
    private array $post;
    private array $workOrders;
    private array $uploadedUrl;

    protected function setUp(): void
    {
        parent::setUp();
        foreach (['uploaded_urls', 'posts', 'work_orders', 'users'] as $item) {
            DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM " .$item);
        }
        $this->service = $this->app->make(IWellService::class);
        $this->user = [
            'email' => 'phrtest@example.com',
            'username' => 'phrtest',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::USER_PT_ROLE->value,
        ];
        $userModel = User::query()->create($this->user);

        $this->post = [
            'type' => PostTypeEnum::POST_WELL_TYPE->value,
            'title' => 'Pematang P11',
            'desc' => 'Pematang;Pematang 00108;S1-E1-43B',
            'user_id' => $userModel['id']
        ];
        $this->workOrders = [
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_PENDING->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_PENDING->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_PENDING->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-05 13:51:48'),
                'post_id' => null
            ],
        ];
        $this->uploadedUrl = [
            'url' => 'https://via.placeholder.com/150',
            'path' => './public/images/upload/150.png',
            'post_id' => null
        ];
    }

    public function testAddNewWellSuccess()
    {
        $post = $this->service->addNewWell(
            $this->post, $this->uploadedUrl, $this->workOrders
        );
        self::assertNotNull($post);
        self::assertSame($this->post['title'], $post->title);
        self::assertSame($this->post['desc'], $post->desc);
        self::assertSame($this->post['type'], $post->type);

        self::assertSameSize($this->workOrders, $post->workOrders);

        foreach ($post->uploadedUrls as $uploadedUrl) {

            self::assertSame($this->uploadedUrl['url'], $uploadedUrl->url);
            self::assertSame($this->uploadedUrl['path'], $uploadedUrl->path);
            self::assertSame($post->id, $uploadedUrl->post_id);
        }
    }

    public function testGetCountOfLoadPerMonth()
    {
        $this->service->addNewWell(
            $this->post, $this->uploadedUrl, $this->workOrders
        );
        $countOfLoadPerMonth = $this->service->getRecapPerMonth(date('Y'), '07');
        Log::debug(json_encode($countOfLoadPerMonth));
        self::assertTrue(true);
    }
}
