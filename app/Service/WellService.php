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
use App\Utils\Enums\WorkOrderStatusEnum;
use App\Utils\IUtility;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class WellService implements IWellService
{
    private IPostRepository $postRepository;
    private IUploadedUrlRepository $uploadedUrlRepository;
    private IWorkOrderRepository $workOrderRepository;
    private IWellMasterRepository $wellMasterRepository;
    private IUtility $utility;
    private ?string $userId = null;

    public function __construct(
        IPostRepository $postRepository,
        IUploadedUrlRepository $uploadedUrlRepository,
        IWorkOrderRepository $workOrderRepository,
        IUserRepository $userRepository,
        IWellMasterRepository $wellMasterRepository,
        IUtility $utility
    ){
        $this->userId = $userRepository->authenticatedUser()->id;
        $this->postRepository = $postRepository;
        $this->uploadedUrlRepository = $uploadedUrlRepository;
        $this->workOrderRepository = $workOrderRepository;
        $this->wellMasterRepository = $wellMasterRepository;
        $this->utility = $utility;
    }

    function addNewWell(
        array $postRequest, array $uploadedUrlRequest, array $workOrdersRequest): ?Post {
        $post = null;
        $this->postRepository->beginTransaction();
        try {
            $postOrNull = $this->postRepository
                ->addPost($postRequest);

            if (is_null($postOrNull)) return null;
            $postId = $postOrNull->id;

            $uploadedUrlRequest['post_id'] = $postId;
            $this->uploadedUrlRepository
                ->addUploadedUrl($uploadedUrlRequest);

            foreach ($workOrdersRequest as $workOrderRequest) {
                $workOrderRequest['post_id'] = $postId;
                $this->workOrderRepository
                    ->addWorkOrder($workOrderRequest);
            }
            $post = $this->postRepository
                ->getPostById($postId);

            $this->postRepository->commitTransaction();
        } catch (\Throwable $throwable){

            Log::debug($throwable->getMessage());
            $this->postRepository->rollback();
        }
        return $post;
    }

    public function updateWell(
        array $postRequest, array $uploadedUrlRequest, array $workOrdersRequest): ?Post {
        $post = null;
        $this->postRepository->beginTransaction();
        try {
            $postOrNull = $this->postRepository->updatePost($postRequest['id'], $postRequest);

            if (is_null($postOrNull)) return null;
            $postId = $postRequest['id']; //$postOrNull->id;

            $uploadedUrlRequest['post_id'] = $postId;
            $this->uploadedUrlRepository->updateUploadedUrl(
                $uploadedUrlRequest['id'], $uploadedUrlRequest
            );
            if (count($workOrdersRequest) > 0) {
                $this->workOrderRepository->removeWorkOrderBy($postId); // ?? throw new \Exception('remove work order failed.');

                foreach ($workOrdersRequest as $workOrder) {
                    $workOrder['post_id'] = $postId;
                    $this->workOrderRepository->addWorkOrder($workOrder); // ?? throw new \Exception('add work order failed.');
                }
            }
            $post = $this->postRepository
                ->getPostById($postId);

            $this->postRepository->commitTransaction();
        } catch (\Throwable $throwable){

            Log::debug('transaction: '. $throwable->getMessage());
            $this->postRepository->rollback();
        }
        return $post;
    }

    function getWellPostById(string $postId): ?Post
    {
        return $this->postRepository->getPostById($postId);
    }

    public function getRecapPerMonth(string $year, string $month): ?array
    {
        $days = $this->utility->datesOfTheMonth();
        $names = $this->workOrderRepository->getWorkOrderNameByMonth($year, $month)->all();
        $view = ['data' => []];
        foreach ($names as $i => $name){

            $isRig = $name['is_rig'];
            $loads = $this->workOrderRepository->getWorkOrderLoadBy($year, $month, $name['ids_wellname'], $isRig)->all();
            $combinedDashboard = $this->utility->combineDashboardArrays($loads, $days);
            $combinedDashboard["num"] = $i +1;
            $wellNumber = $name['ids_wellname'] . ($isRig ? '' : ' (Non Rig)');
            $combinedDashboard["ids_wellname"] = $name['ids_wellname'];
            $combinedDashboard["well_number"] = $wellNumber;
            $combinedDashboard["wbs_number"] = $name['wbs_number'];

            $view['data'][] = $combinedDashboard;
        }
        $view['days'] = $days;
        return $view;
    }

    public function pagedWellPost(
        ?bool $isBypassed = null, ?string $idsWellName = null): LengthAwarePaginator
    {
        if ($isBypassed) return $this->postRepository->pagedPosts($idsWellName);

        return $this->postRepository->pagedPostByUserId($this->userId);
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

    public function removeWellMasterBy(string $id): bool
    {
        return $this->wellMasterRepository->delete($id);
    }
    public function getUserLoadSoFar(): array
    {
        $statistics = array();
        $totalCount = $this->postRepository->countLoadPostBy($this->userId);
        $acceptedCount = $this->postRepository->countLoadPostBy(
            $this->userId, WorkOrderStatusEnum::STATUS_ACCEPTED->value
        );
        $rejectedCount = $this->postRepository->countLoadPostBy(
            $this->userId, WorkOrderStatusEnum::STATUS_REJECTED->value
        );
        $statistics['total_request'] = $totalCount;
        $statistics['accepted_request'] = $acceptedCount;
        $statistics['rejected_request'] = $rejectedCount;
        $statistics['pending_request'] = max(
            $totalCount - ($rejectedCount + $totalCount), 0
        );
        return $statistics;
    }
}
