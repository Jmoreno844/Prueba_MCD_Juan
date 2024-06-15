<?php
namespace App\Services;

use App\Dtos\TipoProteccionDTO;
use App\Contracts\Services\TipoProteccionServiceInterface;
use App\Contracts\Repositories\TipoProteccionRepositoryInterface;

class TipoProteccionService implements TipoProteccionServiceInterface
{
    protected $repository;

    public function __construct(TipoProteccionRepositoryInterface $repository)
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

    public function store(TipoProteccionDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, TipoProteccionDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->update($id,$data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
