<?php

namespace Tests\Repository;

use App\Repository\IUploadedUrlRepository;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadedUrlRepositoryTest extends TestCase
{
    private IUploadedUrlRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(IUploadedUrlRepository::class);
    }

    public function testUpdateUploadedUrl()
    {
        $uploadedUrlId = '70';
        $request = [
            'url' => 'https://example.com/150.png',
            'path' => '/example/example/150.png'
        ];
        $updateUploadedUrl = $this->repository->updateUploadedUrl(
            $uploadedUrlId, $request
        );
        self::assertNotNull($updateUploadedUrl);
        self::assertNotSame($request['url'], $updateUploadedUrl->url);
        self::assertNotSame($request['path'], $updateUploadedUrl->path);
    }

    public function testUpdateUploadedUrlBy()
    {
        $postId = 'a7443a29-e605-4d01-be01-ad55f0d63d3e';
        $request = [
            'url' => 'https://example.com/150.png',
            'path' => '/example/example/150.png'
        ];
        $updateUploadedUrl = $this->repository->updateUploadedUrlBy($postId, $request);

        self::assertNotNull($updateUploadedUrl);
        self::assertNotSame($request['url'], $updateUploadedUrl->url);
        self::assertNotSame($request['path'], $updateUploadedUrl->path);
    }

    public function testDeleteImageByPath()
    {
        $filePath = 'app/public/images/b9619650-3cf1-4300-b3bc-ca51f59f89be/20240807032926.jpg';
        // $isDeleted = Storage::delete($filePath);
        $isDeleted = unlink(storage_path($filePath));

        self::assertTrue($isDeleted);
        self::assertFileDoesNotExist($filePath);
    }
}
