# QuestionBank

## USERS0

-   name
-   email
-   password
-   role (hod,lecturer)
-   created_by (the user id)

## ASSETS

-   name
-   url
-   type (image)

## DEPARTMENTS

-   name (Computer Science,Information Technology, Cyber Security, Software Engineer)
-   created_by

## COURSES

-   title (Human Computer)
-   code (CST1301)
-   level (100)
-   department_id (from above)
-   created_by (the user id from backend)

## QUESTIONS

-   course_id
-   type (essay,boolean(true/false),(multiple)multi-choice) [only objective and theory]
-   question
-   answer
-   options[] array from 0 to 4
-   status (pending, approved, rejected)
-   asset_id
-   created_by (the user id)
-   approved_by (the user id)

## GENERATED_QUESTIONS

-   question_type (Test,Exam)
-   year (2021/2022)
-   course_id (SWE1309)
-   level (100, 200, 300, 400)
-   semester (first or second)
-   objective_instruction (none)
-   objective_total (1, 20, 30, 50, 100)
-   objective_questions [] (from backend)
-   theory_instruction (none)
-   theory_total (1, 3, 4, 5)
-   theory_questions [] (from backend)
-   created_by (the user id)

## DOWNLOAD, PRINT, EXPORT, GENERATE [PDF]
