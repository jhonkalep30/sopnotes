@php
	$title = $title ?? ucwords(str_replace('_', ' ', $table));
@endphp

<div class="modal fade" tabindex="-1" id="{{$table}}_modal_job_trace">
    <div class="modal-dialog modal-xl 'modal-dialog-centered'">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="fw-bold">{{$title}} Queue List</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body" style="max-height: 68vh; overflow-y: scroll;">
                {!!
                    DatatableBuilderHelper::render(route('job-trace.datatable'), [
                        'columns' => ['status','title','requested_by','requested_at','finished_at','size',
                            ['attribute' => 'action','label' => '']
                        ],
                        'filters' => [
                            'model' => $model,
                        ],
                        'pluginOptions' => [
                            'ordering' => false,
                            'searching' => false,
                        ],
                        'elOptions' => [
                            'id' => $table.'_job_trace',
                        ],
                    ])
                !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-active-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-primary" onclick="dataTableFullReload_{{$table}}_job_trace(); dataTableReload_{{$table}}();">Refresh</button>
            </div>
        </div>
    </div>
</div>