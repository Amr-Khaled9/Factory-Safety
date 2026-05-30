@extends('layouts.app')

@section('title', 'Detections')

@section('content')

<livewire:detection-search />

<script src="{{ asset('js/detections.js') }}"></script>

@endsection