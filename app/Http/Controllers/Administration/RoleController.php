<?php

namespace App\Http\Controllers\Administration;

use App\{Http\Controllers\Controller,
    Http\Requests\Administration\RoleRequest,
    Packages\Emerald\Livewire\Filters\SearchFilterPipeline,
    Packages\Emerald\Livewire\Filters\SortFilterPipeline,
    Services\Administration\PermissionService,
    Services\Administration\RoleService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Http\Request};
use Exception;

class RoleController extends Controller
{
    /**
     * @param RoleService $service
     * @param PermissionService $permissionService
     */
    public function __construct(private readonly RoleService $service,
                                private readonly PermissionService $permissionService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.administration.role.index');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $groupedPermissions = $this->permissionService->groupedPermissions();
        return view('modules.administration.role.create', get_defined_vars());
    }

    /**
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $this->service->handleCreate(data: $request->validated());
        flash(__('modules/administration/role.role_created_successfully'))->success();
        return redirect()->route(route: 'roles.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $data = $this->service->handleEdit(id: $id);
        $groupedPermissions = $this->permissionService->groupedPermissions();
        $rolePermissions = $this->service->getRolePermissionIds($data);
        return view('modules.administration.role.edit', get_defined_vars());
    }

    /**
     * @param RoleRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, int $id): RedirectResponse
    {
        $this->service->handleUpdate(data: $request->validated(), id: $id);
        flash(__('modules/administration/role.role_updated_successfully'))->success();
        return redirect()->route(route: 'roles.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->handleDelete(id: $id);
        flash(__('modules/administration/role.role_deleted_successfully'))->success();
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
