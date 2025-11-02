   <!-- Modal -->
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{__('file.Edit Role')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <div class="modal-body">

                <form method="post" id="updateForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="brand_id" id="modelId">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{__('file.Brand Name')}} *</label>
                            <input type="text" name="name" id="name" required class="form-control" placeholder="{{__('file.Brand Name')}}">
                        </div>
                    </div>

                    <div class="col-md-6 form-group mt-3">
                        <label for="imageFile">{{__('file.Insert Image')}}</label>
                        <input type="file" id="imageInputEdit" accept="image/*" class="form-control-file" name="image">

                        <!-- ✅ Image Preview -->
                        <img id="previewImageEdit" src="" alt="" class="mt-2" style="width:150px; height: 150px; display:none; border:1px solid #ddd; padding:5px;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1">
                                <label class="form-check-label">{{__('file.Active')}}</label>
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
