<?php
namespace App\Services;

use App\Dtos\GeneroDTO;
use App\Contracts\Services\GeneroServiceInterface;
use App\Contracts\Repositories\GeneroRepositoryInterface;

class GeneroService implements GeneroServiceInterface
{
    protected $repository;

    public function __construct(GeneroRepositoryInterface $repository)
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

    public function store(GeneroDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, GeneroDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}