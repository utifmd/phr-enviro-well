<?php

namespace Tests\Models;

use App\Models\Post;
use App\Models\UploadedUrl;
use App\Models\User;
use App\Utils\Enums\PostTypeEnum;
use App\Utils\Enums\UserRoleEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UploadedUrlTest extends TestCase
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
        $this->userId = $this->createUser();
        $this->postId = $this->createPost();
    }

    private function createUser(): string
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
    private function createPost(): string
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
        $uploadedUrl = [
            'url' => 'https://via.placeholder.com/150',
            'path' => './public/images/upload/150.png',
            'post_id' => $this->postId
        ];
        UploadedUrl::query()->create($uploadedUrl);
        $firstPost = Post::query()->get()->first();

        foreach ($firstPost->uploadedUrls as $udl) {
            self::assertSame($uploadedUrl['url'], $udl['url']);
            self::assertSame($uploadedUrl['path'], $udl['path']);
        }
    }
}
