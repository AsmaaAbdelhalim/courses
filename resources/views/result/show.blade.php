@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-5">
                <h1>Exam Result</h1>       
                         
      
<h3>Score: {{ $result->score }} / {{ $result->exam->total_grade }}</h3>
<h3>Percentage: 
    @php
    $percentage = $result->exam->total_grade > 0
        ? round(($result->score / $result->exam->total_grade) * 100, 2)
        : 0;
    @endphp
    {{ $percentage }}%</h3>

@if($result->passed)
    <h4 style="color:green;">Passed ✅</h4>
    <a class="btn btn-primary" href="{{ route('certificate.download', $result->id) }}">
        Download Certificate
    </a>

    @include('certificate.download')

@else
    <h4 style="color:red;">Failed ❌</h4>
@endif
                </div>
                </div>
            </div>
@endsection