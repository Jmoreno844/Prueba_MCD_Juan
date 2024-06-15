<?php
namespace App\Services;

use App\Dtos\ProveedorDTO;
use App\Contracts\Services\ProveedorServiceInterface;
use App\Contracts\Repositories\ProveedorRepositoryInterface;

class ProveedorService implements ProveedorServiceInterface
{
    protected $repository;

    public function __construct(ProveedorRepositoryInterface $repository)
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

    public function store(ProveedorDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, ProveedorDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
