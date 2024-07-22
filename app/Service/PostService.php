<?php

namespace App\Service;

use App\Mapper\IPostMapper;
use App\Models\Post;
use App\Repository\IPostRepository;
use App\Repository\IUploadedUrlRepository;
use App\Repository\IWorkOrderRepository;
use Illuminate\Support\Facades\Log;

class PostService implements IPostService
{
    private IPostRepository $postRepository;
    private IUploadedUrlRepository $uploadedUrlRepository;
    private IWorkOrderRepository $workOrderRepository;

    private IPostMapper $postMapper;

    public function __construct(
        IPostRepository $postRepository,
        IUploadedUrlRepository $uploadedUrlRepository,
        IWorkOrderRepository $workOrderRepository,
        IPostMapper $postMapper
    ){
        $this->postRepository = $postRepository;
        $this->uploadedUrlRepository = $uploadedUrlRepository;
        $this->workOrderRepository = $workOrderRepository;
        $this->postMapper = $postMapper;
    }

    function addNewWell(
        array $postRequest, array $workOrderRequest, array $uploadedUrlRequest): ?Post {
        $post = null;
        $this->postRepository->beginTransaction();
        try {
            $postOrNull = $this->postRepository
                ->addPost($postRequest);

            if (is_null($postOrNull)) return null;
            $postId = $postOrNull->id;

            $workOrderRequest['post_id'] = $postId;
            $this->workOrderRepository
                ->addWorkOrder($workOrderRequest);

            $uploadedUrlRequest['post_id'] = $postId;
            $this->uploadedUrlRepository
                ->addUploadedUrl($uploadedUrlRequest);

            $post = $this->postRepository
                ->getPostById($postId);

            $this->postRepository->commitTransaction();
        } catch (\Throwable $throwable){

            Log::debug($throwable->getMessage());
            $this->postRepository->rollback();
        }
        return $post;
    }

    function getWellPostById(string $postId): ?Post
    {
        return $this->postRepository->getPostById($postId);
    }
}
