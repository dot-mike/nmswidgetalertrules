@extends('nmswidgetalertrules::includes.pluginadmin')

@section('title', 'Widget Alert Rules Plugin')

@section('content2')

<div class="row">
    @if ($errors->any())
    <div class="text-red-500 text-sm mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-md-12">
        <h3>About the plugin</h3>
        <p>
            This plugin adds a widget to the dashboard that displays the alert rules and their current status.
        </p>
        <p>
            <strong>Version:</strong> {{ $nmswidgetalertrules_version }}
        </p>
    </div>


</div>

@endsection