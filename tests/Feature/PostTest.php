<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Utils\PostTypeEnum;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostTest extends TestCase
{
    private Post $model;

    protected function setUp(): void
    {
        parent::setUp();
        DB::connection(env('DB_CONNECTION'))->delete("DELETE FROM posts");

        $this->initModel();
    }

    private function initModel(): void
    {
        $this->model = new Post();
        $this->model->type = PostTypeEnum::POST_TILE_TYPE->value;
        $this->model->title = 'Post Title';
        $this->model->desc = 'Post Desctiption';
        $this->model->user_id = 'b0d3837b-11e1-4751-aef7-fb83eebaa010';
    }
    public function testCreateSuccess()
    {
        $isInsertedPost = $this->model->save();
        self::assertTrue($isInsertedPost);
    }

    public function testGetRelatedPostSuccess()
    {
        $this->model->save();
        $firstPost = Post::query()->where('id', 'LIKE', '%%')->get()->first();

        self::assertSame($this->model->type, $firstPost->type);
        self::assertSame($this->model->title, $firstPost->title);
        self::assertSame($this->model->desc, $firstPost->desc);
        self::assertSame($this->model->user_id, $firstPost->user->id);
    }
}
