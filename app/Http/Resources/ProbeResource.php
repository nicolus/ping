<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Probe
 */
class ProbeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'name' => $this->name,
            'edit_link' => route('probes.edit', $this),
            'latest_check' => $this->whenLoaded('latestCheck', function () {
                return [
                    'online' => $this->latestCheck->online,
                    'status' => $this->latestCheck->status,
                    'created_at' => $this->latestCheck->created_at,
                    'time' => $this->latestCheck->time,
                ];
            }),
        ];
    }
}
