<?php

namespace App\Http\Controllers;

use App\{Http\Requests\ProductRequest,
    Models\Category,
    Models\Product,
    Pipelines\ProductFilterPipeline,
    Services\ProductService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Http\Request};

class ProductController extends Controller
{
    /**
     * @param ProductService $service
     */
    public function __construct(private readonly ProductService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.product.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::getAll();
        return view('modules.product.create', get_defined_vars());
    }

    /**
     * @param ProductRequest $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $this->service->handleCreate(data: $request->validated());
        flash(__('modules/product.product_created_successfully'))->success();
        return redirect()->route(route: 'products.index');
    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = Category::getAll();
        return view('modules.product.edit', get_defined_vars());
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->service->handleUpdate(data: $request->validated(), id: $product->id);
        flash(__('modules/product.product_updated_successfully'))->success();
        return redirect()->route(route: 'products.index');
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->service->handleDelete(id: $product->id);
        flash(__('modules/product.product_deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->handleList($request, [
            new ProductFilterPipeline(request: $request)
        ]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function print(Request $request): View
    {
        $products = $this->service->getAll([ new ProductFilterPipeline(request: $request)]);
        return view('modules.product.print', get_defined_vars());
    }
}
