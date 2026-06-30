@extends('layouts.app')

@section('title', 'Detections')

@section('content')

<livewire:fire-log-search />

<script src="{{ asset('js/detections.js') }}"></script>

@endsection