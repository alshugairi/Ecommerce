<?php

namespace App\Packages\Emerald\RestfulAPI;

use App\Packages\Emerald\HttpFoundation\Response;

interface ResourceControllerContract
{
    /**
     * @return Response
     */
    public function index(): Response;

    /**
     * @return Response
     */
    public function store(): Response;

    /**
     * @param int $id
     * @return Response
     */
    public function update(int $id): Response;

    /**
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response;

    /**
     * @param int $id
     * @return Response
     */
    public function status(int $id): Response;
}
