<?php

namespace App\Packages\Emerald\Livewire\Components\Traits;

use App\Packages\Emerald\Livewire\Validation\Validation;
use Illuminate\{Contracts\Foundation\Application, Contracts\View\Factory, Contracts\View\View};

trait EditHelper
{
    public int $rowId;
    protected Validation $updateValidation;

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render(): Factory|View|Application
    {
        return view('modules.' . $this->view);
    }

    protected function rules(): array
    {
        return $this->updateValidation::rules();
    }
}
