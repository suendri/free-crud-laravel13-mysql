<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public string $name = '';

    public string $search = '';

    public ?int $editingCategoryId = null;

    public function save(): void
    {
        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique(Category::class)->ignore($this->editingCategoryId),
            ],
        ]);

        if ($this->editingCategoryId) {
            Category::query()->findOrFail($this->editingCategoryId)->update($validated);
        } else {
            Category::query()->create($validated);
        }

        $this->resetForm();
        $this->resetPage();

        session()->flash('success', 'Kategori berhasil disimpan.');
    }

    public function edit(int $categoryId): void
    {
        $category = Category::query()->findOrFail($categoryId);

        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
    }

    public function delete(int $categoryId): void
    {
        Category::query()->findOrFail($categoryId)->delete();

        if ($this->editingCategoryId === $categoryId) {
            $this->resetForm();
        }

        $this->resetPage();

        session()->flash('success', 'Kategori berhasil dihapus.');
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
        return view('livewire.categories.category-index', [
            'categories' => Category::query()
                ->when($this->search !== '', fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(10),
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['editingCategoryId', 'name']);
        $this->resetValidation();
    }
}
