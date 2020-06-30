<?php

namespace App\Http\Livewire\Countries;

use App\Models\Countries;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $search;
    public $status = 1;
    public $ids = [];
    protected $updatesQueryString = ['search', 'status'];
    
    public function search() {
        $this->search = request()->query('search', $this->search);
        $this->status = request()->query('status', $this->status);
    }
    
    public function delete() {
        dd($this->ids);
    }
    
    public function checkAll() {
    
    }
    
    public function toggleTask($taskId) {
        if (!in_array($taskId, $this->ids)) {
            $this->ids[] = $taskId;
        }
        else {
            $this->ids = array_diff($this->ids, [$taskId]);
        }
    }
    
    public function render()
    {
        $query = Countries::query();
        if ($this->search) {
            $query->where(function ($builder) {
                $builder->orWhere('name', 'like', '%'. $this->search .'%');
                $builder->orWhere('description', 'like', '%'. $this->search .'%');
            });
        }
        
        if (!is_null($this->status)) {
            $query->where('status', '=', $this->status);
        }
        
        $items = $query->paginate(10);
        return view('livewire.countries.index', [
            'items' => $items
        ]);
    }
}
