@extends(config('theme.layouts.admin'),[
    'title' => 'User',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        ['label' => 'User Management'],
        [
            'label' => 'User'
        ],
    ]

])

@section('content')

    @component(config('theme.components').'.filter',['name' => 'user_filter','buttonLocation' => '#user_card .card-toolbar'])

        {{ 
            Form::select2Input('jabatan_id',null,route('jabatan.list'),[
                'labelText' => 'Jabatan',
                'formAlignment' => 'vertical',
                'elOptions' => [
                    'id' => 'select2-filter-jabatan_id'
                ],
            ]) 
        }}

        {{ 
            Form::select2Input('role_id',null,route('role.list'),[
                'labelText' => 'Role',
                'formAlignment' => 'vertical',
                'elOptions' => [
                    'id' => 'select2-filter-role_id'
                ],
                'ajaxParams' => ['exclude_master' => true]
            ]) 
        }}

        {{ 
            Form::select2Input('outlet_id',null,route('outlet.list'),[
                'labelText' => 'Outlet',
                'formAlignment' => 'vertical',
                'elOptions' => [
                    'id' => 'select2-filter-outlet_id'
                ],
            ]) 
        }}

    @endcomponent

    @component(config('theme.components').'.card',['name' => 'user_card'])
        {!!
            DatatableBuilderHelper::render(route('user.datatable'), [
                'columns' => [
                    'action',
                    'name','jenis_kelamin',
                    ['attribute' => 'npp', 'label' => 'NPP'],
                    ['attribute' => 'jabatan.name', 'label' => 'Jabatan'],
                    ['attribute' => 'role.name', 'label' => 'Role'],
                    ['attribute' => 'jabatan.level_jabatan', 'label' => 'Level Jabatan'],
                    ['attribute' => 'jabatan.classifiers', 'label' => 'Classifier'],
                    ['attribute' => 'outlet.name', 'label' => 'Outlet'],
                    ['attribute' => 'unit_bisnis', 'label' => 'Unit Bisnis'],
                    'email', 'active'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        ['targets' => 0,'width' => '10px'],
                        ['targets' => 11,'className' => 'text-center'],
                        ['targets' => [6,7],'searchable' => false]
                    ],
                ],
                'elOptions' => [
                    'id' => 'user_table',
                ],
                'toolbarLocation' => '#user_card .card-toolbar',
                'titleLocation' => '#user_card .card-title',
                'create' => [
                    //'text' => 'Create User',
                    'modal' => 'modal_form_user'
                    // 'url' => route('user.create')
                ],
                'export' => [
                    'url' => route('user.export'),
                    'title' => 'User'
                ],
                'job_trace' => [
                    'title' => 'User',
                    'filters' => [
                        App\Exports\ACL\Users\UserExport::class,
                    ],
                ],
                'filter_form' => 'user_filter',
                'noWrap' => true,
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create User',
        'name' => 'modal_form_user',
        'table' => 'user_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('user.save'),
    ])

        {{ Form::textInput('name',null,['formAlignment' => 'vertical', 'required' => 'required']) }}

        {{ 
            Form::select2Input('jenis_kelamin', null, [
                'LAKI-LAKI' => 'LAKI-LAKI',
                'PEREMPUAN' => 'PEREMPUAN',
            ], [
                'pluginOptions' => ['allowClear' => false],
                'formAlignment' => 'vertical',
                'required' => 'required'
            ]) 
        }}

        {{ Form::textInput('npp',null,['formAlignment' => 'vertical', 'required' => 'required', 'labelText' => 'NPP']) }}

        {{ 
            Form::select2Input('jabatan_id',null,route('jabatan.list'),[
                'labelText' => 'Jabatan',
                'formAlignment' => 'vertical', 
                'required' => 'required'
            ]) 
        }}

        {{ 
            Form::select2Input('outlet_id',null,route('outlet.list'),[
                'labelText' => 'Outlet',
                'formAlignment' => 'vertical', 
            ]) 
        }}

        {{ 
            Form::select2Input('unit_bisnis_id',null,route('unit.bisnis.list'),[
                'labelText' => 'Unit Bisnis',
                'formAlignment' => 'vertical', 
            ]) 
        }}

        {{ Form::emailInput('email',null,['formAlignment' => 'vertical']) }}

    @endcomponent

@endsection

@push('additional-js')

<script type="text/javascript">


</script>

@endpush
