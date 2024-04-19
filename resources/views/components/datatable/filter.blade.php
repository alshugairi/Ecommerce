<button class="dt-button btn btn-sm btn-info waves-effect waves-light"
        type="button"
        data-toggle="modal"
        data-target="#filterOptionsModal">
    <span>
        <i class="fa-solid fa-filter"></i>
        <span>
            {{ __('share.filter') }}
        </span>
    </span>
</button>

<!-- Modal -->
<div class="modal fade text-left" id="filterOptionsModal" tabindex="-1" aria-labelledby="filterOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterOptionsModalLabel">{{ __('share.filter_options') }}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    {{ $form }}
                    <button type="submit" class="btn btn-primary mb-2 d-grid w-100">{{ __('share.apply_filter') }}</button>
                    <button type="button" class="btn btn-label-secondary d-grid w-100" data-dismiss="modal">
                        {{ __('share.cancel') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

