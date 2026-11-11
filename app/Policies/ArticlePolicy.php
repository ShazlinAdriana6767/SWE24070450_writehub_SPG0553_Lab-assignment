<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
*/
namespace App\Policies;
use App\Models\Article; use App\Models\User;

class ArticlePolicy
{
public function viewAny(User $user): bool
{
return true;
}

public function view(User $user, Article $article): bool
{
return true;
}

public function create(User $user): bool
{
return true;
}

/** Only the author may edit an article — not even an administrator. */ public function update(User $user, Article $article): bool
{
return $user->id === $article->user_id;
}

/** The author or any administrator may delete an article. */ public function delete(User $user, Article $article): bool
{
return $user->id === $article->user_id || $user->isAdmin();
}

public function restore(User $user, Article $article): bool
{
return false;
}

public function forceDelete(User $user, Article $article): bool
{
return false;
}
}
