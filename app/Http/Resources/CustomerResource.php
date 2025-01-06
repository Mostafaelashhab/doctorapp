<?php

namespace App\Http\Resources;

use App\traits\ApiResonse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    use ApiResonse;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'partnerId' => 0,
            'userId' => $this->id,
            'loyaltyPoints' => $this->point_refaral + $this->point_shop,
            'userName' => $this->name,
            'userImage' => $this->imagePath($this->image),
            'email' => $this->email,
            'phone' => $this->phone,
            'barCode' => '',
            'userType' => '',
            'weight' => $this->weight,
            'height' => $this->height,
            'walletBalance' => $this->wallet_balance,

        ];
    }
}
