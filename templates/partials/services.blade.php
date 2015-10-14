<table class="table table-striped">
    <tbody>
    @foreach (array_chunk($services, 3) as $servicesRow)
        <tr>
            @foreach($servicesRow as $service)
                <td>
                    <span class="label label-info">ID: {{ $service->getId() }}</span>
                    {{ $service->getName() }}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>