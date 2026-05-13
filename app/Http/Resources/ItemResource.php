<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'location' => $this->location,
            // 'status' => $this->status,
            'status_label' => $this->statusLabel(),
            'note' => $this->note,
            'created_date' => $this->created_at?->format('Y-m-d'),
            'updated_date' => $this->updated_at?->format('Y-m-d'),
        ];
    }

    private function statusLabel(): string
    {
        return match ($this->status) {
            'available' => '利用可能',
            'in_use' => '利用中',
            'maintenance' => 'メンテナンス中',
            default => '不明',
        };
    }
}
