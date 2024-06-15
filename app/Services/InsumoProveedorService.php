<?php
namespace App\Services;

use App\Dtos\InsumoProveedorDTO;
use App\Contracts\Services\InsumoProveedorServiceInterface;
use App\Contracts\Repositories\InsumoProveedorRepositoryInterface;

class InsumoProveedorService implements InsumoProveedorServiceInterface
{
    protected $repository;

    public function __construct(InsumoProveedorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($perPage)
    {
        return $this->repository->index($perPage);
    }

    public function show($id1,$id2)
    {
        return $this->repository->show($id1,$id2);
    }

    public function store($id1,$id2)
    {

        return $this->repository->store($id1,$id2);
    }

    public function destroy($id1,$id2)
    {
        return $this->repository->destroy($id1,$id2);
    }
}
