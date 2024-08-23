<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'user_creator' => new UserResource($this->user),
            'amount' => number_format($this->amount, 2, ',', '.') . ' €',
            'amount_letter' => $this->amount_letter,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'release_date_formatted' => date('d/m/Y', strtotime($this->release_date)),
            'payment_deadline' => $this->payment_deadline,
            'payment_deadline_formatted' => date('d/m/Y', strtotime($this->payment_deadline)),
            'status' => $this->status,
            'customer_invoice_number' => $this->customer_invoice_number,
            'annual_invoice_number' => $this->annual_invoice_number,
            'total_invoice_number' => $this->total_invoice_number,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'created_at_formatted' => date('d/m/Y H:i', strtotime($this->created_at)),

        ];
    }
}
