@extends(config('theme.layouts.admin'),[
    'title' => 'Dashboard',
    'breadcrumb' => [
        // [
        //     'label' => 'Dashboard',
        //     'url' => route('admin.dashboard')
        // ],
        // [
        //     'label' => 'Dashboard'
        // ],
    ]

])

@section('content')
    
    <!-- DASHBOARD: STAFF -->
    @if(@\Auth::user()->role->name == 'Staff')
    
        <!--begin::Row-->
        <div class="row g-5 g-xl-10">

            <div class="col-xl-6 col-md-12 " >

                <div class="card">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body mt-2">

                            <div class="row">

                                <div class="col-8">
                                    <div class="card-label fs-3 fw-bold text-dark">Ceklis Harian</div>
                                    <div class="mt-4" >
                                        @php

                                            $reportDaily = App\Models\SOP\SurveyReport::join('surveys','survey_reports.survey_id','surveys.id')
                                                                                ->where('user_id',Auth::user()->id)
                                                                                ->where('surveys.frequency','daily')
                                                                                ->get();

                                            $surveyDaily = App\Models\SOP\Survey::where('frequency','daily')
                                                                            ->where('privacy',1)
                                                                            ->get();

                                            $totalDaily = $surveyDaily->count() > 0 ? round((($reportDaily->count()/$surveyDaily->count())*100),0) : 0;

                                        @endphp
                                        <span class="fw-bolder" style="font-size: 24px;">{{$reportDaily->count()}}</span>
                                        <span class="fw-bold text-gray-400 ms-1" style="font-size: 24px;">/</span>
                                        <span class="fw-bolder text-gray-400" style="font-size: 24px;">{{$surveyDaily->count()}}</span>
                                    </div>
                                </div>

                                <div class="col-4" >
                                    <div id="chart1" style="height: 100px;"></div>
                                </div>

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>

            <div class="col-xl-6 col-md-12 " >

                <div class="card">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body mt-2">

                            <div class="row">

                                <div class="col-8">
                                    <div class="card-label fs-3 fw-bold text-dark">Ceklis Mingguan</div>
                                    <div class="mt-4" >
                                        @php
                                        
                                            $reportWeekly = App\Models\SOP\SurveyReport::join('surveys','survey_reports.survey_id','surveys.id')
                                                                                ->where('user_id',Auth::user()->id)
                                                                                ->where('surveys.frequency','weekly')
                                                                                ->get();

                                            $surveyWeekly = App\Models\SOP\Survey::where('frequency','weekly')
                                                                            ->where('privacy',1)
                                                                            ->get();

                                            $totalWeekly = $surveyWeekly->count() > 0 ? round((($reportWeekly->count()/$surveyWeekly->count())*100),0) : 0;

                                        @endphp
                                        <span class="fw-bolder" style="font-size: 24px;">{{$reportWeekly->count()}}</span>
                                        <span class="fw-bold text-gray-400 ms-1" style="font-size: 24px;">/</span>
                                        <span class="fw-bolder text-gray-400" style="font-size: 24px;">{{$surveyWeekly->count()}}</span>
                                    </div>
                                </div>

                                <div class="col-4" >
                                    <div id="chart2" style="height: 100px;"></div>
                                </div>

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>

            <div class="col-xl-6 col-md-12 " >

                <div class="card">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body mt-2">

                            <div class="row">

                                <div class="col-8">
                                    <div class="card-label fs-3 fw-bold text-dark">Ceklis Bulanan</div>
                                    <div class="mt-4" >
                                        @php
                                        
                                            $reportMonthly = App\Models\SOP\SurveyReport::join('surveys','survey_reports.survey_id','surveys.id')
                                                                                ->where('user_id',Auth::user()->id)
                                                                                ->where('surveys.frequency','monthly')
                                                                                ->get();

                                            $surveyMonthly = App\Models\SOP\Survey::where('frequency','monthly')
                                                                            ->where('privacy',1)
                                                                            ->get();

                                            $totalMonthly = $surveyMonthly->count() > 0 ? round((($reportMonthly->count()/$surveyMonthly->count())*100),0) : 0;

                                        @endphp
                                        <span class="fw-bolder" style="font-size: 24px;">{{$reportMonthly->count()}}</span>
                                        <span class="fw-bold text-gray-400 ms-1" style="font-size: 24px;">/</span>
                                        <span class="fw-bolder text-gray-400" style="font-size: 24px;">{{$surveyMonthly->count()}}</span>
                                    </div>
                                </div>

                                <div class="col-4" >
                                    <div id="chart3" style="height: 100px;"></div>
                                </div>

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>

            <div class="col-xl-6 col-md-12 " >

                <div class="card">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body mt-2">

                            <div class="row">

                                <div class="col-8">
                                    <div class="card-label fs-3 fw-bold text-dark">Ceklis Rutin</div>
                                    <div class="mt-4" >
                                        @php
                                        
                                            $reportRoutine = App\Models\SOP\SurveyReport::join('surveys','survey_reports.survey_id','surveys.id')
                                                                                ->where('user_id',Auth::user()->id)
                                                                                ->where('surveys.frequency','routine')
                                                                                ->get();

                                            $surveyRoutine = App\Models\SOP\Survey::where('frequency','routine')
                                                                            ->where('privacy',1)
                                                                            ->get();

                                            $totalRoutine = $surveyRoutine->count() > 0 ? round((($reportRoutine->count()/$surveyRoutine->count())*100),0) : 0;

                                        @endphp
                                        <span class="fw-bolder" style="font-size: 24px;">{{$reportRoutine->count()}}</span>
                                        <span class="fw-bold text-gray-400 ms-1" style="font-size: 24px;">/</span>
                                        <span class="fw-bolder text-gray-400" style="font-size: 24px;">{{$surveyRoutine->count()}}</span>
                                    </div>
                                </div>

                                <div class="col-4" >
                                    <div id="chart4" style="height: 100px;"></div>
                                </div>

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>

        </div>

    @endif

    <!-- DASHBOARD: ADMIN -->
    @if(in_array(@\Auth::user()->role->name, ['Admin', 'Super Admin', 'Master']))

        <h2 class="pb-2 fw-bolder">User Activity</h2>
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 pb-10">

            <div class="col-xl-3 col-md-12 " >

                <div class="card" style="background: #ECE7FF;">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    @php
                                        $report = App\Models\SOP\SurveyReport::whereNotNull('ended_at')
                                                                            ->groupBy('user_id')
                                                                            ->count();

                                        $totalStaff = App\Models\ACL\User::where('role_id',4)->count();
                                        $total = $totalStaff > 0 ? ($report/$totalStaff)*100 : 0; 
                                    @endphp
                                    <div class="fw-bolder user-activity-readed-staff" style="font-size: 40px;color:black">{{round($total,2)}}%</div>
                                    <div class="card-label fs-7 fw-bold" style="color:black">Staff Sudah Baca</div>
                                </div>

                                {{-- <div class="col-4" >
                                    <div id="chart1" style="height: 100px;"></div>
                                </div> --}}

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>


            @php
                // OLD GET DATA
                // $report = App\Models\SOP\SurveyReport::join(DB::raw('(SELECT MIN(ended_at) as min_ended_at FROM survey_reports) as min_reports'),'survey_reports.ended_at','min_reports.min_ended_at')
                //                                     ->join('surveys','survey_reports.survey_id','surveys.id')
                //                                     ->whereNotNull('survey_reports.ended_at')
                //                                     ->select('survey_reports.*','surveys.published_at',DB::raw('TIMESTAMPDIFF(MINUTE, surveys.published_at, survey_reports.ended_at) as time_to_read'))
                //                                     ->groupBy('surveys.id')
                //                                     ->get();

                $report = App\Models\SOP\SurveyReport::whereNotNull('survey_reports.ended_at')
                                                    ->select(DB::raw('TIMESTAMPDIFF(MINUTE, survey_reports.started_at, survey_reports.ended_at) as time_to_read'))
                                                    ->groupBy('survey_id')
                                                    ->get();
            @endphp
            <div class="col-xl-3 col-md-12 ">

                <div class="card" style="background: #D9FFDD">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    <span class="fw-bolder user-activity-min-to-read" style="font-size: 40px;color:black">{{round((@$report->min('time_to_read') ?? 0),2)}}</span>
                                    <span class="fw-bold text-gray-400 ms-1" style="font-size: 14px;">minutes</span>
                                    <div class="card-label fs-7 fw-bold" style="color:black">Min. Time To Read</div>
                                </div>

                                {{-- <div class="col-4" >
                                    <div id="chart1" style="height: 100px;"></div>
                                </div> --}}

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>

            <div class="col-xl-3 col-md-12 " >

                <div class="card" style="background: #FFE4E6;">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    <span class="fw-bolder user-activity-avg-to-read" style="font-size: 40px;color:black">{{round((@$report->avg('time_to_read') ?? 0),2)}}</span>
                                    <span class="fw-bold text-gray-400 ms-1" style="font-size: 14px;">minutes</span>
                                    <div class="card-label fs-7 fw-bold" style="color:black">Avg. Time To Read</div>
                                </div>

                                {{-- <div class="col-4" >
                                    <div id="chart1" style="height: 100px;"></div>
                                </div> --}}

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-12 ">

                <div class="card" style="background: #DCF9FF">

                    <div id="kt_sliders_widget_1_slider" class="">

                        <!--begin::Body-->
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    @php
                                        $report = App\Models\SOP\SurveyReport::whereNotNull('ended_at')
                                                                            ->whereNotNull('outlet_id')
                                                                            ->groupBy('outlet_id')
                                                                            ->count();

                                        $totalOutlet = App\Models\Reference\Outlet::all()->count();
                                        $total = $totalOutlet > 0 ? ($report/$totalOutlet)*100 : 0; 
                                    @endphp
                                    <div class="fw-bolder user-activity-unread-outlet" style="font-size: 40px;color:black">{{round($total,2)}}%</div>
                                    {{-- <div class="fw-bolder user-activity-unread-outlet" style="font-size: 40px;color:black">40%</div> --}}
                                    <div class="card-label fs-7 fw-bold" style="color:black">Outlet yang sudah baca</div>
                                </div>

                                {{-- <div class="col-4" >
                                    <div id="chart1" style="height: 100px;"></div>
                                </div> --}}

                            </div>

                        </div>
                        <!--end::Body-->
                    </div>

                </div>

            </div>
        </div>
        <!--end::Row-->

        <h2 class="pb-2 fw-bolder">Outlet - Net Promoter Score</h2>
        @component(config('theme.components').'.filter',['name' => 'outlet_summary_filter','buttonLocation' => '#outlet_summary_card .card-toolbar'])

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

        @endcomponent


        @component(config('theme.components').'.card',['name' => 'outlet_summary_card'])
            {!!
                DatatableBuilderHelper::render(route('nps.outlet-summary'), [
                    'columns' => [
                        'nama_outlet','outlet_score'
                    ],
                    'pluginOptions' => [
                        'columnDefs' => [
                            // ['targets' => 0,'width' => '10px'],
                            // ['targets' => 3,'className' => 'text-center']
                        ],
                    ],
                    'elOptions' => [
                        'id' => 'outlet_summary_table',
                    ],
                    'toolbarLocation' => '#outlet_summary_card .card-toolbar',
                    'titleLocation' => '#outlet_summary_card .card-title',
                    'filter_form' => 'outlet_summary_filter',
                    // 'create' => [
                    //     'modal' => 'modal_form_survey'
                    // ],
                    // 'export' => [
                    //     'url' => route('sop.export'),
                    //     'title' => 'NPS'
                    // ],
                    // 'import' => [
                    //     'url' => route('sop.import'),
                    //     'template' => route('sop.download-template'),
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

    @endif


@endsection

@push('additional-js')

<script>

    var root, root2, root3, root4;

    $(document).ready(function(){
        initPieChart(KTThemeMode.getMode());
        initPieChart2(KTThemeMode.getMode());
        initPieChart3(KTThemeMode.getMode());
        initPieChart4(KTThemeMode.getMode());
    })

    function initPieChart(mode = 'light') {

        root = am5.Root.new("chart1");


          root.setThemes([
            am5themes_Animated.new(root)
          ]);

          var chart = root.container.children.push( 
            am5percent.PieChart.new(root, {
              layout: root.horizontalLayout,
              radius: am5.percent(90),
              innerRadius: am5.percent(70)
            }) 
          );

          // Define data
          var data = [{
            label: "Dikerjakan",
            value: {{(@$totalDaily ?? 0)}}
          }, {
            label: "Belum Dikerjakan",
            value: {{100-(@$totalDaily ?? 0)}}
          }];

          // Create series
          var series = chart.series.push(
            am5percent.PieSeries.new(root, {
              valueField: "value",
              categoryField: "label"
            })
          );

          series.labels.template.set("forceHidden", true);
          series.ticks.template.set("forceHidden", true);

          if(mode == 'dark'){
            series.get('colors').set('colors', [am5.color('#7239EA'), am5.color('#d0bff4')])
          }else{
            series.get('colors').set('colors', [am5.color('#7239EA'), am5.color('#f2edff')])
          }

          var label = series.children.push(am5.Label.new(root, {
            text: "{{(@$totalDaily ?? 0)}}%",
            fontSize: 20,
            centerX: am5.percent(50),
            centerY: am5.percent(50),
            populateText: true,
            fill: (mode == 'dark' ? am5.color('#fff') : am5.color('#000'))
          }));

          series.data.setAll(data);
          series.onPrivate("valueSum", function(){
            label.text.markDirtyText();
          })

          series.appear(1000, 100);

    }

    function initPieChart2(mode = 'light') {

        root2 = am5.Root.new("chart2");

          root2.setThemes([
            am5themes_Animated.new(root2)
          ]);

          var chart = root2.container.children.push( 
            am5percent.PieChart.new(root2, {
              layout: root2.horizontalLayout,
              radius: am5.percent(90),
              innerRadius: am5.percent(70)
            }) 
          );

          // Define data
          var data = [{
            label: "Dikerjakan",
            value: {{(@$totalWeekly ?? 0)}}
          }, {
            label: "Belum Dikerjakan",
            value: {{100-(@$totalWeekly ?? 0)}}
          }];

          // Create series
          var series = chart.series.push(
            am5percent.PieSeries.new(root2, {
              valueField: "value",
              categoryField: "label"
            })
          );

          series.labels.template.set("forceHidden", true);
          series.ticks.template.set("forceHidden", true);

          if(mode == 'dark'){
            series.get('colors').set('colors', [am5.color('#44E154'), am5.color('#a9e8af')])
          }else{
            series.get('colors').set('colors', [am5.color('#44E154'), am5.color('#eafcec')])
          }

          var label = series.children.push(am5.Label.new(root2, {
            text: "{{(@$totalWeekly ?? 0)}}%",
            fontSize: 20,
            centerX: am5.percent(50),
            centerY: am5.percent(50),
            populateText: true,
            fill: (mode == 'dark' ? am5.color('#fff') : am5.color('#000'))
          }));

          series.data.setAll(data);
          series.onPrivate("valueSum", function(){
            label.text.markDirtyText();
          })

          series.appear(1000, 100);

    }

    function initPieChart3(mode = 'light') {

        root3 = am5.Root.new("chart3");

          root3.setThemes([
            am5themes_Animated.new(root3)
          ]);

          var chart = root3.container.children.push( 
            am5percent.PieChart.new(root3, {
              layout: root3.horizontalLayout,
              radius: am5.percent(90),
              innerRadius: am5.percent(70)
            }) 
          );

          // Define data
          var data = [{
            label: "Dikerjakan",
            value: {{(@$totalMonthly ?? 0)}}
          }, {
            label: "Belum Dikerjakan",
            value: {{100-(@$totalMonthly ?? 0)}}
          }];

          // Create series
          var series = chart.series.push(
            am5percent.PieSeries.new(root3, {
              valueField: "value",
              categoryField: "label"
            })
          );

          series.labels.template.set("forceHidden", true);
          series.ticks.template.set("forceHidden", true);

          if(mode == 'dark'){
            series.get('colors').set('colors', [am5.color('#E1444D'), am5.color('#ed9ca0')])
          }else{
            series.get('colors').set('colors', [am5.color('#E1444D'), am5.color('#fceaeb')])
          }

          var label = series.children.push(am5.Label.new(root3, {
            text: "{{(@$totalMonthly ?? 0)}}%",
            fontSize: 20,
            centerX: am5.percent(50),
            centerY: am5.percent(50),
            populateText: true,
            fill: (mode == 'dark' ? am5.color('#fff') : am5.color('#000'))
          }));

          series.data.setAll(data);
          series.onPrivate("valueSum", function(){
            label.text.markDirtyText();
          })

          series.appear(1000, 100);

    }

    function initPieChart4(mode = 'light') {

        root4 = am5.Root.new("chart4");

          root4.setThemes([
            am5themes_Animated.new(root4)
          ]);

          var chart = root4.container.children.push( 
            am5percent.PieChart.new(root4, {
              layout: root4.horizontalLayout,
              radius: am5.percent(90),
              innerRadius: am5.percent(70)
            }) 
          );

          // Define data
          var data = [{
            label: "Dikerjakan",
            value: {{(@$totalRoutine ?? 0)}}
          }, {
            label: "Belum Dikerjakan",
            value: {{100-(@$totalRoutine ?? 0)}}
          }];

          // Create series
          var series = chart.series.push(
            am5percent.PieSeries.new(root4, {
              valueField: "value",
              categoryField: "label"
            })
          );

          series.labels.template.set("forceHidden", true);
          series.ticks.template.set("forceHidden", true);

          if(mode == 'dark'){
            series.get('colors').set('colors', [am5.color('#0FB5DA'), am5.color('#80dff2')])
          }else{
            series.get('colors').set('colors', [am5.color('#0FB5DA'), am5.color('#e8f9fc')])
          }

          var label = series.children.push(am5.Label.new(root4, {
            text: "{{(@$totalRoutine ?? 0)}}%",
            fontSize: 20,
            centerX: am5.percent(50),
            centerY: am5.percent(50),
            populateText: true,
            fill: (mode == 'dark' ? am5.color('#fff') : am5.color('#000'))
          }));

          series.data.setAll(data);
          series.onPrivate("valueSum", function(){
            label.text.markDirtyText();
          })

          series.appear(1000, 100);

    }

    KTThemeMode.on("kt.thememode.change", function() {
        root.dispose();
        root2.dispose();
        root3.dispose();
        root4.dispose();
        initPieChart(KTThemeMode.getMode())
        initPieChart2(KTThemeMode.getMode())
        initPieChart3(KTThemeMode.getMode())
        initPieChart4(KTThemeMode.getMode())
    });
</script>

@endpush