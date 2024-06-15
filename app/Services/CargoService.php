<?php
namespace App\Services;

use App\Dtos\CargoDTO;
use App\Contracts\Services\CargoServiceInterface;
use App\Contracts\Repositories\CargoRepositoryInterface;

class CargoService implements CargoServiceInterface
{
    protected $cargoRepository;

    public function __construct(CargoRepositoryInterface $cargoRepository)
    {
        $this->cargoRepository = $cargoRepository;
    }

    public function index($perPage)
    {
        return $this->cargoRepository->index($perPage);
    }

    public function show($id)
    {
        return $this->cargoRepository->show($id);
    }

    public function store(CargoDTO $cargoDTO)
    {
        $data = $cargoDTO->toArray();
        return $this->cargoRepository->store($data);
    }

    public function update($id, CargoDTO $cargoDTO)
    {
        $data = $cargoDTO->toArray();
        return $this->cargoRepository->store($data);
    }

    public function destroy($id)
    {
        return $this->cargoRepository->destroy($id);
    }
}