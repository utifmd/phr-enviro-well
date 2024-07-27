<?php

namespace App\Service;

use App\Mapper\IPostMapper;
use App\Models\Post;
use App\Models\WellMaster;
use App\Repository\IPostRepository;
use App\Repository\IUploadedUrlRepository;
use App\Repository\IUserRepository;
use App\Repository\IWellMasterRepository;
use App\Repository\IWorkOrderRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class WellService implements IWellService
{
    private IPostRepository $postRepository;
    private IUserRepository $userRepository;
    private IUploadedUrlRepository $uploadedUrlRepository;
    private IWorkOrderRepository $workOrderRepository;
    private IWellMasterRepository $wellMasterRepository;

    public function __construct(
        IPostRepository $postRepository,
        IUploadedUrlRepository $uploadedUrlRepository,
        IWorkOrderRepository $workOrderRepository,
        IUserRepository $userRepository,
        IWellMasterRepository $wellMasterRepository
    ){
        $this->postRepository = $postRepository;
        $this->uploadedUrlRepository = $uploadedUrlRepository;
        $this->workOrderRepository = $workOrderRepository;
        $this->userRepository = $userRepository;
        $this->wellMasterRepository = $wellMasterRepository;
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

    public function pagedWellPost(?int $page = null): LengthAwarePaginator
    {
        $user = $this->userRepository->authenticatedUser();
        return $this->postRepository->pagedPostByUserId($user->id, $page);
    }

    function pagedWellMaster(?string $query, ?int $page = null): LengthAwarePaginator
    {
        if (!is_null($query))
            return $this->wellMasterRepository
                ->pagingSearchWellMaster(
                    ['field_name' => $query, 'ids_wellname' => $query, 'well_number' => $query, 'legal_well' => $query, 'wbs_number' => $query]
                );
        return $this->wellMasterRepository
            ->pagingWellMaster();
    }
}
