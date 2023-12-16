<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditAboutUsRequest extends FormRequest
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
             'category' => 'required',
             'slug' => 'required',
             'title' => 'required',
             'page_content' => 'required',
             'sub_contents'=> 'required'
        ];
    }
}
