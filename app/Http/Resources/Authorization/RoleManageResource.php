<?php

namespace App\Http\Resources\Authorization;

use App\Http\Resources\CreatedOrUpdatedByResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleManageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'createdBy' => $this->whenLoaded('createdBy', fn() => new CreatedOrUpdatedByResource($this->createdBy)),
            'name' => $this->name,
            'permissions' =>  $this->when($this->permission_id, $this->permission_id),
            'is_active' => $this->when($this->is_active, $this->is_active),
            'permissions_count' => $this->when(
                $this->permissions_count,
                $this->permissions_count
            ),
            'created_at' => $this->when($this->created_at, $this->created_at),
        ];
    }
}
