<?php
namespace App\Services;

use App\Dtos\EmpleadoDTO;
use App\Contracts\Services\EmpleadoServiceInterface;
use App\Contracts\Repositories\EmpleadoRepositoryInterface;

class EmpleadoService implements EmpleadoServiceInterface
{
    protected $repository;

    public function __construct(EmpleadoRepositoryInterface $repository)
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

    public function store(EmpleadoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, EmpleadoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}