<?php

use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.admin')] class extends Component
{
    use WithFileUploads;

    public $projectId = null;
    public $title = '';
    public $genre_id = '';
    public $description = null;
    public $image = null;
    public $oldImage = null;
    public $link = '';
    public $isEdit = false;

    public function getProject()
    {
        return Project::latest()->get();
    }

    public function resetForm(): void
    {
        $this->projectId = null;
        $this->title = '';
        $this->genre_id = '';
        $this->description = null;
        $this->image = null;
        $this->link = '';
        $this->isEdit = false;

        $this->resetValidation();
    }

    public function saveOrUpdate(): void
    {
        if ($this->isEdit) {
            $this->update();
        } else {
            $this->save();
        }
    }

    public function save(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre_id' => ['required', 'exists:genres,id'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'max:2048'],
            'link' => ['nullable', 'url', 'max:255'],
        ]);

        $imagePath = $this->image->store('project', 's3');

        Project::create([
            'title' => $this->title,
            'genre_id' => $this->genre_id,
            'description' => $this->description,
            'image' => $imagePath,
            'link' => $this->link,
        ]);

        session()->flash('success', "Success added project's data.");

        $this->resetForm();
    }    

    public function edit($id): void
    {
        $project = Project::findOrFail($id);

        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->genre_id = $project->genre_id;
        $this->description = $project->description;
        $this->oldImage = $project->image;
        $this->link = $project->link;
        $this->image = null;
        $this->isEdit = true;

        $this->resetValidation();
    }

    public function update(): void
    {
        $project = Project::findOrFail($this->projectId);

        $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre_id' => ['required', 'exists:genres,id'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'link' => ['nullable', 'url', 'max:255'],
        ]);

        $imagePath = $project->image;

        if ($this->image) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $imagePath = $this->image->store('project', 's3');

        }

        $project->update([
            'title' => $this->title,
            'genre_id' => $this->genre_id,
            'description' => $this->description,
            'image' => $imagePath,
            'link' => $this->link,
        ]);

        session()->flash('success', "Success updated project's data.");

        $this->resetForm();
    }

    public function delete($id): void
    {
        $project = Project::findOrFail($id);

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        session()->flash('success', "Project's data has been deleted.");

        $this->resetForm();
    }
    

};
?>

<div class="d-flex flex-column align-items-center justify-content-center">
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


    @if (session('status'))            
        <div class="alert alert-success p-3">
            <p class="mb-0">{{ session('success') }}</p>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <p class="mb-0">{{ $isEdit ? 'Edit Project' : 'Add Project' }}</p>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="saveOrUpdate">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control mb-3"  wire:model="title" placeholder="Input title">

                    @error('title')
                        <small class="text-danger">{{ $message }}</small>                       
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">About Project</label>
                    <input type="text" class="form-control" wire:model="description" placeholder="Input project description">
                </div>

                <div class="mb-3">
                    <label class="form-label">Project Genre</label>
                    <select wire:model="genre_id" class="form-select">
                        <option value="">-- Select Genre --</option>
                        @foreach(\App\Models\Genre::all() as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>

                    <div class="mb-3">
                    <label class="form-label">Link (optional)</label>
                    <input type="text" class="form-control mb-3"  wire:model="link" placeholder="Input link">

                    @error('title')
                        <small class="text-danger">{{ $message }}</small>                       
                    @enderror
                </div>

                <div class="mb-3"
                    x-data="{ isUploading: false, progress: 0 }" 
                    x-on:livewire-upload-start="isUploading = true" 
                    x-on:livewire-upload-finish="isUploading = false" 
                    x-on:livewire-upload-error="isUploading = false" 
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <label class="form-label">Thumbnail</label>
                    <input type="file" wire:model="image" accept="image/*" class="form-control">
                    
                    <div x-show="isUploading" class="progress mt-2" style="height: 20px">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                        role="progressbar" 
                        :style="`width: ${progress}%`"
                        x-text="`Uploading: ${progress}%`">
                        </div>
                    </div>

                    <div wire:loading wire:target="image" class="text-primary small mt-2">
                        Loading the image...
                    </div>

                    @error('image')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    @if ($image)                    
                        <p class="">Preview New Thumbnail</p>
                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" style="width: 160px; height: 220px; object-fit: cover;" alt="Preview new thumbnail">
                    @elseif ($oldImage)
                        <p class="">Current Thumbnail</p>
                        <img src="{{ Storage::url($oldImage) }}" class="img-thumbnail" style="width: 160px; height: 220px; object-fit: cover;" alt="Current thumbnail">
                    @endif
                    </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="image">
                        {{ $isEdit ? 'Update' : 'Save' }}
                    </button>

                    <button type="button" class="btn btn-secondary" wire:click="resetForm">
                        Reset
                    </button>
                </div>

            </form>
        </div>

    </div>

    <div class="card shadow-sm mb-5" style="background-color: transparent;">
        <div class="card-header text-white rounded-0" style="background-color: #344150;">List of Projects</div>
        
        <div class="card-body">
            <div class="row g-3">
                <h2 class="text-white">Work (development)</h2>                        
                @forelse ($this->getProject()->where('genre.slug', 'work-dev') as $project)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            @if ($project->image)        
                                <img src="{{ Storage::url($project->image) }}" class="card-img" style="height: 160px; object-fit: cover;" alt="{{ $project->title }}">
                                
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center">
                                    No image
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">
                                    {{ $project->title }}
                                </h5>
                                <p class="small">
                                    {{ $project->description }}
                                </p>
                                
                                <p class="text-muted small">
                                    ID: {{ $project->id }}
                                </p>
                                
                                <div class="mt-auto d-flex gap-2">
                                    <button
                                    type="button"
                                        class="btn btn-warning btn-sm w-50"
                                        wire:click="edit({{ $project->id }})"
                                        >
                                        Edit
                                    </button>
                                    
                                    <button
                                    type="button"
                                    class="btn btn-danger btn-sm w-50"
                                    wire:click="delete({{ $project->id }})"
                                    wire:confirm="Are you sure want to delete this project?"
                                    >
                                    Delete
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>
                
                @empty    
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No project data yet.
                        </div>
                    </div>
                @endforelse

                <h2 class="text-white">Design</h2>                   
                @forelse ($this->getProject()->where('genre.slug', 'design') as $project)     
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            @if ($project->image)        
                                <img src="{{ Storage::url($project->image) }}" class="card-img" style="height: 160px; object-fit: cover;" alt="{{ $project->title }}">
                                
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center">
                                    No image
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">
                                    {{ $project->title }}
                                </h5>
                                <p class="small">
                                    {{ $project->description }}
                                </p>
                                
                                <p class="text-muted small">
                                    ID: {{ $project->id }}
                                </p>
                                
                                <div class="mt-auto d-flex gap-2">
                                    <button
                                    type="button"
                                        class="btn btn-warning btn-sm w-50"
                                        wire:click="edit({{ $project->id }})"
                                        >
                                        Edit
                                    </button>
                                    
                                    <button
                                    type="button"
                                    class="btn btn-danger btn-sm w-50"
                                    wire:click="delete({{ $project->id }})"
                                    wire:confirm="Are you sure want to delete this project?"
                                    >
                                    Delete
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>
                
                @empty    
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            No project data yet.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
