<?php
namespace App\Services;

use App\Dtos\ClienteDTO;
use App\Contracts\Services\ClienteServiceInterface;
use App\Contracts\Repositories\ClienteRepositoryInterface;

class ClienteService implements ClienteServiceInterface
{
    protected $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function index($perPage)
    {
        return $this->clienteRepository->index($perPage);
    }

    public function show($id)
    {
        return $this->clienteRepository->show($id);
    }

    public function store(ClienteDTO $clienteDTO)
    {
        $data = $clienteDTO->toArray();
        return $this->clienteRepository->store($data);
    }

    public function update($id, ClienteDTO $clienteDTO)
    {
        $data = $clienteDTO->toArray();
        return $this->clienteRepository->store($data);
    }

    public function destroy($id)
    {
        return $this->clienteRepository->destroy($id);
    }
}