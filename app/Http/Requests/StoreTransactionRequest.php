<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'clerk']);
    }

    public function rules(): array
    {
        return [
            'cycle_id'     => 'required|exists:payout_cycles,id',
            'senior_id'    => 'required|exists:seniors,id',
            'schedule_id'  => 'nullable|exists:payout_schedules,id',
            'counter_id'   => 'nullable|exists:counters,id',
            'amount'       => 'required|numeric|min:0|max:99999.99',
            'claim_status' => 'required|in:claimed,unclaimed,cancelled',
            'remarks'      => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'cycle_id.required'     => 'Please select a payout cycle.',
            'senior_id.required'    => 'Please select a senior citizen.',
            'amount.required'       => 'Please enter the payout amount.',
            'amount.min'            => 'Amount cannot be negative.',
            'amount.max'            => 'Amount cannot exceed ₱99,999.99.',
            'claim_status.required' => 'Please select a claim status.',
        ];
    }
}