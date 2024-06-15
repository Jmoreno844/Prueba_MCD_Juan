<?php
namespace App\Services;

use App\Dtos\MunicipioDTO;
use App\Contracts\Services\MunicipioServiceInterface;
use App\Contracts\Repositories\MunicipioRepositoryInterface;

class MunicipioService implements MunicipioServiceInterface
{
    protected $repository;

    public function __construct(MunicipioRepositoryInterface $repository)
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

    public function store(MunicipioDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, MunicipioDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}