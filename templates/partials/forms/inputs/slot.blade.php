<div class="slot-input dismissable well" data-index="{{ $index }}">
    <div class="form-group">
        <div class="input-group input-group-sm">
            <span class="input-group-addon" id="txt-slot-range-start-{{ $index }}">Slot range start</span>
            <input type="text" class="datetimepicker form-control input-sm"
                   aria-describedby="txt-slot-range-start-{{ $index }}"
                   name="slots[{{ $index }}][start]" required/>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group input-group-sm">
            <span class="input-group-addon" id="txt-slot-range-end-{{ $index }}">Slot range end&nbsp;</span>
            <input type="text" class="datetimepicker form-control input-sm"
                   aria-describedby="txt-slot-range-end-{{ $index }}"
                   name="slots[{{ $index }}][end]" required/>
        </div>
    </div>
    <div class="form-group doctor-service-inputs panel panel-body">
        @include('partials.forms.inputs.slot-doctor-service', [ 'slotIndex' => $index, 'doctorServiceIndex' => 0, 'facilityId' => $facilityId, 'doctorId' => $doctorId ])
    </div>
    <div class="btn-group">
        <button class="btn btn-success btn-sm btn-add-doctor-service" data-doctor-id="{{ $doctorId }}"
                data-facility-id="{{ $facilityId }}" type="button">
            <span class="glyphicon glyphicon-plus"></span>
            Add doctor service
        </button>
        @if($index > 0)
            <button class="btn btn-danger btn-sm btn-remove-slot" type="button">
                <span class="glyphicon glyphicon-minus"></span>
                Remove slot
            </button>
        @endif
    </div>
</div>