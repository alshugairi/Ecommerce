<?php

namespace App\Http\Controllers\Administration;

use App\{Http\Controllers\Controller,
    Http\Requests\Administration\PermissionRequest,
    Packages\Emerald\Livewire\Filters\SearchFilterPipeline,
    Packages\Emerald\Livewire\Filters\SortFilterPipeline,
    Services\Administration\PermissionService};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.administration.permission.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('modules.administration.permission.create');
    }

    /**
     * @param PermissionRequest $request
     * @return RedirectResponse
     */
    public function store(PermissionRequest $request): RedirectResponse
    {
        $this->service->handleCreate(data: $request->validated());
        flash(__('modules/administration/permission.permission_created_successfully'))->success();
        return redirect()->route(route: 'permissions.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $data = $this->service->handleEdit(id: $id);
        return view('modules.administration.permission.edit', get_defined_vars());
    }

    /**
     * @param PermissionRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PermissionRequest $request, int $id): RedirectResponse
    {
        $this->service->handleUpdate(data: $request->validated(), id: $id);
        flash(__('modules/administration/permission.permission_updated_successfully'))->success();
        return redirect()->route(route: 'permissions.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->handleDelete(id: $id);
        flash(__('modules/administration./permission.permission_deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->handleList($request);
    }
}
