@extends('layouts.admin')

@section('content')

<div class="container">

    <h2>{{ $exam->title }}</h2>

    <button class="btn btn-primary mb-3" id="addQuestionBtn">
        Add Question
    </button>

    <div id="questions-list">
        @foreach($exam->questions as $question)
            @include('exam.partials.question')
        @endforeach
    </div>

</div>


<!-- Modal -->

<div class="modal fade" id="questionModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 id="modalTitle">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">

                <form id="questionForm">

                    @csrf

                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <input type="hidden" id="question_id">

                    <div class="form-group">
                        <label>Question</label>
                        <input type="text"
                               class="form-control"
                               id="question_input"
                               name="question"
                               required>
                    </div>

                    <h6>Answers</h6>

                    <div id="answers"></div> 

                    <button type="button" class="btn btn-secondary mt-2" id="addAnswer">
                        Add Answer
                    </button>

                    <br><br>

                    <button type="submit" class="btn btn-success">
                        Save
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<!-- Answer Template -->

<div id="answer-template" style="display:none">

    <div class="form-group answer-item">

        <input type="text"
               class="form-control mb-1"
               name="answers[__INDEX__][answer]"
               placeholder="Answer"
               required>

        <label>
            <input type="checkbox" name="answers[__INDEX__][correct]">
            Correct
        </label>

        <button type="button" class="btn btn-sm btn-danger remove-answer">
            Remove
        </button>

    </div>

</div>

@endsection

@section('scripts')

<script>

let answerIndex = 0

// ================= OPEN MODAL =================

$('#addQuestionBtn').click(function(){

    resetModal()

    $('#modalTitle').text('Add Question')

    addAnswerField()
    addAnswerField()

    $('#questionModal').modal('show')

})


// ================= ADD ANSWER =================

$('#addAnswer').click(function(){
    addAnswerField()
})


// ================= CREATE FIELD =================

function addAnswerField(answer = '', correct = false){

    let template = $('#answer-template').html()
    template = template.replace(/__INDEX__/g , answerIndex)

    $('#answers').append(template)

    if(answer){
        $(`input[name="answers[${answerIndex}][answer]"]`).val(answer)
    }

    if(correct){
        $(`input[name="answers[${answerIndex}][correct]"]`).prop('checked', true)
    }

    answerIndex++
}


// ================= REMOVE ANSWER =================

$(document).on('click','.remove-answer',function(){
    $(this).closest('.answer-item').remove()
})


// ================= STORE + UPDATE =================

$('#questionForm').submit(function(e){

    e.preventDefault()

    let form = $(this)

    // 🔥 مهم جدًا (حل مشكلة checkbox)
    form.find('input[type=checkbox]').each(function(){
        if($(this).is(':checked')){
            $(this).val(1)
        }else{
            $(this).prop('checked', true)
            $(this).val(0)
        }
    })

    // 🔥 تأكد فيه correct
    let hasCorrect = form.find('input[type=checkbox][value=1]').length > 0

    if(!hasCorrect){
        alert('Choose at least one correct answer')
        return
    }

    let questionId = $('#question_id').val()

    let url = questionId
        ? "{{ url('questions') }}/"+questionId
        : "{{ route('question.store') }}"

    let data = form.serialize()

    if(questionId){
        data += '&_method=PUT'
    }

    $.ajax({

        url: url,
        method: "POST",
        data: data,

        success:function(res){

            if(res.success){

                $('#questionModal').modal('hide')

                if(questionId){
                    $(`.question-card[data-id="${questionId}"]`).replaceWith(res.html)
                }else{
                    $('#questions-list').prepend(res.html)
                }

                resetModal()
            }

        },

        error:function(err){
            console.log(err.responseJSON)
            alert('Validation error')
        }

    })

})


// ================= EDIT =================

$(document).on('click','.edit-question-btn',function(){

    let id = $(this).data('id')

    $.get("{{ url('questions') }}/"+id+"/edit",function(res){

        resetModal()

        $('#modalTitle').text('Edit Question')

        $('#question_id').val(res.question.id)
        $('#question_input').val(res.question.question)

        res.question.answers.forEach(ans=>{
            addAnswerField(ans.answer, ans.correct)
        })

        $('#questionModal').modal('show')

    })

})


// ================= DELETE =================

$(document).on('click','.delete-question-btn',function(){

    if(!confirm('Delete this question?')) return

    let id = $(this).data('id')

    $.ajax({

        url: "{{ url('questions') }}/"+id,
        method: "POST",

        data:{
            _token: "{{ csrf_token() }}",
            _method: "DELETE"
        },

        success:function(res){

            if(res.success){
                $(`.question-card[data-id="${id}"]`).remove()
            }

        }

    })

})


// ================= RESET =================

function resetModal(){

    $('#questionForm')[0].reset()
    $('#answers').html('')
    $('#question_id').val('')
    answerIndex = 0

}

</script>

@endsection