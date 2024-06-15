<?php
namespace App\Services;

use App\Dtos\PrendaDTO;
use App\Contracts\Services\PrendaServiceInterface;
use App\Contracts\Repositories\PrendaRepositoryInterface;

class PrendaService implements PrendaServiceInterface
{
    protected $repository;

    public function __construct(PrendaRepositoryInterface $repository)
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

    public function store(PrendaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, PrendaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}