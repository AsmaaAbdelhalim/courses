<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Completion</title>
    <style>
        body {
          
            font-family: 'Segoe UI', sans-serif;
        }

        .certificate {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            border: 10px solid #d4af37;
            background-color: #fff;
            text-align: center;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 15px;
        }

        .certificate .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 20px;
        }

        .certificate .subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .certificate .name {
            font-size: 2rem;
            font-weight: 600;
            color: #495057;
            margin: 20px 0;
        }

        .certificate .course {
            font-size: 1.5rem;
            font-weight: 500;
            color: #343a40;
            margin-bottom: 20px;
        }

        .score-info {
            font-size: 1rem;
            color: #6c757d;
            margin: 25px 0;
        }

        .footer-table {
            width: 100%;
            margin-top: 50px;
        }

        .footer-table .sig-cell {
            text-align: center;
            vertical-align: bottom;
        }

        .footer-table .line {
            border-top: 2px solid #343a40;
            margin-bottom: 5px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .code {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    @if($result->passed)
    <div class="certificate">
        <div class="title">Certificate of Completion</div>

        <div class="subtitle">This certificate is proudly presented to</div>
        <div class="name">{{ $user->first_name }} {{ $user->last_name }}</div>

        <div class="subtitle">For successfully completing the course</div>
        <div class="course">{{ $course->name }}</div>

        <div class="score-info">
            Exam: {{ $exam->title }} | Score: {{ $result->score }} / {{ $exam->total_grade }} ({{ round(($result->score / $exam->total_grade) * 100, 2) }}%)
        </div>

        <table class="footer-table">
            <tr>
                <td class="sig-cell">
                    <div class="line"></div>
                    <strong>Instructor</strong>
                </td>
                <td class="sig-cell">
                    <div class="line"></div>
                    <strong>Date:</strong> {{ $result->created_at->format('Y-m-d') }}
                </td>
            </tr>
        </table>

        <div class="code">Certificate Code: {{ $result->code }}</div>
    </div>
    @endif
</body>
</html>