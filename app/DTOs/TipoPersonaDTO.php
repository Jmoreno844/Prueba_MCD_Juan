<?php
namespace App\DTOs;

use Illuminate\Http\Request;

class TipoPersonaDTO
{
    private $fields;

    public function __construct(Request $request , array $fields)
    {
        $this->fields = $fields;
        foreach ($fields as $field) {
            $this->{$field} = $request->input($field);
        }
    }

    public function toArray()
    {
        $array = [];
        foreach ($this->fields as $field) {
            $array[$field] = $this->{$field};
        }
        return $array;
    }
}