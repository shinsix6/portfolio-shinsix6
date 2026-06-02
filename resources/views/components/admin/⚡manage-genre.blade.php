<?php

use Livewire\Component;
use App\Models\Genre;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.admin')] class extends Component {
    // 1. Form state property
    public $name = '';

    public function getGenres()
    {
        return Genre::all();
    }

    // 2. Save a new genre to MariaDB
    public function save()
    {
        $this->validate([
            'name' => 'required|min:2|unique:genres,name',
        ]);

        Genre::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        $this->reset('name');
        session()->flash('message', 'Genre added successfully!');
    }

    // 3. Remove a genre from Master Data
    public function delete($id)
    {
        Genre::find($id)->delete();
    }

    // // 4. Render the dynamic template data
    // public function render()
    // {
    //     return view('livewire.admin.manage-genre', [
    //         'genres' => Genre::all()
    //     ]);
    // }
}; ?>

<div class="container p-4">
    <h3 class="fw-bold mb-4 text-white">Manage Master Data: Genres</h3>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="d-flex gap-2 mb-4" style="max-width: 400px;">
        <input type="text" wire:model="name" class="form-control" placeholder="e.g., UI/UX Design">
        <button type="submit" class="btn btn-primary text-nowrap">Add Genre</button>
    </form>

    <table class="table table-dark table-hover rounded overflow-hidden">
        <thead>
            <tr>
                <th>Genre Name</th>
                <th>URL Slug Reference</th>
                <th width="100">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($this->getGenres() as $genre)
                <tr class="align-middle">
                    <td>{{ $genre->name }}</td>
                    <td><code>{{ $genre->slug }}</code></td>
                    <td>
                        <button wire:click="delete({{ $genre->id }})" class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-3">No master genres registered yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>