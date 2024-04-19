<?php

namespace App\Packages\Emerald\RestfulAPI;

use App\Http\Controllers\Controller;
use App\Packages\{Emerald\Controllers\CrudControllerHelper,
    Emerald\Repositories\Interfaces\RepositoryContractCrud,
    Emerald\Resources\ResourceCollections,
    Emerald\HttpFoundation\Response};

class ResourceController extends Controller implements ResourceControllerContract
{
    use CrudControllerHelper;

    protected
        /**
         * determine which paymentRepository.
         *
         * @var RepositoryContractCrud
         */
        $repository,

        /**
         * determine which FormRequest use in store.
         *
         * @var string|null
         */
        $storeRequest,

        /**
         * determine which FormRequest use in update.
         *
         * @var string|null
         */
        $updateRequest,

        /**
         * determine the resource use it.
         *
         * @var string|null
         */
        $theResource,


        /**
         * use pagination if needed default false.
         *
         * @var bool
         */
        $pagination = false,

        /**
         * pagination per page default 6.
         *
         * @var string|null
         */
        $perPage = 6,

        /**
         * @var int|null
         */
        $userId;

    /**
     * Controller constructor.
     * @param RepositoryContractCrud $repository
     */
    public function __construct(RepositoryContractCrud $repository)
    {
        $this->repository = $repository;

        if ($this->pagination && empty($this->theResource)) {
            throw new \InvalidArgumentException('Please declare and specify the resource');
        }

        $this->userId = auth('sanctum')->user()->id ?? null;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response([
            'data' => new ResourceCollections($this->repository->index($this->pagination, $this->perPage), $this->theResource, $this->pagination),
            'message' => 'list all'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(): Response
    {
        $request = app($this->storeRequest);
        return new Response([
            'data' => $this->repository->store($request->validated()),
            'message' => 'created successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update(int $id): Response
    {
        $request = app($this->updateRequest);
        return new Response([
            'data' => $this->repository->update($request->validated(), $id),
            'message' => 'updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $this->repository->destroy($id);
        return new Response([
            'message' => 'Request success, Delete specified resource from storage',
        ]);
    }

    /**
     * Change status of the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function status(int $id): Response
    {
        $this->repository->status($id);
        return new Response([
            'message' => 'Updated successfully',
        ]);
    }
}
