<?php
namespace App\Services;

use App\Dtos\EmpresaDTO;
use App\Contracts\Services\EmpresaServiceInterface;
use App\Contracts\Repositories\EmpresaRepositoryInterface;

class EmpresaService implements EmpresaServiceInterface
{
    protected $repository;

    public function __construct(EmpresaRepositoryInterface $repository)
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

    public function store(EmpresaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, EmpresaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}