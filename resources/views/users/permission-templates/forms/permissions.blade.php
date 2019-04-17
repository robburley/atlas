@foreach($permissionTypes as $type)
    <div class="row">
        <div class="col-sm-12">
            <h4>{{ $type->name }}</h4>
        </div>
    </div>

    @foreach($type->permissions->chunk(3) as $chunk)
        <div class="row">
            @foreach($chunk as $permission)
                <div class="col-sm-4">
                    <label>
                        {!! Form::checkbox('permissions[]', $permission->id, null,  ['id' => 'permissions[]']) !!}
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach
@endforeach