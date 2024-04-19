<?php

namespace App\Packages\Emerald\Livewire\Components;

use App\Helpers\RoleHelper;
use Illuminate\{Contracts\Foundation\Application, Contracts\View\Factory, Contracts\View\View};
use Livewire\{Component};

abstract class LivewireComponent extends Component
{

    /**
     * The base path where the view files are located.
     *
     * @var string
     */
    protected string $viewPath = 'modules.';

    /**
     * The name of the view file to be loaded.
     *
     * @var string
     */
    protected string $view = '';

    /**
     * Data should be passed to the view.
     *
     * @var mixed
     */
    protected mixed $data = null;

    protected string $paginationTheme = 'bootstrap';

    /**
     * Renders the Livewire component view with the given data
     *
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view($this->viewPath . $this->view);
    }

    /**
     * @param string $permission
     * @param string $route
     * @return void
     */
    protected function checkPermission(string $permission, string $route): void
    {
        if ($this->hasNoPermission($permission)) {
            redirect()
                ->route($route)
                ->send();
        }
    }

    /**
     * @param string $permission
     * @return bool
     */
    protected function hasNoPermission(string $permission): bool
    {
        if (RoleHelper::IsHaveAccess($permission)) {
            $this->emit('error', 'We regret to inform you that you do not have permission to perform that action.');
            return true;
        }
        return false;
    }
}
