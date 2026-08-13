<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePasswordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'current_password' verifică automat dacă parola introdusă se potrivește cu cea din DB a utilizatorului logat
            'old_password' => ['required', 'current_password'], 
            
            // 'confirmed' cere automat existența câmpului 'new_password_confirmation' și verifică dacă valorile coincid
            // 'different:old_password' se asigură că utilizatorul nu pune aceeași parolă veche
            'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:old_password']
        ];
    }
}
