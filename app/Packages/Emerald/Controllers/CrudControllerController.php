<?php

namespace App\Packages\Emerald\Controllers;

use App\{Http\Controllers\Controller,
    Packages\Emerald\Controllers\Interfaces\CrudControllerContract,
    Packages\Emerald\Repositories\Interfaces\RepositoryContractCrud,
    Packages\Emerald\HttpFoundation\Response
};
use BadMethodCallException;
use Error;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @TODO add permission (class, pattern, trait)
 *
 * Class CrudControllerController
 * @package App\Packages\Emerald\Controllers
 */
abstract class CrudControllerController extends Controller implements CrudControllerContract
{
    protected string|null $view,
        $storeRequest,
        $updateRequest,
        $theResource,
        $route;
    protected int $perPage = 6;
    protected bool $pagination = false;


    /**
     * CrudControllerController constructor.
     * @param RepositoryContractCrud $repository
     */
    public function __construct(protected RepositoryContractCrud $repository)
    {
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return new Response([
            'data' => $this->repository->index($this->pagination, $this->perPage),
            'view' => $this->indexView(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return new Response([
            'data' => $this->repository->create([]),
            'view' => $this->storeView(),
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
        $this->repository->store($request->validated());
        return new Response([
            'redirect' => $this->storeRedirect(),
            'alert' => $this->storeAlert('success', 'Added new')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        return new Response([
            'data' => $this->repository->show($id),
            'view' => $this->showView(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        return new Response([
            'data' => $this->repository->edit($id),
            'view' => $this->editView(),
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
            'redirect' => $this->updateRedirect($id),
            'alert' => $this->updateAlert('success', 'Updated one')
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
            'redirect' => $this->deleteRedirect(),
            'alert' => $this->destroyAlert('success', 'Deleted')
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
            'route' => $this->statusRedirect(),
            'alert' => $this->statusAlert('success', 'updated')
        ]);
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed|string
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, ['storeRedirect', 'updateRedirect', 'deleteRedirect', 'statusRedirect'])) {
            return $this->homeRedirect();
        }

        if (in_array($method, ['storeAlert', 'updateAlert', 'destroyAlert', 'statusAlert'])) {
            return $this->alert($parameters[0], $parameters[1]);
        }

        if (in_array($method, ['indexView', 'storeView', 'showView', 'editView'])) {
            $viewName = explode("View", $method, 2)[0];
            return $this->view($viewName);
        }

        try {
            return $this->{$method}(...$parameters);
        } catch (Error|BadMethodCallException $e) {
            $pattern = '~^Call to undefined method (?P<class>[^:]+)::(?P<method>[^\(]+)\(\)$~';

            if (!preg_match($pattern, $e->getMessage(), $matches)) {
                throw $e;
            }

            if ($matches['class'] !== get_class($this) || $matches['method'] !== $method) {
                throw $e;
            }

            throw new BadMethodCallException(sprintf(
                'Call to undefined method %s::%s()', static::class, $method
            ));
        }
    }

    /**
     * @return string
     */
    private function homeRedirect(): string
    {
        return route($this->route . 'index');
    }

    /**
     * @param string $type
     * @param string $html
     * @return array
     */
    #[ArrayShape(['type' => "string", 'html' => "string"])]
    private function alert(string $type, string $html): array
    {
        return ['type' => $type, 'html' => $html];
    }

    /**
     * @param string $viewName
     * @return string
     */
    private function view(string $viewName): string
    {
        return $this->view . $viewName;
    }
}
