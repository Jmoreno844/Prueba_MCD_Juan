<?php
namespace App\Services;

use App\Dtos\InsumoDTO;
use App\Contracts\Services\InsumoServiceInterface;
use App\Contracts\Repositories\InsumoRepositoryInterface;

class InsumoService implements InsumoServiceInterface
{
    protected $repository;

    public function __construct(InsumoRepositoryInterface $repository)
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

    public function store(InsumoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, InsumoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}