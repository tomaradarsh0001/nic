<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PublicGrievance;
use App\Jobs\SendUserGrievanceMail;
use App\Jobs\SendAdminGrievanceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PublicGrievanceController extends Controller
{
    public function store(Request $request)
    {
        //API updated by adarsh tomar on 07 sept 2024
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'mobile_number' => [
                'required',
                'digits:10'
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'address' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\/\-,&\s]+$/'
            ],
            'description' => [
                'required',
                'string',
                'max:500'
            ],
        ];

        $messages = [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.regex' => 'The name may only contain letters and spaces.',

            'mobile_number.required' => 'The mobile number field is required.',
            'mobile_number.digits' => 'The mobile number must be exactly 10 digits.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.regex' => 'The email format is invalid.',

            'address.required' => 'The address field is required.',
            'address.string' => 'The address must be a valid string.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'address.regex' => 'The address contains invalid characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description may not be greater than 500 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $customErrors = implode(' ', $errors->all());

            return response()->json([
                'message' => 'Invalid input parameters.',
                'error' => $customErrors,
                'data' => null
            ], 422); 
        }

        try {
            $validatedData = $validator->validated();
            $validatedData['updated_by'] = Auth::id();
            $publicGrievance = PublicGrievance::create($validatedData);


            SendUserGrievanceMail::dispatch($publicGrievance);
            SendAdminGrievanceMail::dispatch($publicGrievance);

            return response()->json([
                'message' => 'Grievance submitted successfully.',
                'data' => $publicGrievance
            ], 201); 
        } catch (\Exception $e) {
            Log::error('Error submitting grievance: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error submitting grievance.',
                'error' => 'An unexpected error occurred. Please try again later.',
                'data' => null
            ], 500); 
        }
    }
}
