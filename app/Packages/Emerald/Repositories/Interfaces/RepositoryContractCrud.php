<?php

namespace App\Packages\Emerald\Repositories\Interfaces;

interface RepositoryContractCrud
{
    /**
     * @param array $columns
     * @param bool $isPagination
     * @param int $perPage
     * @return mixed
     */
    public function index(array $columns, bool $isPagination, int $perPage): mixed;

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed;

    /**
     * @param int $modelId
     * @return mixed
     */
    public function show(int $modelId): mixed;

    /**
     * @param int $modelId
     * @return mixed
     */
    public function edit(int $modelId): mixed;

    /**
     * @param array $data
     * @param $modelId
     * @return mixed
     */
    public function update(array $data, $modelId): mixed;

    /**
     * @param int $modelId
     * @return void
     */
    public function destroy(int $modelId): void;

    /**
     * @param int $modelId
     * @return mixed
     */
    public function status(int $modelId): mixed;
}
