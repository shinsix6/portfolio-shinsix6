<?php

use Livewire\Component;
use App\Models\Project;

new class extends Component
{
    public function getProjects()
    {
        return Project::latest()->get();
    }
};
?>

<div class="flex-column mx-auto" style="width: 530px; margin-top: 7em;">
    <div class="d-flex flex-column gap-3">
        <h5 class="fs-5 fw-bold align-self-start">Work</h5>
        <div class="row gx-3 gy-4 p-3 rounded-3 mx-0" style="background-color: #4d4d5b30;">   
            @foreach ($this->getProjects()->where('genre', 'dev_work') as $project)
                <div class="col-6 d-flex flex-column align-items-center text-center">
                    @if ($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="rounded-3 w-100 m-0 p-0" style="height: 140px; object-fit: cover;" alt="{{ $project->title }}">
                    @endif
                    <h5 class="card-title fw-bold mt-2">
                        {{ $project->title }}
                    </h5>
                    <p class="small w-100 mt-1">
                        {{ $project->description }}
                    </p>
                </div> 
            @endforeach
        </div>
    </div>

    <div class="d-flex flex-column gap-4 mt-5">
        <h5 class="fs-5 fw-bold align-self-start">Design</h5>
        <div class="row gx-3 gy-4 p-2 rounded-3 mx-0" style="background-color: #4d4d5b30;">   
            @foreach ($this->getProjects()->where('genre', 'design') as $project)
                <div class="col-6 d-flex flex-column align-items-center text-center">
                    @if ($project->image)
                        <img src="{{ asset('storage/' . $project->image) }}" class="rounded-3 w-100" style="height: 140px; object-fit: cover;" alt="{{ $project->title }}">
                    @endif
                    <h5 class="card-title fw-bold mt-2">
                        {{ $project->title }}
                    </h5>
                    <p class="small w-100 mt-1">
                        {{ $project->description }}
                    </p>
                </div> 
            @endforeach
        </div>
    </div>
</div>