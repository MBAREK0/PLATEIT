<?php

namespace App\Http\Requests;

use App\Customs\Services\JwtTokenService;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    private $jwtService;
    public function __construct(){
        $this->jwtService = new JwtTokenService;
    }
    public function authorize(): bool
    {
        $token = $this->header('Authorization');

        $role =  $this->jwtService->get_role($token);
        if($role == 'restaurant'){
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address'=> ['string'],
            'phone_numbre'=> ['string'],
            'web_site'=> ['string'],

        ];
    }
}
