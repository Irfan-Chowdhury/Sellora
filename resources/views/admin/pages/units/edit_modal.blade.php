<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">{{ __('file.Edit Unit') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="unit_id" id="modelId">
                    <input type="hidden" name="_method" value="PUT">

                    <!-- Name -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('file.Name') }} *</label>
                            <input type="text" name="name" id="name" required class="form-control" placeholder="{{ __('file.Unit Name') }}">
                        </div>
                    </div>

                    <!-- Code -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('file.Code') }} *</label>
                            <input type="text" name="code" id="code" required class="form-control" placeholder="{{ __('file.Unit Code') }}">
                        </div>
                    </div>

                    <!-- Base Unit -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('file.Base Unit') }}</label>
                            <select name="base_unit" id="base_unit" class="form-control">
                                <option value="">{{ __('file.None') }}</option>
                                @foreach ($baseUnits as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Operator -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Operator') }} <span class="text-bold text-danger"></span></label>
                            <select name="operator" id="operator" required class="form-control">
                                <option value="/">/</option>
                                <option value="*">*</option>
                            </select>
                        </div>
                    </div>

                    <!-- Operation Value -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ __('file.Operation Value') }} *</label>
                            <input type="number" name="operation_value" id="operation_value" step="any" required class="form-control" placeholder="{{ __('file.Operation Value') }}">
                        </div>
                    </div>
                    <!-- Active Checkbox -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active_edit" value="1">
                                <label class="form-check-label" for="is_active_edit">{{ __('file.Active') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" name="action_button" id="updateButton" class="btn btn-primary">@lang('file.Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
