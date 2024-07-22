<?php

namespace Tests\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\WorkOrder;
use App\Utils\PostTypeEnum;
use App\Utils\UserRoleEnum;
use App\Utils\WorkOrderShiftEnum;
use App\Utils\WorkOrderStatusEnum;
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
            'type' => PostTypeEnum::POST_TILE_TYPE->value,
            'title' => 'Post Title',
            'desc' => 'Post Desctiption',
            'user_id' => $this->userId,
        ];
        $model = Post::query()->create($this->post);
        return $model['id'];
    }
    public function testPostRelatedTable()
    {
        $workOrder = [
            'shift' => WorkOrderShiftEnum::NIGHT->value,
            'well_number' => 'P_PETA24_30 (Petani 208)',
            'wbs_number' => 'PTO2/402/3230921DR',
            'is_rig' => false,
            'status' => WorkOrderStatusEnum::STATUS_SENT->value,
            'post_id' => $this->postId,
        ];
        WorkOrder::query()->create($workOrder);
        $firstPost = Post::query()->get()->first();

        foreach ($firstPost->workOrders as $wo) {
            self::assertSame($workOrder['shift'], $wo['shift']);
            self::assertSame($workOrder['well_number'], $wo['well_number']);
            self::assertSame($workOrder['wbs_number'], $wo['wbs_number']);
            self::assertSame($workOrder['is_rig'], $wo['is_rig']);
            self::assertSame($workOrder['status'], $wo['status']);
            self::assertSame($this->postId, $wo['post_id']);
        }
    }
}
