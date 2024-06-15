<?php
namespace App\Services;

use App\Dtos\DetalleVentaDTO;
use App\Contracts\Services\DetalleVentaServiceInterface;
use App\Contracts\Repositories\DetalleVentaRepositoryInterface;

class DetalleVentaService implements DetalleVentaServiceInterface
{
    protected $repository;

    public function __construct(DetalleVentaRepositoryInterface $repository)
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

    public function store(DetalleVentaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, DetalleVentaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}