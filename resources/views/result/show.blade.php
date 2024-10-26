<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f8f8;
            padding: 20px;
            margin: 0;
        }
        .certificate {
            border: 5px solid #4CAF50;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: auto;
            page-break-after: always; /* Ensure proper pagination when printing */
        }
        h1 {
            color: #4CAF50;
        }
        .details {
            margin-top: 20px;
        }
        .score {
            font-size: 20px;
            margin: 15px 0;
        }
        .date {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Certificate of Completion</h1>
        <h2>This certificate</h2>
        <h1>{{ $user->first_name }}
            {{ $user->last_name }}</h1>
        <h2>has successfully completed the exam:</h2>
        <h2>{{ $exam->title }}</h2>
        <h2>for the course:</h2>
        <h3>{{ $course->name }}</h3>
        <h2>code</h2>
        <h4>{{ $result->id }}</h4>
        <div class="details">
            <div class="score">Score: {{ number_format($result->score, 2) }}%</div>
            <div class="date">Date of Completion: {{ $result->created_at->format('F j, Y') }}</div>
        </div>
        <p>Congratulations on your achievement!</p>
    </div>
    <div>
        <button onclick="window.print()">Print Certificate</button>
        <button onclick="window.open('http://127.0.0.1:8000/result/{{ $result->id }}', '_blank')">Download Certificate</button>

    </div>
</body>
</html>