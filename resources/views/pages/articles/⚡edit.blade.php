<?php
/**
 * Student Name : Noor Shazlin Adriana Binti Ahmad Kamal
 * Student ID   : SWE24070450
 */

use App\Actions\SaveArticleAction;
use App\Http\Requests\SaveArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Edit article')] class extends Component {
    public Article $article;

    public string $title = '';
    public string $category = '';
    public string $reading_time = '';
    public string $body = '';
    public string $status = 'draft';

    public function mount(Article $article): void
    {
        Gate::authorize('update', $article);

        $this->article = $article;
        $this->title = $article->title;
        $this->category = $article->category;
        $this->reading_time = (string) $article->reading_time;
        $this->body = $article->body;
        $this->status = $article->status;
    }

    public function save(SaveArticleAction $action): void
    {
        $request = new SaveArticleRequest();
        $request->merge(['article_id' => $this->article->id]);
        $request->setUserResolver(fn () => auth()->user());

        abort_unless($request->authorize(), 403);

        $data = $this->validate(
            $request->rules(),
            $request->messages(),
            $request->attributes(),
        );

        $action->handle(auth()->user(), $data, $this->article);

        session()->flash('status', 'Article updated successfully.');

        $this->redirectRoute('articles.index', navigate: true);
    }
};
?>

<div class="mx-auto w-full max-w-2xl space-y-6">
    <flux:heading size="xl">Edit article</flux:heading>

    <form wire:submit="save" novalidate class="space-y-6">
        <flux:input wire:model="title" label="Title" type="text" />

        <flux:select wire:model="category" label="Category">
            <flux:select.option value="">— Choose a category —</flux:select.option>
            <flux:select.option value="news">News</flux:select.option>
            <flux:select.option value="tutorial">Tutorial</flux:select.option>
            <flux:select.option value="opinion">Opinion</flux:select.option>
        </flux:select>

        <flux:input wire:model="reading_time" label="Reading time (minutes)" type="text" />
        <flux:textarea wire:model="body" label="Body" rows="6" />

        @can('publish-article')
            <flux:select wire:model="status" label="Status">
                <flux:select.option value="draft">Draft</flux:select.option>
                <flux:select.option value="published">Published</flux:select.option>
            </flux:select>
        @endcan

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">Update article</flux:button>
            <flux:button :href="route('articles.index')" wire:navigate>Cancel</flux:button>
        </div>
    </form>
</div>