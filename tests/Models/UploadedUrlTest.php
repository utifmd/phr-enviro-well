<?php

namespace Tests\Models;

use App\Models\Post;
use App\Models\UploadedUrl;
use App\Models\User;
use App\Utils\PostTypeEnum;
use App\Utils\UserRoleEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UploadedUrlTest extends TestCase
{
    private ?Post $postModel;

    private ?array $user;
    private ?array $post;
    private ?string $userId;
    private ?string $postId;

    protected function setUp(): void
    {
        parent::setUp();

        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM uploaded_urls");
        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM posts");
        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM users");

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
        $this->postModel = new Post($model->get()->toArray());
        return $model['id'];
    }
    public function testPostRelateUploadedUrl()
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
