@extends(config('theme.layouts.admin'),[
    'title' => 'Assets',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'Assets'
        ],
    ]

])

@section('content')
    <!--begin::Card-->
    <div class="card card-flush pb-0 bgi-position-y-center bgi-no-repeat mb-10" style="background-size: auto calc(100% + 10rem); background-position-x: 100%; background-image: url('assets/media/illustrations/sketchy-1/4.png')">
        <!--begin::Card header-->
        <div class="card-header pt-10 pb-10">
            <div class="d-flex align-items-center">
                <!--begin::Icon-->
                <div class="symbol symbol-circle me-5">
                    <div class="symbol-label bg-transparent text-primary border border-secondary border-dashed">
                        <i class="ki-duotone ki-abstract-47 fs-2x text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <!--end::Icon-->
                <!--begin::Title-->
                <div class="d-flex flex-column">
                    <h2 class="mb-1">Assets</h2>
                    @php
                        $totalSpace = get_file_size(disk_total_space(storage_path()));
                        $freeSpace = get_file_size(disk_free_space(storage_path()));
                        // $totalItems = 0;
                        // try{
                        //     $fi = new FilesystemIterator(storage_path('app\public\template'), FilesystemIterator::SKIP_DOTS);
                        //     $totalItems = iterator_count($fi);
                        // }catch(\Exception $ex){

                        // }
                    @endphp
                    <div class="text-muted fw-bold">
                        {{$freeSpace}}/{{$totalSpace}}<span class="mx-3">
                        {{-- |</span>{{$totalItems}} items --}}
                    </div>
                </div>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::Card-->
    
    @component(config('theme.components').'.card',['name' => 'asset_card'])
        {!!
            DatatableBuilderHelper::render(route('asset.datatable'), [
                'columns' => [
                    'id',
                    'name',
                    'size',
                    'ext',
                    ['attribute' => 'created_at', 'label' => 'Uploaded At'],
                    ['attribute' => 'updated_at', 'label' => 'Last Modified At'],
                    ['attribute' => 'uploaded_by', 'label' => 'Uploaded By'],
                    'action',
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        ['targets' => 0,'visible' => false],
                        ['targets' => 3,'searchable' => false],
                    ],
                ],
                'elOptions' => [
                    'id' => 'asset_table',
                ],
                'toolbarLocation' => '#asset_card .card-toolbar',
                'titleLocation' => '#asset_card .card-title',
                'create' => [
                    'modal' => 'modal_form_asset',
                    'updateOnly' => true,
                ],
                'ajaxParams' => [
                    'type' => $type,
                ],
                'noWrap' => true
            ])
        !!}
    @endcomponent

    @component(config('theme.components').'.modal-ajax-form',[
        'title' => 'Create Assets',
        'name' => 'modal_form_asset',
        'table' => 'asset_table',
        'additionalClass' => 'mw-650px',
        'size' => '',
        'url' => route('asset.save'),
    ])

        {{
            Form::textInput('name',null)
        }}

    @endcomponent

@endsection

@push('additional-js')
{{-- <script src="{{asset('templates/metronic-back-office/js/custom/apps/file-manager/list.js')}}"></script> --}}
@endpush
