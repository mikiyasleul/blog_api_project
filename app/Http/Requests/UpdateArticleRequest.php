<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string', 'max:255'],
            'image_url.*' => ['nullable', 'mimes:jpeg,png,jpg,gif'],
            'category_id' => ['required', 'string', function ($attribute, $value, $fail) {
                if (Category::whereNotIn('id', $value)) {
                    $fail('This Category is Wrong!');
                }
            }],
            'tag_id' => ['required', 'array'],
            'tag_id.*' => ['required', 'integer', function ($attribute, $value, $fail) {
                if (Tag::whereNotIn('id', $value)) {
                    $fail('This Tag is Wrong!');
                }
            }],
        ];
    }
}
