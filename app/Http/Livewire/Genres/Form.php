<?php

namespace App\Http\Livewire\Genres;

use App\Models\Genres;
use Livewire\Component;

class Form extends Component
{
    public $title_page;
    public $mid;
    public $name;
    public $description;
    public $status;
    public $thumbnail;
    
    public function mount($id = null)
    {
        $this->mid = $id;
        $model = Genres::firstOrNew(['id' => $id]);
        foreach ($model->getFillable() as $item) {
            $this->{$item} = $model->{$item};
        }
        
        $this->title_page = $model->name ?: trans('app.add_new');
    }
    
    public function save() {
        $this->validate([
            'name' => 'required|string|max:250',
            'description' => 'nullable|string|max:250',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
        ]);
        
        $model = Genres::firstOrNew(['id' => $this->mid]);
        $model->fill((array) $this);
        $model->save();
    
        session()->flash('message', trans('app.save_successfully'));
        return redirect()->route('admin.genres');
    }
    
    public function render()
    {
        return view('livewire.genres.form');
    }
}
