<?php

use Livewire\Component;
use App\Models\Genre;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.admin')] class extends Component {
    public $name = '';

    public function getGenres()
    {
        return Genre::all();
    }

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

    public function delete($id)
    {
        Genre::find($id)->delete();
    }

}; ?>

<div class="d-flex flex-column">
    <nav class="nav mb-4 w-100 d-flex flex-row align-items-center sticky-top p-3 justify-content-between" style="background-color: #4a6a8f;">
        <div class="d-flex flex-row gap-4">
            <a href="/dashboard" wire:navigate class="d-flex flex-row gap-1 link-underline link-underline-opacity-0">
                <button class="btn bg-white">
                    Dashboard
                </button>
            </a>
            
            <a href="/admin/genres" wire:navigate class="d-flex flex-row gap-1 link-underline link-underline-opacity-0">
                <button class="btn bg-white">
                    Manage Genre
                </button>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="nav-item m-0 p-0">
                @csrf
                <button type="submit" class="btn bg-white" style="cursor: pointer;">
                    Logout
                </button>
            </form>
        </div>
        <h4 class="text fw-bold text-white">管理者パネルへようこそ！</h4>
    </nav>

    <div class="container p-4 rounded-3 bg-white">
        <h3 class="fw-bold mb-4 text-dark card-header">Manage Genres</h3>
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
        </div>
        @endif
        
        <form wire:submit="save" class="d-flex gap-2 mb-4" style="max-width: 400px;">
            <input type="text" wire:model="name" class="form-control" placeholder="input genre">
            <button type="submit" class="btn btn-primary text-nowrap">Add Genre</button>
        </form>
    
        <table class="table table-striped table-hover rounded overflow-hidden">
            <thead>
                <tr class="card-header" style="background-color: #344150;">
                    <th>Genre/Type</th>
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
</div>