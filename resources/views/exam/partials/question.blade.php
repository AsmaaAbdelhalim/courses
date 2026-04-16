<div class="card mb-3 question-card" data-id="{{ $question->id }}">

    <div class="card-body">

        <h5>{{ $question->question }}</h5>

        <ul>
            @foreach($question->answers as $answer)
                <li>
                    {{ $answer->answer }}

                    @if($answer->correct)
                        <span class="badge bg-success">Correct</span>
                    @endif
                </li>
            @endforeach
        </ul>

        <button class="btn btn-sm btn-warning edit-question-btn"
                data-id="{{ $question->id }}">
            Edit
        </button>

        <button class="btn btn-sm btn-danger delete-question-btn"
                data-id="{{ $question->id }}">
            Delete
        </button>

    </div>

</div>

<div class="card mb-3 shadow-sm question-card" data-id="{{ $question->id }}" style="border-left: 4px solid #007bff;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 text-dark font-weight-bold">{{ $question->question }}</h5>
            <div>
                <button class="btn btn-sm btn-outline-warning edit-question-btn" data-id="{{ $question->id }}">
                   <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-danger delete-question-btn" data-id="{{ $question->id }}">
                   <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>

        <div class="row">
            @foreach($question->answers as $answer)
                <div class="col-md-6 mb-2">
                    <div class="p-2 rounded border {{ $answer->correct ? 'bg-light-success border-success' : 'bg-light' }}">
                        @if($answer->correct)
                            <span class="badge bg-success text-white mr-1">✓ Correct</span>
                        @else
                            <span class="badge bg-secondary text-white mr-1">✕</span>
                        @endif
                        <span class="{{ $answer->correct ? 'font-weight-bold text-success' : 'text-muted' }}">
                            {{ $answer->answer }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .bg-light-success { background-color: #e6ffed; }
    .question-card { transition: transform 0.2s; }
    .question-card:hover { transform: scale(1.01); }
</style>