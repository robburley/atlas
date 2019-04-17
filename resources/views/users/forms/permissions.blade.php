<div class="row">
    <div class="col-sm-12">
        {!! Form::select('template', FormPopulator::permissionTemplates() , null , ['class' => 'form-control', 'placeholder' => 'Choose a template', 'id' => 'template-select']) !!}
    </div>
</div>

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
                        {!! Form::checkbox('permissions[]', $permission->id, null,  ['id' => 'permissions[]', 'class' => 'permission-checkbox']) !!}
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>
    @endforeach
@endforeach

@section('scripts')
    @parent

    <script type="text/javascript">
        $(document).ready(function () {
            $('#template-select').change(function () {
                unset();
                $.get("/admin/users/permission-templates/" + $(this).val(), function (data) {

                    for (var permission in data.permissions) {
                        $('.permission-checkbox[value="' + data.permissions[permission].id + '"]')[0].checked = true;
                    }

                });
            });
        });

        function unset() {
            $('.permission-checkbox').attr('checked', false);
        }
    </script>
@endsection