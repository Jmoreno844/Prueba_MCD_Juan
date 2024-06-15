<?php
namespace App\Services;

use App\Dtos\EstadoDTO;
use App\Contracts\Services\EstadoServiceInterface;
use App\Contracts\Repositories\EstadoRepositoryInterface;

class EstadoService implements EstadoServiceInterface
{
    protected $repository;

    public function __construct(EstadoRepositoryInterface $repository)
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

    public function store(EstadoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, EstadoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}