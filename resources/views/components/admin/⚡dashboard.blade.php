<?php

use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public $projectId = null;
    public $title = '';
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
        $this->description = null;
        $this->image = null;
        $this->link = '';
        $this->isEdit = false;
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
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'max:5048'],
            'link' => ['nullable', 'url', 'max:255'],
        ]);

        $imagePath = $this->image->store('project', 'public');

        Project::create([
            'title' => $this->title,
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
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:5048'],
            'link' => ['nullable', 'url', 'max:255'],
        ]);

        $imagePath = $project->image;

        if ($this->image) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $imagePath = $this->image->store('project', 'public');

        }

        $project->update([
            'title' => $this->title,
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

        $this->resetForm;
    }

};
?>

<div>
    
</div>