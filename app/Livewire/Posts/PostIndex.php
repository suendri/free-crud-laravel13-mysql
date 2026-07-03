<?php

namespace App\Livewire\Posts;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination;

    public ?int $categoryId = null;

    public string $title = '';

    public string $text = '';

    public string $search = '';

    public ?int $editingPostId = null;

    public function save(): void
    {
        $validated = $this->validate([
            'categoryId' => ['required', 'integer', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'text' => ['nullable', 'string'],
        ]);

        $attributes = [
            'category_id' => $validated['categoryId'],
            'title' => $validated['title'],
            'text' => $validated['text'] ?: null,
        ];

        if ($this->editingPostId) {
            Post::query()->findOrFail($this->editingPostId)->update($attributes);
        } else {
            Post::query()->create($attributes);
        }

        $this->resetForm();
        $this->resetPage();

        session()->flash('success', 'Post berhasil disimpan.');
    }

    public function edit(int $postId): void
    {
        $post = Post::query()->findOrFail($postId);

        $this->editingPostId = $post->id;
        $this->categoryId = $post->category_id;
        $this->title = $post->title;
        $this->text = $post->text ?? '';
    }

    public function delete(int $postId): void
    {
        Post::query()->findOrFail($postId)->delete();

        if ($this->editingPostId === $postId) {
            $this->resetForm();
        }

        $this->resetPage();

        session()->flash('success', 'Post berhasil dihapus.');
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.posts.post-index', [
            'categories' => Category::query()
                ->orderBy('name')
                ->get(['id', 'name']),
            'posts' => Post::query()
                ->with('category:id,name')
                ->when($this->search !== '', function ($query): void {
                    $query->where(function ($query): void {
                        $query
                            ->where('title', 'like', "%{$this->search}%")
                            ->orWhere('text', 'like', "%{$this->search}%")
                            ->orWhereHas('category', fn ($query) => $query->where('name', 'like', "%{$this->search}%"));
                    });
                })
                ->latest()
                ->paginate(10),
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['categoryId', 'editingPostId', 'text', 'title']);
        $this->resetValidation();
    }
}
