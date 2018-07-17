<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            //
            'id'=>'exists:inventories',
            'name'=>'required|alpha',
            'vendor'=>'required|alpha',
            'price'=>'required|regex:/^\d*(\.\d{1,2})?$/',
            'batch_number'=>'required|alpha_num',
            'batch_date'=>'required|date',
            'stock_in_hand'=>'required|numeric'
        ];
    }
}
