@extends(config('theme.layouts.admin'),[
    'title' => @$title ?? 'Page Title',
    'breadcrumb' => @$breadcrumbs ?? '',
])

@section('content')


@endsection
