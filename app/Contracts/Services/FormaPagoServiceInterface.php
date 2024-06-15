<?php
namespace App\Contracts\Services;
use App\Dtos\FormaPagoDTO;
interface FormaPagoServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(FormaPagoDTO $formaPagoDTO);
    public function update($id, FormaPagoDTO $formaPagoDTO);
    public function destroy($id);
}