<?php
namespace App\Repositories;

use App\Contracts\Repositories\PaisRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaisRepository implements PaisRepositoryInterface
{
    protected $table = 'pais';

    public function index($perPage)
    {
        return DB::table($this->table)->paginate($perPage);
    }

    public function show($id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function store(array $data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function update($id, array $data)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
