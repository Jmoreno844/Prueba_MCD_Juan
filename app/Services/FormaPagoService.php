<?php
namespace App\Services;

use App\Dtos\FormaPagoDTO;
use App\Contracts\Services\FormaPagoServiceInterface;
use App\Contracts\Repositories\FormaPagoRepositoryInterface;

class FormaPagoService implements FormaPagoServiceInterface
{
    protected $repository;

    public function __construct(FormaPagoRepositoryInterface $repository)
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

    public function store(FormaPagoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function update($id, FormaPagoDTO $dto)
    {
        $data = $dto->toArray();
        return $this->repository->store($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}