<div class="modal fade remote-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Bookings</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="dt-range" class="control-label">Select date:</label>
                    <input id="dt-range" type="text" class="form-control datetime-range"
                           data-url="/facilities/{{ $facilityId }}/doctors/{{ $doctorId }}/addresses/{{ $addressId }}/booking-list"
                           data-start="{{ $start }}"
                           data-end="{{ $end }}">
                </div>

                <div class="booking-list">
                    @include('partials.booking-list')
                </div>
            </div>
        </div>
    </div>
</div>