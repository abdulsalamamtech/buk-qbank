<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exam Questions</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.6; }
        .question { margin-bottom: 20px; }
        .options { margin-left: 20px; }
        .title { text-align: center; font-weight: bold; font-size: 22px; margin-bottom: 40px; }
    </style>
</head>
<body>
    <div class="title">Examination Questions</div>

    @foreach($questions as $index => $q)
        <div class="question">
            <strong>Q{{ $index + 1 }}.</strong> {{ $q->question_text }}
            <div class="options">
                <p>A. {{ $q->option_a }}</p>
                <p>B. {{ $q->option_b }}</p>
                <p>C. {{ $q->option_c }}</p>
                <p>D. {{ $q->option_d }}</p>
            </div>
        </div>
    @endforeach
</body>
</html>
