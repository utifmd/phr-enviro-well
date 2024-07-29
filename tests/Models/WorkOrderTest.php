<?php

namespace Tests\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\WorkOrder;
use App\Utils\Enums\PostTypeEnum;
use App\Utils\Enums\UserRoleEnum;
use App\Utils\Enums\WorkOrderShiftEnum;
use App\Utils\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WorkOrderTest extends TestCase
{
    private ?array $user;
    private ?string $userId;

    private ?array $post;
    private ?string $postId;

    protected function setUp(): void
    {
        parent::setUp();
        foreach (['users', 'posts', 'work_orders'] as $item) {
            DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM ". $item);
        }
        $userId = $this->handleNewUser();
        $this->userId = $userId;

        $postId = $this->handleNewPost();
        $this->postId = $postId;
    }
    private function handleNewUser(): string
    {
        $this->user = [
            'email' => 'phrtest@example.com',
            'username' => 'phrtest',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::USER_GUEST_ROLE->value,
        ];
        $model = User::query()->create($this->user);
        return $model['id'];
    }
    private function handleNewPost(): string
    {
        $this->post = [
            'type' => PostTypeEnum::POST_WELL_TYPE->value,
            'title' => 'P_PETA24_29',
            'desc' => 'PTO2/402/3230920DR',
            'user_id' => $this->userId,
        ];
        $model = Post::query()->create($this->post);
        return $model['id'];
    }
    public function testPostRelatedTable()
    {
        $workOrder = [
            'shift' => WorkOrderShiftEnum::DAY->value,
            'is_rig' => false,
            'status' => WorkOrderStatusEnum::STATUS_SENT->value,
            'well_master_id' => '18d347c6-cfe8-4645-8819-ba62cfc8bc7f',
            'post_id' => $this->postId,
        ];
        WorkOrder::query()->create($workOrder);
        $firstPost = Post::query()->get()->first();

        foreach ($firstPost->workOrders as $wo) {
            self::assertSame($workOrder['shift'], $wo['shift']);
            self::assertSame($workOrder['is_rig'], $wo['is_rig']);
            self::assertSame($workOrder['status'], $wo['status']);
            self::assertSame($workOrder['well_master_id'], $wo['well_master_id']);
            self::assertSame($this->postId, $wo['post_id']);
        }
    }
}
