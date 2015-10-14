<div class="slot-doctor-service dismissable" data-index="{{ $doctorServiceIndex }}">

    <div class="form-group">
        <div class="input-group input-group-sm">
            <span class="input-group-addon" id="ddl-doctor-service-{{ $doctorServiceIndex }}">Doctor service:</span>
            <select aria-describedby="ddl-doctor-service-{{ $doctorServiceIndex }}"
                    name="slots[{{ $slotIndex }}][doctor_services][{{ $doctorServiceIndex }}][id]"
                    class="form-control" required>
                <option value="">Select doctor service</option>
                @foreach($doctorServices as $doctorService)
                    <option value="{{ $doctorService->getId() }}">{{ $doctorService->getName() }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group input-group-sm">
            <span class="input-group-addon" id="txt-service-duration-{{ $doctorServiceIndex }}">Service duration:</span>
            <input class="form-control input-sm" type="number" min="10" value="10"
                   aria-describedby="txt-service-duration-{{ $doctorServiceIndex }}"
                   name="slots[{{ $slotIndex }}][doctor_services][{{ $doctorServiceIndex }}][duration]"
                   placeholder="Duration of this doctor service" required/>
        </div>
    </div>
    @if($doctorServiceIndex > 0)
        <div class="form-group">
            <button class="btn btn-danger btn-sm btn-remove-service" type="button">
                <span class="glyphicon glyphicon-minus"></span>
                Remove doctor service
            </button>
        </div>
    @endif
</div>