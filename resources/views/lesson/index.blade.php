

@extends('layouts.app')

@section('content')


<!-- <div class="sidebar">
    <ul class="nav nav-tabs" id="sidebarTabs" role="tablist">
        @foreach ($lessons as $lesson)
            <li class="nav-item">
                <a class="nav-link" id="tab{{ $lesson->id }}" data-toggle="tab" href="#content{{ $lesson->id }}" role="tab" aria-controls="content{{ $lesson->id }}" aria-selected="false">{{ $lesson->title }}</a>
            </li>
        @endforeach
    </ul>
</div>

<div class="content">
    <div class="tab-content" id="sidebarTabContent">
        @foreach ($lessons as $lesson)
            <div class="tab-pane fade" id="content{{ $lesson->id }}" role="tabpanel" aria-labelledby="tab{{ $lesson->id }}">
                <h3>{{ $lesson->title }}</h3>
                <p>{{ $lesson->description }}</p>
            </div>
        @endforeach
    </div>
</div> -->


<!-- <div class="sidebar">
    @foreach ($lessons as $lesson)
        <div class="sidebar-tab" data-content="#content{{ $lesson->id }}">{{ $lesson->title }}</div>
    @endforeach
</div>

<div class="content">
    @foreach ($lessons as $lesson)
        <div class="tab-content" id="content{{ $lesson->id }}">
            <h3>{{ $lesson->title }}</h3>
            <p>{{ $lesson->description }}</p>
        </div>
    @endforeach
</div> -->

<style>

.container {
    display: flex;
}

.sidebar {
    width: 200px;
    background-color: #f5f5f5;
    padding: 10px;
}

.sidebar-tab {
    margin-bottom: 10px;
    padding: 5px;
    background-color: #ddd;
    cursor: pointer;
}

.content {
    flex: 1;
    padding: 10px;
}

</style>

<div class="container">
    <div class="sidebar">
        @foreach ($lessons as $lesson)
            <div class="sidebar-tab" data-content="#content{{ $lesson->id }}">{{ $lesson->title }}</div>
            <h3 style="color: {{ $lesson->completed ? 'green' : 'black' }}">
        {{ $lesson->title }}
    </h3>
    @if ($lesson->completed && $loop->index + 1 < count($lessons))
        <a href="{{ route('lessons.show', $lessons[$loop->index + 1]->id) }}">Go to next lesson</a>
    @endif
        @endforeach
    </div>

    <div class="content">
        @foreach ($lessons as $lesson)
            <div class="tab-content" id="content{{ $lesson->id }}">
                <h3>{{ $lesson->title }}</h3>
                <p>{{ $lesson->description }}</p>
            </div>
        @endforeach
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $(".sidebar-tab").click(function() {
            var contentId = $(this).data("content");
            $(".tab-content").hide();
            $(contentId).show();
        });
    });
</script>

    @endsection