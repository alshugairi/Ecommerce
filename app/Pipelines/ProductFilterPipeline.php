<?php

namespace App\Pipelines;

use App\Packages\Emerald\Pipelines\PipelineInterface;
use Illuminate\Http\Request;

readonly class ProductFilterPipeline implements PipelineInterface
{
    /**
     * @param Request $request
     */
    public function __construct(private Request $request)
    {
    }

    public function handle($query, \Closure $next): mixed
    {
        $theQuery = $next($query);
        if($this->request->filled('name')){
            $theQuery->where('name', 'LIKE', '%'.$this->request->name.'%');
        }
        if($this->request->filled('price')){
            $theQuery->where('price', $this->request->price);
        }
        if($this->request->filled('from')){
            $theQuery->whereDate('created_at', '>=',$this->request->from);
        }
        if($this->request->filled('to')){
            $theQuery->whereDate('created_at', '<=',$this->request->to);
        }
        return $theQuery;
    }
}

