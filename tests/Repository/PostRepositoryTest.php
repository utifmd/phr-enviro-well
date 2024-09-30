<?php

namespace Tests\Repository;

use App\Models\User;
use App\Repository\IPostRepository;
use App\Repository\IWorkOrderRepository;
use App\Utils\Enums\PostTypeEnum;
use App\Utils\Enums\UserRoleEnum;
use App\Utils\Enums\WorkOrderShiftEnum;
use App\Utils\Enums\WorkOrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    private IPostRepository $postRepository;
    private IWorkOrderRepository $woRepository;
    private ?array $user;
    private ?array $post;

    protected function setUp(): void
    {
        parent::setUp();
        collect(['work_orders', 'posts', 'users'])->map(function ($scheme) {
            DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM " . $scheme);
        });
        $this->postRepository = $this->app->make(IPostRepository::class);
        $this->woRepository = $this->app->make(IWorkOrderRepository::class);
        $this->initialsData();
    }
    private function initialsData(): void
    {
        $this->user = [
            'email' => 'phrtest@example.com',
            'username' => 'phrtest',
            'password' => Hash::make('password'),
            'role' => UserRoleEnum::USER_GUEST_ROLE->value,
        ];
        $user = User::query()->create($this->user);
        $this->post = [
            "type" => PostTypeEnum::POST_TILE_TYPE,
            "title" => "Post Service Title",
            "desc" => "Post Service Desc",
            "user_id" => $user['id']
        ];
    }

    public function testAddPostSuccess()
    {
        $request = $this->post;
        $addedPost = $this->postRepository->addPost($request);

        self::assertNotNull($addedPost);
        self::assertSame($request['title'], $addedPost->title);
        self::assertSame($request['desc'], $addedPost->desc);
        self::assertEquals($request['user_id'], $addedPost->user->id);
    }

    public function testGetPostSuccess()
    {
        $request = $this->post;
        $addedPost = $this->postRepository->addPost($request);
        $postById = $this->postRepository->getPostById($addedPost['id']);

        self::assertNotNull($postById->id);
        self::assertSame($request['title'], $postById->title);
        self::assertSame($request['desc'], $postById->desc);
        self::assertEquals($request['user_id'], $postById->user->id);
    }

    public function testUpdatePostSuccess()
    {
        $request = $this->post;
        $addedPost = $this->postRepository->addPost($request);

        $requestUpdate = $this->post;
        $requestUpdate['title'] = 'Updated Title Post';
        $requestUpdate['desc'] = 'Updated Description Post';

        $updatedPost = $this->postRepository->updatePost($addedPost['id'], $requestUpdate);

        self::assertNotNull($updatedPost->id);
        self::assertSame($requestUpdate['title'], $updatedPost->title);
        self::assertSame($requestUpdate['desc'], $updatedPost->desc);
        self::assertEquals($requestUpdate['user_id'], $updatedPost->user->id);
    }

    public function testRemovePostSuccess()
    {
        $request = $this->post;
        $addedPost = $this->postRepository->addPost($request);

        $isRemovedPost = $this->postRepository->removePost($addedPost['id']);
        self::assertTrue($isRemovedPost);

        $removedPost = $this->postRepository->getPostById($addedPost['id']);
        self::assertNull($removedPost);
    }

    public function testCountLoadPostBy()
    {
        $request = $this->post;
        $addedPost = $this->postRepository->addPost($request);
        $workOrdersRequest = [
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_ACCEPTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_ACCEPTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_ACCEPTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_ACCEPTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-05 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_ACCEPTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_REJECTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-03 13:51:48'),
                'post_id' => null
            ],
            [
                'shift' => WorkOrderShiftEnum::NIGHT->value,
                'is_rig' => false,
                'status' => WorkOrderStatusEnum::STATUS_ACCEPTED->value,
                'ids_wellname' => 'Pematang P11',
                'created_at' => new Carbon('2024-07-05 13:51:48'),
                'post_id' => null
            ],
        ]; // 7x

        foreach ($workOrdersRequest as $workOrderRequest) {
            $workOrderRequest['post_id'] = $addedPost['id'];
            $this->woRepository->addWorkOrder($workOrderRequest);
        }
        self::assertNotNull($request['user_id']);

        $loadPostByCount = $this->postRepository->countLoadPostBy(
            $request['user_id'], WorkOrderStatusEnum::STATUS_ACCEPTED->value
        );
        self::assertSame(6, $loadPostByCount);
    }
}
