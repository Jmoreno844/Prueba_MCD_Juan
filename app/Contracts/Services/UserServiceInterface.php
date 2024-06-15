<?php
namespace App\Contracts\Services;
use App\Dtos\UserDTO;
interface UserServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(UserDTO $userDTO);
    public function update($id, UserDTO $userDTO);
    public function destroy($id);
}