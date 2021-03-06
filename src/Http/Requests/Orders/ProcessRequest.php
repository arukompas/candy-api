<?php

namespace GetCandy\Api\Http\Requests\Orders;

use GetCandy\Api\Http\Requests\FormRequest;

class ProcessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return $this->user()->can('create', Category::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => 'required',
            'payment_token' => 'valid_payment_token|required_without:payment_type_id',
            'payment_type_id' => 'required_without:payment_token|hashid_is_valid:payment_types',
        ];
    }
}
