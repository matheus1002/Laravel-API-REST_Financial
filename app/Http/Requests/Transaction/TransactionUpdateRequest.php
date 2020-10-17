<?php

namespace App\Http\Requests\Transaction;

class TransactionUpdateRequest extends TransactionCreateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['id'] = ['required','integer'];
        return $rules;
    }
}
