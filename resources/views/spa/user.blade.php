@extends('layouts.spa')

@section('content')
@include('spa.fragments.user-navBar')
@include('spa.fragments.user-asideBar')

<div id="spa-content">
    <p>Memuat…</p>
</div>
<div class="bottom-space"></div>
@include('spa.fragments.user-navBottom')

{{-- Toast container for schedule notifications --}}
<div id="toast-container"></div>
@endsection
