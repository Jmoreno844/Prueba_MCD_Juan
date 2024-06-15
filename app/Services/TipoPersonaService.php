<?php
namespace App\Services;

use App\Dtos\TipoPersonaDTO;
use App\Contracts\Services\TipoPersonaServiceInterface;
use App\Contracts\Repositories\TipoPersonaRepositoryInterface;

class TipoPersonaService implements TipoPersonaServiceInterface
{
    protected $repository;

    public function __construct(TipoPersonaRepositoryInterface $repository)
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

    public function store(TipoPersonaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, TipoPersonaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}