<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createOrganizationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'org' => 'required|string|max:255',  // Ensure 'org' field is required
            'profile_pic' => 'required|image|max:2048',
            'street' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10', // Adjust if needed
        ];
    }

    /**
     * Get the custom error messages for the validator.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Full Name is required.',
            'name.string' => 'Full Name must be a valid string.',
            'name.max' => 'Full Name may not be greater than 255 characters.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email may not be greater than 255 characters.',

            'org.required' => 'Company Name is required.', // Added custom message for 'org'
            'org.string' => 'Company Name must be a valid string.',
            'org.max' => 'Company Name may not be greater than 255 characters.',

            'profile_pic.required' => 'Company Logo is required.', // Ensure it's added for required validation
            'profile_pic.image' => 'Company Logo must be an image file.',
            'profile_pic.max' => 'Company Logo may not be larger than 2MB.',

            'street.required' => 'Street address is required.',
            'street.string' => 'Street address must be a valid string.',
            'street.max' => 'Street address may not be greater than 255 characters.',

            'district.required' => 'District is required.',
            'district.string' => 'District must be a valid string.',
            'district.max' => 'District may not be greater than 255 characters.',

            'city.required' => 'City is required.',
            'city.string' => 'City must be a valid string.',
            'city.max' => 'City may not be greater than 255 characters.',

            'postal_code.required' => 'Postal code is required.',
            'postal_code.string' => 'Postal code must be a valid string.',
            'postal_code.max' => 'Postal code may not be greater than 10 characters.',
        ];
    }
}
