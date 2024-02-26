<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'companyId' => 'required|integer|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'required|numeric |unique:products,code,',
            'purchasePrice' => 'required|numeric|min:0',
            'salePrice' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
        ];
    }
    //use Validator in req.php to show errors messages
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors(),
        ], 422));
    }
}
