<div class="modal fade" id="createModal" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Tax</h5>
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

                     <!-- Rate -->
                    <div class="form-group">
                        <label>{{ trans('file.Rate') }} <span
                                class="text-bold text-danger">*</span></label>
                        <input type="number" name="rate" required
                            class="form-control" placeholder="Enter rate">
                    </div>

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
