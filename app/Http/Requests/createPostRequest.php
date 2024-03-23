<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class createPostRequest extends FormRequest
{
    /**-
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
           'slug'=>['required','min:8', 'regex:/^[a-z0-9A-Z\ -]+$/', Rule::unique('posts')->ignore($this->route()->parameter('post'))],
           'title'=>['required','min:8'],
           'content'=>['required','min:8'],
           'category_id'=>['required','exists:categories,id'],
           'tags'=>['required', 'exists:tags,id', 'array'],
           'image'=>['image','max:2000']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug'=> $this->input('slug') ?: \Str::slug($this->input('title')),
        ]);
    }
}
