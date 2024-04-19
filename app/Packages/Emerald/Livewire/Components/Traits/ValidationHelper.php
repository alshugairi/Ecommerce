<?php

namespace App\Packages\Emerald\Livewire\Components\Traits;

use App\Packages\Emerald\Livewire\Validation\Validation;
use http\Exception\RuntimeException;
use Illuminate\Validation\ValidationException;

trait ValidationHelper
{

    protected Validation $storeValidation;
    protected Validation $updateValidation;

    /**
     * @param $propertyName
     * @return void
     * @throws ValidationException
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        if (isset($this->storeValidation)) {
            return $this->storeValidation::rules();
        }

        if (isset($this->updateValidation)) {
            return $this->updateValidation::rules();
        }

        throw new RuntimeException('Validation Property isn\'t initialized');
    }

}
