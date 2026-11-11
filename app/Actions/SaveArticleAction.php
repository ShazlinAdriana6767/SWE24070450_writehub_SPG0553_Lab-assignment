<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
 */

namespace App\Actions;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class SaveArticleAction
{
    /**
     * Create a new article (when $article is null) or update an existing one.
     *
     * @param array<string, mixed> $data validated data from SaveArticleRequest
     */
    public function handle(User $user, array $data, ?Article $article = null): Article
    {
        $data['title'] = trim($data['title']);

        // Only an administrator may move an article to "published".
        $becomingPublished = $data['status'] === 'published'
            && $article?->status !== 'published';

        if ($becomingPublished) {
            Gate::forUser($user)->authorize('publish-article');
        }

        if ($article) {
            $article->update($data);

            return $article;
        }

        return $user->articles()->create($data);
    }
}