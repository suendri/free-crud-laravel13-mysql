<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $role = 'operator';

    public string $search = '';

    public ?int $editingUserId = null;

    public function mount(): void
    {
        Gate::authorize('manage-users');
    }

    public function save(): void
    {
        Gate::authorize('manage-users');

        $passwordRules = $this->editingUserId
            ? ['nullable', 'string', 'min:8']
            : ['required', 'string', 'min:8'];

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->editingUserId),
            ],
            'password' => $passwordRules,
            'role' => ['required', Rule::in(['admin', 'operator'])],
        ]);

        if ($this->editingUserId) {
            $user = User::query()->findOrFail($this->editingUserId);

            $attributes = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if ($user->isNot(auth()->user())) {
                $attributes['role'] = $validated['role'];
            }

            if ($validated['password'] !== '') {
                $attributes['password'] = Hash::make($validated['password']);
            }

            $user->update($attributes);
        } else {
            User::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);
        }

        $this->resetForm();
        $this->resetPage();

        session()->flash('success', 'User berhasil disimpan.');
    }

    public function edit(int $userId): void
    {
        Gate::authorize('manage-users');

        $user = User::query()->findOrFail($userId);

        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->role = $user->role;
    }

    public function updateRole(int $userId, string $role): void
    {
        Gate::authorize('manage-users');

        $validated = validator(
            ['role' => $role],
            ['role' => ['required', Rule::in(['admin', 'operator'])]],
        )->validate();

        $user = User::query()->findOrFail($userId);

        if ($user->is(auth()->user())) {
            session()->flash('error', 'Role akun sendiri tidak dapat diubah dari halaman ini.');

            return;
        }

        $user->update(['role' => $validated['role']]);

        session()->flash('success', 'Role user berhasil diperbarui.');
    }

    public function delete(int $userId): void
    {
        Gate::authorize('manage-users');

        $user = User::query()->findOrFail($userId);

        if ($user->is(auth()->user())) {
            session()->flash('error', 'Akun yang sedang login tidak dapat dihapus.');

            return;
        }

        $user->delete();

        if ($this->editingUserId === $userId) {
            $this->resetForm();
        }

        $this->resetPage();

        session()->flash('success', 'User berhasil dihapus.');
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
        return view('livewire.users.user-index', [
            'users' => User::query()
                ->select(['id', 'name', 'email', 'role', 'created_at'])
                ->when($this->search !== '', function ($query): void {
                    $query->where(function ($query): void {
                        $query
                            ->where('name', 'like', "%{$this->search}%")
                            ->orWhere('email', 'like', "%{$this->search}%")
                            ->orWhere('role', 'like', "%{$this->search}%");
                    });
                })
                ->latest()
                ->paginate(10),
        ]);
    }

    private function resetForm(): void
    {
        $this->reset(['editingUserId', 'email', 'name', 'password']);
        $this->role = 'operator';
        $this->resetValidation();
    }
}
