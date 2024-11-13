@extends(config('theme.layouts.admin'),[
    'title' => 'Staging Data',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'NPS'
        ],
        ['label' => 'Staging Data'],
    ]

])

@section('content')

    @component(config('theme.components').'.filter',['name' => 'staging_data_filter','buttonLocation' => '#staging_data_card .card-toolbar'])
        {{-- {{ 
            Form::select2Input('role_id',null,route('role.list'),[
                'labelText' => 'Role',
                'formAlignment' => 'vertical',
                'elOptions' => [
                    'id' => 'select2-filter-role_id'
                ]
            ]) 
        }} --}}
    @endcomponent

    @component(config('theme.components').'.card',['name' => 'staging_data_card'])
        {!!
            DatatableBuilderHelper::render(route('staging-data.datatable'), [
                'columns' => [
                    [
                        'attribute' => 'id_transaksi',
                        'label' => 'ID Transaksi'
                    ],
                    'tanggal_transaksi',
                    [
                        'attribute' => 'nama_bm',
                        'label' => 'Nama Outlet'
                    ],
                    // [
                    //     'attribute' => 'outlet',
                    //     'label' => 'Nama Outlet'
                    // ],
                    [
                        'attribute' => 'data_type',
                        'label' => 'Type'
                    ],'url','publish_time',
                    [
                        'attribute' => 'is_wa',
                        'label' => 'Blast Whatsapp'
                    ],
                    [
                        'attribute' => 'is_published',
                        'label' => 'Publish Status'
                    ],
                    
                    [
                        'attribute' => 'is_answered',
                        'label' => 'Answer Status'
                    ],
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        // ['targets' => 0, 'visible' => false, 'searchable' => false,]
                        // ['targets' => 0,'width' => ' 10px'],
                        // ['targets' => 3, 'searchable' => false]
                    ],
                ],
                'elOptions' => [
                    'id' => 'staging_data_table',
                ],
                'toolbarLocation' => '#staging_data_card .card-toolbar',
                'titleLocation' => '#staging_data_card .card-title',
                'filter_form' => 'staging_data_filter',
                // 'export' => [
                //     'url' => route('staging_data.export'),
                //     'title' => 'NPS'
                // ],
                // 'import' => [
                //     'url' => route('staging_data.import'),
                //     'template' => route('staging_data.download-template'),
                //     'title' => 'NPS'
                // ],
                // 'job_trace' => [
                //     'title' => 'NPS',
                //     'filters' => [
                //         App\Exports\NPS\NetPromoterScoreExport::class,
                //         App\Imports\NPS\NetPromoterScoreImport::class
                //     ],
                // ],
                'noWrap' => true,
            ])
        !!}
    @endcomponent

@endsection

@push('additional-js')

<script type="text/javascript">

</script>

@endpush
