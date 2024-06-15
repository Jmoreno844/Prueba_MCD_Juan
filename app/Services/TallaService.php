<?php
namespace App\Services;

use App\Dtos\TallaDTO;
use App\Contracts\Services\TallaServiceInterface;
use App\Contracts\Repositories\TallaRepositoryInterface;

class TallaService implements TallaServiceInterface
{
    protected $repository;

    public function __construct(TallaRepositoryInterface $repository)
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

    public function store(TallaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, TallaDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}