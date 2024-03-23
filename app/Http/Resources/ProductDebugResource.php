<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductDebugResource extends JsonResource
{

    // public $additional = [
    //     "author" => "Programmer Bau Bawang"
    // ];

    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "author" => "Programmer Bawang Putih",
            "server_time" => now()->toDateTimeString(),
            "data" => [
                "id" => $this->id,
                "name" => $this->name,
                "price" => $this->price,
            ]
        ];
    }
}
