<?php
namespace App\Services;

use App\Dtos\ColorDTO;
use App\Contracts\Services\ColorServiceInterface;
use App\Contracts\Repositories\ColorRepositoryInterface;

class ColorService implements ColorServiceInterface
{
    protected $repository;

    public function __construct(ColorRepositoryInterface $repository)
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

    public function store(ColorDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, ColorDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}