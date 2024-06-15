<?php
namespace App\Services;

use App\Dtos\InventarioDTO;
use App\Contracts\Services\InventarioServiceInterface;
use App\Contracts\Repositories\InventarioRepositoryInterface;

class InventarioService implements InventarioServiceInterface
{
    protected $repository;

    public function __construct(InventarioRepositoryInterface $repository)
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

    public function store(InventarioDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, InventarioDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}