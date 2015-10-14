<div class="panel-group" id="facility-accordion" role="tablist" aria-multiselectable="true">
    @foreach($facilities as $facility)
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $facility->name }}</h3>
            </div>
            <div class="panel-body">
                <div class="item-actions">
                    <a href="/facilities/{{ $facility->id }}/doctors" class="ajax-facility-doctors btn btn-link">
                        <span class="glyphicon glyphicon-list"></span>
                        List doctors
                    </a>
                </div>
                <div class="facility-doctors">
                </div>
            </div>
        </div>
    @endforeach
</div>