<div class="modal fade" id="createModal" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Unit</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <p class="italic">
                    <small> The field labels marked with <span
                            class="text-bold text-danger">*</span> are required input
                        fields.</small>
                </p>

                <form id="submitForm" method="POST" action="">
                    @csrf

                    <!-- Name -->
                    <div class="form-group">
                        <label>{{ trans('file.Name') }} <span
                                class="text-bold text-danger">*</span></label>
                        <input type="text" name="name" required
                            class="form-control" placeholder="Enter name">
                    </div>

                    <!-- Code -->
                    <div class="form-group">
                        <label>{{ trans('file.Code') }} <span
                                class="text-bold text-danger">*</span></label>
                        <input type="text" name="code" required
                            class="form-control" placeholder="Enter code">
                    </div>

                    <div class="form-group">
                        <label>{{ trans('file.Base Unit') }}</label>
                        <select name="base_unit" class="form-control">
                            <option value="">{{ trans('file.None') }}</option>
                            @foreach ($baseUnits as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Operator -->
                    <div class="form-group">
                        <label>{{ trans('file.Operator') }} <span class="text-bold text-danger"></span></label>
                        <select name="operator" id="operator" class="form-control">
                            <option value="/">/</option>
                            <option value="*">*</option>
                        </select>
                    </div>

                    <!-- Operation Value -->
                    <div class="form-group">
                        <label>{{ trans('file.Operation Value') }} <span class="text-bold text-danger"></span></label>
                        <input type="number" name="operation_value" id="operation_value" step="any" class="form-control" placeholder="Enter operation value">
                    </div>


                    <!-- Base Unit -->
                    {{-- <div class="form-group">
                        <label>{{ trans('file.Base Unit') }}</label>
                        <select name="base_unit" class="form-control">
                            <option value="">{{ trans('file.None') }}</option>
                            @foreach ($baseUnits as $item)
                                <option value={{ $item->id }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <!-- Operator -->
                    {{-- <div class="form-group">
                        <label>{{ trans('file.Operator') }} <span
                                class="text-bold text-danger"></span></label>
                        <input type="text" name="operator"
                            class="form-control" placeholder="Enter operator (e.g., *, /)">
                    </div> --}}

                    <!-- Operation Value -->
                    {{-- <div class="form-group">
                        <label>{{ trans('file.Operation Value') }} <span
                                class="text-bold text-danger"></span></label>
                        <input type="number" name="operation_value" step="any"
                            class="form-control" placeholder="Enter operation value">
                    </div> --}}

                    <!-- Active Checkbox -->
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input"
                            name="is_active" id="is_active_add" value="1" checked>
                        <label class="custom-control-label"
                            for="is_active_add">{{ trans('file.Active') }}</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-center">
                        <button type="submit" name="action_button" id="submitButton"
                            class="btn btn-primary">@lang('file.Submit')</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
