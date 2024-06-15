<?php
namespace App\Services;

use App\Dtos\DepartamentoDTO;
use App\Contracts\Services\DepartamentoServiceInterface;
use App\Contracts\Repositories\DepartamentoRepositoryInterface;

class DepartamentoService implements DepartamentoServiceInterface
{
    protected $repository;

    public function __construct(DepartamentoRepositoryInterface $repository)
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

    public function store(DepartamentoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, DepartamentoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}