<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'company' => $this->company,
            'location' => $this->location,
            'salary' => $this->salary,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'totalAppliedUsers' => $this->whenLoaded('appliedUser', function() {
                return $this->appliedUser->count();
            }, 0),
            'appliedUserDetails' => $this->whenLoaded('appliedUser', function() {
                return $this->appliedUser->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'appliedStatus' => $user->pivot->status ?? null,
                    ];
                });
            }),
        ];
    }
}
