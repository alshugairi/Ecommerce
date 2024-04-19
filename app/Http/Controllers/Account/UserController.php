<?php

namespace App\Http\Controllers\Account;

use App\{Http\Controllers\Controller,
    Http\Requests\Account\UserRequest,
    Models\User,
    Services\Account\UserService,
    Services\Administration\RoleService};
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.account.user.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $roles = app(RoleService::class)->getAll();
        return view('modules.account.user.create', get_defined_vars());
    }

    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $this->userService->handleCreate(data:$request->validated());
        flash(__('modules/account/user.user_created_successfully'))->success();
        return redirect()->route(route: 'users.index');
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $roles = app(RoleService::class)->getAll();
        $currentRole = auth()->user()->getRoleNames()->first();
        return view('modules.account.user.edit', get_defined_vars());
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->userService->handleUpdate(data: $request->validated(), id: $user->id);
        flash(__('modules/account/user.user_updated_successfully'))->success();
        return redirect()->route(route: 'users.index');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->userService->handleDelete(id: $user->id);
        flash(__('modules/account/user.user_deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->userService->handleList($request);
    }
}
