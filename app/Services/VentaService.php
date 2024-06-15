<?php
namespace App\Services;

use App\Dtos\VentaDTO;
use App\Contracts\Services\VentaServiceInterface;
use App\Contracts\Repositories\VentaRepositoryInterface;

class VentaService implements VentaServiceInterface
{
    protected $repository;

    public function __construct(VentaRepositoryInterface $repository)
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

    public function store(VentaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, VentaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}