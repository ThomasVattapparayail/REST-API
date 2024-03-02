<?php
 
namespace App\traits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiErrorResponse
 {
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'Success'=>false,
            'message'=>'Validation Error',
            'error'=>$validators->errors()

        ]));
        
    }

 }