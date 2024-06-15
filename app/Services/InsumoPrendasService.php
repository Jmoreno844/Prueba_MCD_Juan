<?php
namespace App\Services;

use App\Dtos\InsumoPrendasDTO;
use App\Contracts\Services\InsumoPrendasServiceInterface;
use App\Contracts\Repositories\InsumoPrendasRepositoryInterface;

class InsumoPrendasService implements InsumoPrendasServiceInterface
{
    protected $repository;

    public function __construct(InsumoPrendasRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($perPage)
    {
        return $this->repository->index($perPage);
    }

    public function show($id1, $id2)
    {
        return $this->repository->show($id1, $id2);
    }

    public function store($id1, $id2, $cantidad)
    {

        return $this->repository->store($id1,$id2,$cantidad);
    }

    public function update($id1, $id2, $cantidad)
    {
        return $this->repository->update($id1, $id2, $cantidad);
    }


    public function destroy($id1, $id2)
    {
        return $this->repository->destroy($id1,$id2);
    }
}
