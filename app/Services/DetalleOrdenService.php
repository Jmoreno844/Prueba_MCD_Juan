<?php
namespace App\Services;

use App\Dtos\DetalleOrdenDTO;
use App\Contracts\Services\DetalleOrdenServiceInterface;
use App\Contracts\Repositories\DetalleOrdenRepositoryInterface;

class DetalleOrdenService implements DetalleOrdenServiceInterface
{
    protected $repository;

    public function __construct(DetalleOrdenRepositoryInterface $repository)
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

    public function store(DetalleOrdenDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, DetalleOrdenDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}