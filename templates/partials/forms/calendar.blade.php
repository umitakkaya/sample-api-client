<form id="form-calendar" action="/facilities/{{ $facilityId }}/doctors/{{ $doctor->getId() }}/slots" method="GET">
    <div class="modal remote-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{ $doctor->getName() }} {{ $doctor->getSurname() }} calendar</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ddl-address-id" class="control-label">Address:</label>
                        <select class="form-control" id="ddl-address-id" name="address-id" required>
                            <option value="">Select address</option>
                            @foreach($addresses as $address)
                                <option value="{{ $address->getId() }}">{{ $address->getName() }}
                                    - {{ $address->getStreet() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dt-range" class="control-label">Select date:</label>
                        <input id="dt-range" type="text" class="form-control datetime-range" data-start="{{ $minDate }}" data-end="{{ $maxDate }}" required>
                        <input type="hidden" name="start" value="{{ $minDate }}">
                        <input type="hidden" name="end" value="{{ $maxDate }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-show-calendar">Show calendar</button>
                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>