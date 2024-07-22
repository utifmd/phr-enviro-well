<?php

namespace Tests\Service;

use App\Models\User;
use App\Service\IPostService;
use App\Utils\PostTypeEnum;
use App\Utils\UserRoleEnum;
use App\Utils\WorkOrderShiftEnum;
use App\Utils\WorkOrderStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    private IPostService $service;
    private array $post;
    private array $workOrder;
    private array $uploadedUrl;

    protected function setUp(): void
    {
        parent::setUp();
        foreach (['uploaded_urls', 'posts', 'work_orders', 'users'] as $item) {
            DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM " .$item);
        }
        $this->service = $this->app->make(IPostService::class);
        $this->user = [
            'email' => 'phrtest@example.com',
            'username' => 'phrtest',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::USER_GUEST_ROLE->value,
        ];
        $userModel = User::query()->create($this->user);

        $this->post = [
            'type' => PostTypeEnum::POST_TILE_TYPE->value,
            'title' => 'Post Title',
            'desc' => 'Post Desctiption',
            'user_id' => $userModel['id']
        ];
        $this->workOrder = [
            'shift' => WorkOrderShiftEnum::NIGHT->value,
            'well_number' => 'P_PETA24_30 (Petani 208)',
            'wbs_number' => 'PTO2/402/3230921DR',
            'is_rig' => false,
            'status' => WorkOrderStatusEnum::STATUS_SENT->value,
            'post_id' => null,
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
            postRequest: $this->post,
            workOrderRequest: $this->workOrder,
            uploadedUrlRequest: $this->uploadedUrl
        );
        self::assertNotNull($post);
        self::assertSame($this->post['title'], $post->title);
        self::assertSame($this->post['desc'], $post->desc);
        self::assertSame($this->post['type'], $post->type);

        foreach ($post->workOrders as $workOrder) {

            self::assertSame($this->workOrder['shift'], $workOrder->shift);
            self::assertSame($this->workOrder['well_number'], $workOrder->well_number);
            self::assertSame($this->workOrder['wbs_number'], $workOrder->wbs_number);
            self::assertSame($this->workOrder['is_rig'], $workOrder->is_rig);
            self::assertSame($this->workOrder['status'], $workOrder->status);
            self::assertSame($post->id, $workOrder->post_id);
        }
        foreach ($post->uploadedUrls as $uploadedUrl) {

            self::assertSame($this->uploadedUrl['url'], $uploadedUrl->url);
            self::assertSame($this->uploadedUrl['path'], $uploadedUrl->path);
            self::assertSame($post->id, $uploadedUrl->post_id);
        }
    }
}
