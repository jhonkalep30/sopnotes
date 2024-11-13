@extends(config('theme.layouts.admin'),[
    'title' => 'Net Promoter Score',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'NPS'
        ],
        ['label' => 'Net Promoter Score'],
    ]

])

@section('content')

    <div class="col-xl-12">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
            <!--begin::Body-->
            <div class="card-body ribbon ribbon-top ribbon-vertical">
                <div class="ribbon-label bg-info w-100px h-100px px-2">
                    @php
                        $nps = App\Models\NPS\NetPromoterScore::all();
                        $total = $nps->count();
                        $detractors = $nps->where('level','Detractors')->count();
                        $promoters = $nps->where('level','Promoters')->count();

                        $npsSummary = $total > 0 ? (($promoters/$total)*100) - (($detractors/$total)*100) : 0;
                    @endphp
                    <h2 class="fw-bolder text-white" data-kt-countup="true" data-kt-countup-value="{{$npsSummary}}" style="font-size: 36px;">0</h2><h2 class="fw-bolder text-white">%</h2>
                </div>
                <i class="ki-duotone ki-star text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>        

                <div class="text-white fw-bold fs-2 mb-2 mt-5">           
                    Net Promoter Score
                </div>

                <div class="fw-semibold text-white">
                   Based on customer survey <i class="fas fa-info-circle text-white mx-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="Cara Perhitungan NPS = %Promoters - %Detractors"></i>
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>    

    @component(config('theme.components').'.filter',['name' => 'nps_filter','buttonLocation' => '#nps_card .card-toolbar'])
        {{ 
            Form::dateInput('start_date',Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),[
                'formAlignment' => 'vertical',
            ]) 
        }}

        {{ 
            Form::dateInput('end_date',Carbon\Carbon::now()->format('Y-m-d'),[
                'formAlignment' => 'vertical',
            ]) 
        }}

        {{ 
            Form::select2Input('data_type',null,['klinik' => 'Klinik','lab' => 'Lab'],[
                'labelText' => 'Type',
                'formAlignment' => 'vertical',
                'elOptions' => [
                    'id' => 'select2-filter-type'
                ]
            ]) 
        }}

        {{ 
            Form::select2Input('outlet_name',null,route('outlet.list'),[
                'labelText' => 'Outlet',
                'formAlignment' => 'vertical',
                'key' => 'name',
                'elOptions' => [
                    'id' => 'select2-filter-outlet_id'
                ]
            ]) 
        }}
    @endcomponent

    @component(config('theme.components').'.card',['name' => 'nps_card'])
        {!!
            DatatableBuilderHelper::render(route('nps.datatable'), [
                'columns' => [
                    [
                        'attribute' => 'id_transaksi',
                        'label' => 'ID Transaksi'
                    ],
                    'tanggal_transaksi',
                    [
                        'attribute' => 'nama_bm',
                        'label' => 'Outlet'
                        // 'label' => 'Nama BM'
                    ],
                    [
                        'attribute' => 'data_type',
                        'label' => 'Type'
                    ],'score','level','feedback'
                ],
                'pluginOptions' => [
                    'columnDefs' => [
                        // ['targets' => 0,'width' => '10px'],
                        ['targets' => [4,5],'className' => 'text-center']
                    ],
                ],
                'elOptions' => [
                    'id' => 'nps_table',
                ],
                'toolbarLocation' => '#nps_card .card-toolbar',
                'titleLocation' => '#nps_card .card-title',
                'filter_form' => 'nps_filter',
                'export' => [
                    'url' => route('nps.export'),
                    'title' => 'NPS'
                ],
                // 'import' => [
                //     'url' => route('nps.import'),
                //     'template' => route('nps.download-template'),
                //     'title' => 'NPS'
                // ],
                'job_trace' => [
                    'title' => 'NPS',
                    'filters' => [
                        App\Exports\NPS\NetPromoterScoreExport::class,
                        App\Imports\NPS\NetPromoterScoreImport::class
                    ],
                ],
                'noWrap' => true,
            ])
        !!}
    @endcomponent

@endsection

@push('additional-js')

<script type="text/javascript">

</script>

@endpush
