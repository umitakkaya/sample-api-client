<div class="modal fade remote-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Doctor Services</h4>

            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>ServiceID</th>
                        <th>Price range (Min - Max)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($doctorServices as $doctorService)
                        <tr data-doctor-service-id="{{ $doctorService->getId() }}">
                            <th>{{ $doctorService->getId() }}</th>
                            <td>{{ $doctorService->getName() }}</td>
                            <td>{{ $doctorService->getServiceId() }}</td>
                            <td>
                                <span class="min-price">{{ $doctorService->getPriceMin() ?: 'Ø'  }}</span> - <span class="max-price">{{ $doctorService->getPriceMax() ?: 'Ø' }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button"
                                            class="btn btn-default btn-remote-modal"
                                            data-url="/forms/modify-doctor-service?facility-id={{ $facilityId }}&doctor-id={{ $doctorId }}&doctor-service-id={{ $doctorService->getId() }}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        Modify
                                    </button>

                                    <button type="button"
                                            class="btn btn-danger btn-remote-call"
                                            data-method="DELETE"
                                            data-url="/facilities/{{ $facilityId }}/doctors/{{ $doctorId }}/services/{{ $doctorService->getId() }}">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>