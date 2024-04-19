<?php

namespace App\Http\Controllers;

use App\{Http\Requests\CategoryRequest,
    Models\Category,
    Services\CategoryService,
    Services\Administration\LanguageService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Http\Request};

class CategoryController extends Controller
{
    /**
     * @param CategoryService $categoryService
     */
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.category.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $languages = app(LanguageService::class)->getAll();
        return view('modules.category.create', get_defined_vars());
    }

    /**
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        $this->categoryService->handleCreate(data: $request->validated());
        flash(__('modules/category.category_created_successfully'))->success();
        return redirect()->route(route: 'categories.index');
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $languages = app(LanguageService::class)->getAll();
        return view('modules.category.edit', get_defined_vars());
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->handleUpdate(data: $request->validated(), id: $category->id);
        flash(__('modules/category.category_updated_successfully'))->success();
        return redirect()->route(route: 'categories.index');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->handleDelete(id: $category->id);
        flash(__('modules/category.category_deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->categoryService->handleList($request);
    }
}
