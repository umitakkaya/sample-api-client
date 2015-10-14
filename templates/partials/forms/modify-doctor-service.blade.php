<form id="form-modify-service" action="/facilities/{{ $facilityId }}/doctors/{{ $doctorId }}/services/{{ $doctorServiceId }}" method="PATCH">
    <div class="modal fade remote-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Modify Doctor Service</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txt-minimum-price" class="control-label">Minimum price:</label>
                        <input type="number" min="0" class="form-control" id="txt-minimum-price"
                               name="minimum-price">
                    </div>
                    <div class="form-group">
                        <label for="txt-maximum-price" class="control-label">Maximum price:</label>
                        <input type="number" min="0" class="form-control" id="txt-maximum-price"
                               name="maximum-price">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-save-service">Save</button>
                    <button class="btn btn-danger btn-cancel-service" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>