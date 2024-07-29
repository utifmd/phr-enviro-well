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
use App\Utils\IUtility;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class WellService implements IWellService
{
    private IPostRepository $postRepository;
    private IUserRepository $userRepository;
    private IUploadedUrlRepository $uploadedUrlRepository;
    private IWorkOrderRepository $workOrderRepository;
    private IWellMasterRepository $wellMasterRepository;
    private IUtility $utility;

    public function __construct(
        IPostRepository $postRepository,
        IUploadedUrlRepository $uploadedUrlRepository,
        IWorkOrderRepository $workOrderRepository,
        IUserRepository $userRepository,
        IWellMasterRepository $wellMasterRepository,
        IUtility $utility
    ){
        $this->postRepository = $postRepository;
        $this->uploadedUrlRepository = $uploadedUrlRepository;
        $this->workOrderRepository = $workOrderRepository;
        $this->userRepository = $userRepository;
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

    function getWellPostById(string $postId): ?Post
    {
        return $this->postRepository->getPostById($postId);
    }

    private function combineDashboardBy(array $loads, array $days): array
    {
        $view = [];
        $colSum = 0;
        for ($i = 0; $i < count($days); $i++) {
            $result = 0;
            foreach ($loads as $load){
                if ($load['day'] != $days[$i]) continue;

                $result = $load['count'];
                $colSum += $result;
            }
            $view['days'][$i+1] = $result;
        }
        $view['total'] = $colSum;

        return $view;
    }

    public function getCountOfLoadPerMonth(int $month): ?array
    {
        $days = $this->utility->datesOfTheMonth();
        $names = $this->workOrderRepository->getWorkOrderNameByMonth($month)->all();
        $view = [];
        // $date = date('M Y');
        foreach ($names as $i => $name){

            $loads = $this->workOrderRepository->getWorkOrderLoadBy($month, $name['id'])->all();
            $combinedDashboard = $this->combineDashboardBy($loads, $days);
            $combinedDashboard["num"] = $i +1;
            $combinedDashboard["id"] = $name['id'];
            $combinedDashboard["well_number"] = $name['ids_wellname'];
            $combinedDashboard["wbs_number"] = $name['wbs_number'];

            $view['data'][] = $combinedDashboard;
        }
        $view['days'] = $days;
        return $view;
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
