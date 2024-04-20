
//add questions
<h1>Add Question</h1>
    <form method="post" action="{{ route('question.store', ['examId' => $examId]) }}">
        @csrf
        <label for="question_text">Question:</label>
        <input type="text" name="question_text" id="question_text"><br>

        <label for="correct_answer">Correct Answer:</label>
        <input type="text" name="correct_answer" id="correct_answer"><br>

        <label for="answers">Answers:</label><br>
        <input type="text" name="answers[]" placeholder="Answer 1"><br>
        <input type="text" name="answers[]" placeholder="Answer 2"><br>
        <input type="text" name="answers[]" placeholder="Answer 3"><br>
        <!-- Add more answer fields as needed -->

        <button type="submit">Add Question</button>
    </form>