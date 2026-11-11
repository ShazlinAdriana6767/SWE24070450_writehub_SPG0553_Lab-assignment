<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
 */

use App\Models\Article;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Articles')] class extends Component {
    public ?string $notice = null;

    public function mount(): void
    {
        $this->notice = session('status');
    }

    #[Computed]
    public function articles()
    {
        return Article::with('user')->orderBy('id')->get();
    }

    public function destroy(int $id): void
    {
        $article = Article::findOrFail($id);

        Gate::authorize('delete', $article);

        $article->delete();

        $this->notice = 'Article deleted.';
    }
};
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Articles</flux:heading>

        @can('create', App\Models\Article::class)
            <flux:button variant="primary" :href="route('articles.create')" wire:navigate>
                New article
            </flux:button>
        @endcan
    </div>

    @if ($notice)
        <div class="rounded-lg bg-green-100 p-3 text-sm text-green-800 dark:bg-green-900 dark:text-green-100">
            {{ $notice }}
        </div>
    @endif

    <p class="text-sm text-zinc-500">Total articles: {{ $this->articles->count() }}</p>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-zinc-200 dark:border-zinc-700">
                    <th class="p-2">#</th>
                    <th class="p-2">Title</th>
                    <th class="p-2">Author</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Minutes</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->articles as $article)
                    <tr class="border-b border-zinc-200 dark:border-zinc-700" wire:key="article-{{ $article->id }}">
                        <td class="p-2">{{ $article->id }}</td>
                        <td class="p-2">{{ $article->title }}</td>
                        <td class="p-2">{{ $article->user->name }}</td>
                        <td class="p-2">{{ ucfirst($article->category) }}</td>
                        <td class="p-2">{{ $article->reading_time }}</td>
                        <td class="p-2">
                            <flux:badge :color="$article->status === 'published' ? 'green' : 'zinc'">
                                {{ ucfirst($article->status) }}
                            </flux:badge>
                        </td>
                        <td class="p-2">
                            <div class="flex gap-2">
                                @can('update', $article)
                                    <flux:button size="sm" :href="route('articles.edit', $article)" wire:navigate>
                                        Edit
                                    </flux:button>
                                @endcan

                                @can('delete', $article)
                                    <flux:button size="sm" variant="danger"
                                        wire:click="destroy({{ $article->id }})"
                                        wire:confirm="Delete this article?">
                                        Delete
                                    </flux:button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center">No articles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>