<?php

namespace App\Http\Controllers;

use App\{Http\Requests\Profile\ChangePasswordRequest,
    Http\Requests\Profile\ProfileRequest,
    Services\Account\UserService};
use Illuminate\{Contracts\View\View, Http\RedirectResponse};

class ProfileController extends Controller
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
    public function overview(): View
    {
        $data = auth()->user();
        return view('modules.profile.overview', get_defined_vars());
    }

    /**
     * @param ProfileRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileRequest $request): RedirectResponse
    {
        $this->userService->handleUpdate(data: $request->validated(), id: auth()->id());
        flash(__('modules/account/user.user_updated_successfully'))->success();
        return back();
    }

    /**
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $this->userService->handleUpdate(data: $request->validated(), id: auth()->id());
        flash(__('modules/account/user.password_changed_successfully'))->success();
        return back();
    }
}
