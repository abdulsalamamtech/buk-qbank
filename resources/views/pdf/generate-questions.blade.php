<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Exam Questions</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        .question {
            margin-bottom: 8px;
        }

        .options {
            margin-left: 20px;
        }

        .title {
            text-align: center;
            font-weight: medium;
            font-size: 8px;
            margin-bottom: 2px;
        }

        .sub-title {
            text-align: center;
            font-weight: medium;
            font-size: 8px;
            margin-bottom: 2px;
        }
    </style>
</head>

<body>

    {{-- 'question_type',
        'year',
        'course_id',
        'level',
        'semester',

        'objective_instruction',
        'objective_total',
        'objective_questions',

        'theory_instruction',
        'theory_total',
        'theory_questions', --}}

    {{-- Title --}}
    <div class="title">
        <h1>Bayero University Kano</h1>
        <h1>Faculty of Computing</h1>
        <h1>Department of {{ Str::title($q['course']['department']['name']) }}</h1>
        <hr>
    </div>


    {{-- Sub-title --}}
    <div class="sub-title">
        <h2>{{ strtoupper($q['question_type']) }}</h2>
        <h2>Course code: {{ $q['course']['code'] }} Course title: {{ $q['course']['title'] }} </h2>
        <h2>Year: {{ $q['year'] }} Level: {{ $q['level'] }} Semester: {{ $q['semester'] }} semester</h2>
    </div>


    {{-- Objective Questions --}}
    <section>
        <h2>Section A: Objective Questions</h2>
        {{-- Objective Instruction --}}
        @if ($q['objective_instruction'])
            <p>Objective Instruction: {{ $q['objective_instruction'] }}</p>
        @endif
        {{-- variable count = 1 --}}
        @php
            $sec_a_count = 1;
        @endphp
        {{-- Section A Questions --}}
        @foreach ($section_a as $sec_a_q)
            <div class="question">

                <p>
                    <strong>{{ $sec_a_count }}.</strong>
                    {{ $sec_a_q->question }}
                </p>
                <div class="options">
                    {{-- loop options --}}
                    @foreach ($sec_a_q->options as $option)
                        <p>{{ chr(64 + $loop->iteration) }}. {{ $option }}.</p>
                    @endforeach
                </div>
            </div>
            @php $sec_a_count++; @endphp
        @endforeach
    </section>


    {{-- Theory Questions --}}
    <section>
        <h2>Section B: Theory Questions</h2>
        {{-- Theory Instruction --}}
        @if ($q['theory_instruction'])
            <p>Theory Instruction: {{ $q['theory_instruction'] }}</p>
        @endif

        {{-- variable count = 1 --}}
        @php
            $sec_b_count = 1;
        @endphp
        {{-- Section B Questions --}}
        @foreach ($section_b as $sec_b_q)
            <div class="question">
                <p>
                    <strong>{{ $sec_b_count }}.</strong>
                    {{ $sec_b_q->question }}
                </p>
            </div>
            @php $sec_b_count++; @endphp
        @endforeach
    </section>


    {{-- Footer --}}
    <footer>
        <hr>
        <p style="text-align: center; font-size: 10px;">{{ date('l, jS F Y h:i A') }}</p>
        <p style="text-align: center; font-size: 10px;">Powered by Buk FoC QBank</p>
    </footer>


</body>

</html>
