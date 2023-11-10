<?php

namespace App\Http\Resources\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name'=>$this->full_name,
            'salary'=>$this->salary,
            'image'=>$this->image,
            'manger_name'=>$this->manger_name,
            'department'=>$this->department->department_name,
        ];
    }
}
