<?php

namespace App\Http\Requests;

use App\Services\SkillService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FeedbackSkillRequest extends FormRequest
{
    /**
     * @var SkillService
     */
    private $skillService;

    public function __construct(SkillService $skillService, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->skillService = $skillService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {

            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'data.feedback_1' => 'required',
            'data.feedback_2' => 'required',
            'ratings.*' => 'required'
        ];

//         foreach($this->skillService->all() as $skill)
//         {
//             $rules['ratings.rating_' . $skill->id] = 'required';
//         }
         return $rules;
    }
}
