@extends(config('theme.layouts.admin'),[
    'title' => 'Checklist',
    'breadcrumb' => [
        [
            'label' => 'Dashboard',
            'url' => route('dashboard')
        ],
        [
            'label' => 'SOP'
        ],
        ['label' => 'Checklist'],
    ]

])

@section('content')
    
    <ul class="nav nav-pills mb-5 fs-6">
        @php
            $i = 1;
        @endphp
        @foreach(App\Models\SOP\Survey::getFrequency() as $key => $value)
            <li class="nav-item">
                <a class="nav-link {{$i==1 ? 'active' : ''}}" data-bs-toggle="tab" href="#kt_tab_pane_{{$i}}">{{ucwords($value)}}</a>
            </li>
            @php
                $i++;
            @endphp
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @php
            $i = 1;
        @endphp
        @foreach(App\Models\SOP\Survey::getFrequency() as $key => $value)
            <div class="tab-pane fade {{$i==1 ? 'show active' : ''}}" id="kt_tab_pane_{{$i}}" role="tabpanel">
                <div class="row g-5 g-xl-8">
                    @php
                        $surveys = App\Models\SOP\Survey::where('frequency',$key)
                                                        ->where('privacy',1)
                                                        ->when(Auth::user()->jabatan_id != null,function($query){
                                                            if(@Auth::user()->jabatan->classifiers){
                                                                return $query->where(function($q){
                                                                    return $q->whereDoesntHave('classifiers')
                                                                            ->orWhereHas('classifiers',function($q2){
                                                                                $authClassifiers = Auth::user()->jabatan->classifiers->pluck('id')->toArray();
                                                                                $q2->whereIn('survey_classifiers.classifier_id',$authClassifiers);
                                                                            });
                                                                });
                                                            }
                                                        });
                    @endphp
                    @forelse($surveys->get() as $checklist)
                        <div class="col-xl-4" style="opacity:{{!$checklist->is_available ? '0.3' : '1'}}">
                            <!--begin::Statistics Widget 5-->
                            <a href="{{!$checklist->is_available ? '#' : route('checklist.fill',['id' => encrypt_id($checklist->id)])}}" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <i class="ki-duotone ki-element-11 text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>        
                                    <div class="text-white fw-bold fs-2 mb-2 mt-5">{{$checklist->name}}</div>
                                    <div class="fw-semibold text-white">{{$checklist->description ?? '-'}}</div>
                                    <div align="right">
                                        @if(@$checklist->latestReportByAuth()->started_at != null && @$checklist->latestReportByAuth()->ended_at == null)
                                        <span class="badge rounded-pill badge-danger text-white mt-5">Sedang Mengerjakan</span>
                                        @endif
                                        <span class="badge rounded-pill text-white mt-5" style="background:#844aff;">{{$checklist->card_message}}</span>
                                    </div>
                                </div>
                                <!--end::Body-->
                            </a>
                            <!--end::Statistics Widget 5-->
                        </div>
                    @empty
                    <div class="col-xl-12 text-center text-md-start mt-10">
                        {{-- No Checklist Data --}}
                        <div id="content-empty">
                            <div class="d-flex flex-column flex-center" style="height: 225px;">
                                <img src="{{ asset('images/21.png') }}" style="max-width: 175px;">
                                <div class="fs-1 fw-bolder text-dark mb-4">No data found</div>
                                <div class="fs-6">Sorry we couldn't find any data</div>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            @php
                $i++;
            @endphp
        @endforeach
    </div>
@endsection

@push('additional-js')

<script type="text/javascript">

</script>

@endpush
