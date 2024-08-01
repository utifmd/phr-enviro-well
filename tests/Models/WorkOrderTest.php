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
            'title' => 'Pematang P11',
            'desc' => 'Pematang;Pematang 00108;S1-E1-43B',
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
            'status' => WorkOrderStatusEnum::STATUS_PENDING->value,
            'ids_wellname' => 'Pematang P11',
            'post_id' => $this->postId,
        ];
        WorkOrder::query()->create($workOrder);
        $firstPost = Post::query()->get()->first();

        foreach ($firstPost->workOrders as $wo) {
            self::assertSame($workOrder['shift'], $wo['shift']);
            self::assertSame($workOrder['is_rig'], $wo['is_rig']);
            self::assertSame($workOrder['status'], $wo['status']);
            self::assertSame($workOrder['ids_wellname'], $wo['ids_wellname']);
            self::assertSame($this->postId, $wo['post_id']);
        }
    }
}
