<?php

namespace App\Http\Controllers\Administration;

use App\{Http\Controllers\Controller,
    Http\Requests\Administration\LanguageRequest,
    Services\Administration\LanguageService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Http\Request};

class LanguageController extends Controller
{
    /**
     * @param LanguageService $service
     */
    public function __construct(private readonly LanguageService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.administration.language.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('modules.administration.language.create', get_defined_vars());
    }

    /**
     * @param LanguageRequest $request
     * @return RedirectResponse
     */
    public function store(LanguageRequest $request): RedirectResponse
    {
        $this->service->handleCreate(data: $request->validated());
        flash(__('modules/administration/language.language_created_successfully'))->success();
        return redirect()->route(route: 'languages.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $data = $this->service->handleEdit(id: $id);
        return view('modules.administration.language.edit', get_defined_vars());
    }

    /**
     * @param LanguageRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(LanguageRequest $request, int $id): RedirectResponse
    {
        $this->service->handleUpdate(data: $request->validated(), id: $id);
        flash(__('modules/administration/language.language_updated_successfully'))->success();
        return redirect()->route(route: 'languages.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->service->handleDelete(id: $id);
        flash(__('modules/administration/language.language_deleted_successfully'))->success();
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
