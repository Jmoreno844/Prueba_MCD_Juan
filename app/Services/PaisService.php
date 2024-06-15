<?php
namespace App\Services;

use App\Dtos\PaisDTO;
use App\Contracts\Services\PaisServiceInterface;
use App\Contracts\Repositories\PaisRepositoryInterface;

class PaisService implements PaisServiceInterface
{
    protected $repository;

    public function __construct(PaisRepositoryInterface $repository)
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

    public function store(PaisDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, PaisDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}