<?php
namespace App\Services;

use App\Dtos\OrdenDTO;
use App\Contracts\Services\OrdenServiceInterface;
use App\Contracts\Repositories\OrdenRepositoryInterface;

class OrdenService implements OrdenServiceInterface
{
    protected $repository;

    public function __construct(OrdenRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($perPage)
    {
        return $this->repository->index($perPage);
    }

    public function show($id)
    {
        return $this->repository->show($id);
    }

    public function store(OrdenDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, OrdenDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}