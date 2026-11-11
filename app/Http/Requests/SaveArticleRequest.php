<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
 */

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        $articleId = $this->articleId();

        return $articleId
            ? $user->can('update', Article::findOrFail($articleId))
            : $user->can('create', Article::class);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required', 'string', 'min:5', 'max:100',
                Rule::unique('articles', 'title')->ignore($this->articleId()),
            ],
            'category' => ['required', Rule::in(Article::CATEGORIES)],
            'reading_time' => ['required', 'integer', 'between:1,60'],
            'body' => ['required', 'string', 'min:20'],
            'status' => ['required', Rule::in(Article::STATUSES)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'An article with this title already exists.',
            'category.in' => 'Please choose a valid category.',
            'reading_time.between' => 'Reading time must be between :min and :max minutes.',
            'body.min' => 'The article body must contain at least :min characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'reading_time' => 'reading time (minutes)',
        ];
    }

    /**
     * Which article is being saved? null means "a new article".
     */
    protected function articleId(): ?int
    {
        // When used from a controller route such as /articles/{article}
        $routeArticle = $this->route('article');

        if ($routeArticle instanceof Article) {
            return $routeArticle->id;
        }

        // When used from Livewire: the component merges the id in
        return $this->integer('article_id') ?: null;
    }
}