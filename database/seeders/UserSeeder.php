<?php

namespace App\Http\Controllers\Students\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Question;
use App\Models\Quizze;
use App\Models\StudentAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamsController extends Controller
{
    public function index()
    {
        try {
            $student_id = auth()->user()->id;

            $quizzes = Quizze::where('grade_id', auth()->user()->Grade_id)
                ->where('is_active', 1)
                ->where('section_id', auth()->user()->section_id)
                ->with([
                    'subject',
                    'questions',
                    'degree' => function ($query) use ($student_id) {
                        $query->where('student_id', $student_id)->latest();
                    }
                ])
                ->orderBy('id', 'DESC')
                ->get();

            $degrees = Degree::where('student_id', $student_id)
                ->with(['quizze.questions', 'student.answers'])
                ->get();

            return view('pages.Students.dashboard.exams.index', compact('quizzes', 'degrees'));
        } catch (\Exception $e) {
            \Log::error('Error loading exams: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the exams.');
        }
    }

    public function show($quizze_id)
    {
        $quiz = Quizze::findOrFail($quizze_id);
        $student_id = Auth::id();

        $total_score = Question::where('quizze_id', $quizze_id)->sum('score');

        $duration = $quiz->duration ?? 60;
        $totalQuestions = Question::where('quizze_id', $quizze_id)->count();

        $currentQuestion = Question::where('quizze_id', $quizze_id)->first();

        return view('pages.Students.dashboard.exams.show', [
            'quiz' => $quiz,
            'quizze_id' => $quizze_id,
            'student_id' => $student_id,
            'duration' => $duration,
            'total_score' => $total_score,
            'totalQuestions' => $totalQuestions,
            'currentQuestion' => $currentQuestion,
            'currentQuestionNumber' => 1,
            'timeRemaining' => $duration * 60
        ]);
    }

    public function startExam($quizze_id)
    {
        try {
            $student_id = Auth::id();

            // Check if student has already taken this quiz
            $existingDegree = Degree::where('student_id', $student_id)
                ->where('quizze_id', $quizze_id)
                ->exists();

            if ($existingDegree) {
                return redirect()
                    ->route('student_exams.index')
                    ->with('error', 'You have already taken this exam.');
            }

            return redirect()->route('quiz.question', ['quizze_id' => $quizze_id]);
        } catch (\Exception $e) {
            \Log::error('Error starting exam: ' . $e->getMessage());
            return redirect()
                ->route('student_exams.index')
                ->with('error', 'An error occurred while starting the exam.');
        }
    }

    public function showQuestion($quizze_id)
    {
        try {
            $quiz = Quizze::findOrFail($quizze_id);
            $student_id = Auth::id();

            $currentQuestion = Question::where('quizze_id', $quizze_id)
                ->orderBy('id', 'asc')
                ->first();

            if (!$currentQuestion) {
                return redirect()
                    ->route('student_exams.index')
                    ->with('error', 'No questions found for this quiz.');
            }

            $total_score = Question::where('quizze_id', $quizze_id)->sum('score');
            $totalQuestions = Question::where('quizze_id', $quizze_id)->count();
            $duration = $quiz->duration ?? 60;

            return view('pages.Students.dashboard.exams.show', [
                'quiz' => $quiz,
                'quizze_id' => $quizze_id,
                'student_id' => $student_id,
                'duration' => $duration,
                'total_score' => $total_score,
                'totalQuestions' => $totalQuestions,
                'currentQuestion' => $currentQuestion,
                'currentQuestionNumber' => 1,
                'timeRemaining' => $duration * 60
            ]);
        } catch (\Exception $e) {
            \Log::error('Error showing question: ' . $e->getMessage());
            return redirect()
                ->route('student_exams.index')
                ->with('error', 'An error occurred while loading the quiz.');
        }
    }

//   public function selectAnswer(Request $request)
// {
//     try {
//         $validatedData = $request->validate([
//             'question_id' => 'required|exists:questions,id',
//             'answer' => 'required|string'
//         ]);

//         $student_id = Auth::id();
//         $question = Question::findOrFail($validatedData['question_id']);

//         $studentAnswer = StudentAnswer::updateOrCreate(
//             [
//                 'student_id' => $student_id,
//                 'question_id' => $question->id,
//                 'quiz_id' => $question->quizze_id
//             ],
//             [
//                 'selected_answer' => $validatedData['answer'],
//                 'is_correct' => $validatedData['answer'] === $question->right_answer
//             ]
//         );

//         return response()->json([
//             'success' => true,
//             'is_correct' => $studentAnswer->is_correct,
//             'answer_id' => $studentAnswer->id
//         ]);
//     } catch (\Exception $e) {
//         \Log::error('Error saving answer: ' . $e->getMessage());
//         return response()->json(['success' => false, 'message' => 'Failed to save answer'], 500);
//     }
// }
// public function selectAnswer(Request $request)
// {
//     try {
//         $validatedData = $request->validate([
//             'question_id' => 'required|exists:questions,id',
//             'answer' => 'required|string'
//         ]);

//         $student_id = Auth::id();
//         $question = Question::findOrFail($validatedData['question_id']);
        
//         // Determine if the selected answer is correct by comparing with the right_answer field
//         $isCorrect = false;
        
//         if (strpos($question->right_answer, 'answer_') === 0) {
//             // Get the field name from right_answer
//             $rightAnswerField = $question->right_answer;
            
//             // Check if it's an image field
//             $isImageField = strpos($rightAnswerField, 'image') !== false;
            
//             if ($isImageField) {
//                 // For image answers
//                 $isCorrect = ($validatedData['answer'] === $question->$rightAnswerField);
//             } else {
//                 // For text answers - compare with the text value
//                 $isCorrect = ($validatedData['answer'] === $question->$rightAnswerField);
//             }
//         }

//         $studentAnswer = StudentAnswer::updateOrCreate(
//             [
//                 'student_id' => $student_id,
//                 'question_id' => $question->id,
//                 'quiz_id' => $question->quizze_id
//             ],
//             [
//                 'selected_answer' => $validatedData['answer'],
//                 'is_correct' => $isCorrect
//             ]
//         );

//         return response()->json([
//             'success' => true,
//             'is_correct' => $studentAnswer->is_correct,
//             'answer_id' => $studentAnswer->id
//         ]);
//     } catch (\Exception $e) {
//         \Log::error('Error saving answer: ' . $e->getMessage());
//         return response()->json(['success' => false, 'message' => 'Failed to save answer'], 500);
//     }
// }


    public function selectAnswer(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'question_id' => 'required|exists:questions,id',
                'answer' => 'required|string'
            ]);

            $student_id = Auth::id();
            $question = Question::findOrFail($validatedData['question_id']);
            
            // Determine if the selected answer is correct
            $isCorrect = false;
            
            // Check if right_answer is a field name (like answer_1 or answer_image_4)
            if (strpos($question->right_answer, 'answer_') === 0) {
                // For image-based answers (format: answer_image_X)
                if (strpos($question->right_answer, 'image') !== false) {
                    // Compare with the image path
                    $isCorrect = ($validatedData['answer'] === $question->{$question->right_answer});
                } 
                // For text-based answers (format: answer_X)
                else {
                    $isCorrect = ($validatedData['answer'] === $question->{$question->right_answer});
                }
            }

            $studentAnswer = StudentAnswer::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'question_id' => $question->id,
                    'quiz_id' => $question->quizze_id
                ],
                [
                    'selected_answer' => $validatedData['answer'],
                    'is_correct' => $isCorrect
                ]
            );

            return response()->json([
                'success' => true,
                'is_correct' => $studentAnswer->is_correct,
                'answer_id' => $studentAnswer->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Error saving answer: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save answer'], 500);
        }
    }

//  public function finishExam(Request $request, $quizze_id)
// {
//     try {
//         DB::beginTransaction();

//         $student_id = Auth::id();
//         $quiz = Quizze::findOrFail($quizze_id);

//         // Get all questions and student answers with debug logging
//         $questions = Question::where('quizze_id', $quizze_id)->get();
//         \Log::info('Questions found:', ['count' => $questions->count(), 'ids' => $questions->pluck('id')]);

//         // Debug the query before execution
//         $query = StudentAnswer::where('student_id', $student_id)
//             ->where('quiz_id', $quizze_id);
//         \Log::info('Student Answers Query:', [
//             'sql' => $query->toSql(),
//             'bindings' => $query->getBindings()
//         ]);

//         $studentAnswers = $query->get();
//         \Log::info('Student Answers found:', [
//             'count' => $studentAnswers->count(),
//             'data' => $studentAnswers->map(function($answer) {
//                 return [
//                     'id' => $answer->id,
//                     'question_id' => $answer->question_id,
//                     'quiz_id' => $answer->quiz_id,
//                     'selected_answer' => $answer->selected_answer
//                 ];
//             })
//         ]);
//         //   dd($studentAnswers);

//         $totalScore = 0;
//         $detailedAnswers = [];

//         // Calculate score for each question with debug info
//         foreach ($questions as $question) {
//             $studentAnswer = $studentAnswers->where('question_id', $question->id)->first();
            
//             \Log::info('Processing question:', [
//                 'question_id' => $question->id,
//                 'found_answer' => $studentAnswer ? true : false,
//                 'answer_data' => $studentAnswer ? [
//                     'id' => $studentAnswer->id,
//                     'selected_answer' => $studentAnswer->selected_answer,
//                     'is_correct' => $studentAnswer->is_correct
//                 ] : null
//             ]);

//             $isCorrect = false;
//             $selectedAnswer = 'Not answered';

//             if ($studentAnswer) {
//                 $selectedAnswer = $studentAnswer->selected_answer;
//                 $isCorrect = $studentAnswer->is_correct;

//                 if ($isCorrect) {
//                     $totalScore += $question->score;
//                 }
//             }

//             $detailedAnswers[] = [
//                 'question_id' => $question->id,
//                 'selected_answer' => $selectedAnswer,
//                 'correct_answer' => $question->right_answer,
//                 'is_correct' => $isCorrect,
//                 'score' => $isCorrect ? $question->score : 0
//             ];
//         }

//         \Log::info('Final calculation:', [
//             'total_score' => $totalScore,
//             'detailed_answers_count' => count($detailedAnswers)
//         ]);

//         // Save the final result
//         $degree = new Degree();
//         $degree->quizze_id = $quizze_id;
//         $degree->student_id = $student_id;
//         $degree->score = $totalScore;
//         $degree->student_answer = json_encode($detailedAnswers);
//         $degree->date = Carbon::now();
//         $degree->save();

//         DB::commit();

//         toastr()->success("تم انهاء الاختبار. درجتك: {$totalScore}");
//         return redirect()->route('student_exams.index');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         \Log::error('Error finishing exam: ' . $e->getMessage());
//         \Log::error('Error trace: ' . $e->getTraceAsString());

//         toastr()->error('حدث خطأ أثناء حفظ نتائج الاختبار. يرجى المحاولة مرة أخرى.');
//         return redirect()->route('student_exams.index');
//     }
// }
// public function finishExam(Request $request, $quizze_id)
// {
//     try {
//         DB::beginTransaction();
//         $student_id = Auth::id();
//         $quiz = Quizze::findOrFail($quizze_id);
        
//         // Get all questions and student answers with debug logging
//         $questions = Question::where('quizze_id', $quizze_id)->get();
//         \Log::info('Questions found:', ['count' => $questions->count(), 'ids' => $questions->pluck('id')]);
        
//         // Debug the query before execution
//         $query = StudentAnswer::where('student_id', $student_id)
//             ->where('quiz_id', $quizze_id);
//         \Log::info('Student Answers Query:', [
//             'sql' => $query->toSql(),
//             'bindings' => $query->getBindings()
//         ]);
        
//         $studentAnswers = $query->get();
//         \Log::info('Student Answers found:', [
//             'count' => $studentAnswers->count(),
//             'data' => $studentAnswers->map(function($answer) {
//                 return [
//                     'id' => $answer->id,
//                     'question_id' => $answer->question_id,
//                     'quiz_id' => $answer->quiz_id,
//                     'selected_answer' => $answer->selected_answer
//                 ];
//             })
//         ]);
        
//         $totalScore = 0;
//         $detailedAnswers = [];
        
//         // Calculate score for each question with debug info
//         foreach ($questions as $question) {
//             $studentAnswer = $studentAnswers->where('question_id', $question->id)->first();
            
//             \Log::info('Processing question:', [
//                 'question_id' => $question->id,
//                 'found_answer' => $studentAnswer ? true : false,
//                 'answer_data' => $studentAnswer ? [
//                     'id' => $studentAnswer->id,
//                     'selected_answer' => $studentAnswer->selected_answer,
//                     'is_correct' => $studentAnswer->is_correct
//                 ] : null,
//                 'correct_answer' => $question->right_answer
//             ]);
            
//             $isCorrect = false;
//             $selectedAnswer = 'Not answered';
            
//             if ($studentAnswer) {
//                 $selectedAnswer = $studentAnswer->selected_answer;
                
//                 // Check if the student's answer matches the right answer
//                 // This direct comparison will work since both are stored in the same format
//                 if ($selectedAnswer === $question->right_answer) {
//                     $isCorrect = true;
//                     $totalScore += $question->score;
//                 }
                
//                 // Update the StudentAnswer record to reflect correct calculation
//                 $studentAnswer->is_correct = $isCorrect;
//                 $studentAnswer->save();
//             }
            
//             $detailedAnswers[] = [
//                 'question_id' => $question->id,
//                 'selected_answer' => $selectedAnswer,
//                 'correct_answer' => $question->right_answer,
//                 'is_correct' => $isCorrect,
//                 'score' => $isCorrect ? $question->score : 0
//             ];
//         }
        
//         \Log::info('Final calculation:', [
//             'total_score' => $totalScore,
//             'detailed_answers_count' => count($detailedAnswers)
//         ]);
        
//         // Save the final result
//         $degree = new Degree();
//         $degree->quizze_id = $quizze_id;
//         $degree->student_id = $student_id;
//         $degree->score = $totalScore;
//         $degree->student_answer = json_encode($detailedAnswers);
//         $degree->date = Carbon::now();
//         $degree->save();
        
//         DB::commit();
//         toastr()->success("تم انهاء الاختبار. درجتك: {$totalScore}");
//         return redirect()->route('student_exams.index');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         \Log::error('Error finishing exam: ' . $e->getMessage());
//         \Log::error('Error trace: ' . $e->getTraceAsString());
//         toastr()->error('حدث خطأ أثناء حفظ نتائج الاختبار. يرجى المحاولة مرة أخرى.');
//         return redirect()->route('student_exams.index');
//     }
// }
// public function finishExam(Request $request, $quizze_id)
// {
//     try {
//         DB::beginTransaction();
//         $student_id = Auth::id();
//         $quiz = Quizze::findOrFail($quizze_id);
        
//         // Get all questions and student answers
//         $questions = Question::where('quizze_id', $quizze_id)->get();
//         $studentAnswers = StudentAnswer::where('student_id', $student_id)
//             ->where('quiz_id', $quizze_id)
//             ->get();
        
//         $totalScore = 0;
//         $detailedAnswers = [];
        
//         // Calculate score for each question
//         foreach ($questions as $question) {
//             $studentAnswer = $studentAnswers->where('question_id', $question->id)->first();
            
//             $isCorrect = false;
//             $selectedAnswer = 'Not answered';
            
//             if ($studentAnswer) {
//                 $selectedAnswer = $studentAnswer->selected_answer;
                
//                 // The key fix is here - properly compare the student's answer with the right answer
//                 // For right_answer stored as a field name (e.g., 'answer_1', 'answer_image_2')
//                 if (strpos($question->right_answer, 'answer_') === 0) {
//                     // Extract the answer field and type
//                     $parts = explode('_', $question->right_answer);
//                     $answerNumber = end($parts);
//                     $isImage = count($parts) > 2 && $parts[1] === 'image';
                    
//                     // Determine the correct answer value based on field type
//                     $correctAnswerValue = null;
//                     if ($isImage) {
//                         // For image answers, use the path as the value for comparison
//                         $field = "answer_image_{$answerNumber}";
//                         $correctAnswerValue = $question->$field;
//                     } else {
//                         // For text answers, use the text value for comparison
//                         $field = "answer_{$answerNumber}";
//                         $correctAnswerValue = $question->$field;
//                     }
                    
//                     // Now compare the student's selected answer with the correct value
//                     $isCorrect = ($selectedAnswer === $correctAnswerValue);
//                 }
                
//                 // Update the StudentAnswer record with the corrected is_correct value
//                 $studentAnswer->is_correct = $isCorrect;
//                 $studentAnswer->save();
                
//                 if ($isCorrect) {
//                     $totalScore += $question->score;
//                 }
//             }
            
//             // Get the correct answer text/image for the record
//             $correctAnswer = null;
//             if (strpos($question->right_answer, 'answer_') === 0) {
//                 $correctAnswer = $question->{$question->right_answer};
                
//                 // If it's an image field and null, check the corresponding image field
//                 if ($correctAnswer === null && strpos($question->right_answer, 'image') === false) {
//                     $imageField = $question->right_answer . '_image';
//                     $correctAnswer = $question->$imageField ? $imageField : null;
//                 }
//             }
            
//             $detailedAnswers[] = [
//                 'question_id' => $question->id,
//                 'selected_answer' => $selectedAnswer,
//                 'correct_answer' => $correctAnswer ?? $question->right_answer,
//                 'is_correct' => $isCorrect,
//                 'score' => $isCorrect ? $question->score : 0
//             ];
//         }
        
//         // Save the final result
//         $degree = new Degree();
//         $degree->quizze_id = $quizze_id;
//         $degree->student_id = $student_id;
//         $degree->score = $totalScore;
//         $degree->student_answer = json_encode($detailedAnswers);
//         $degree->date = Carbon::now();
//         $degree->save();
        
//         DB::commit();
//         toastr()->success("تم انهاء الاختبار. درجتك: {$totalScore}");
//         return redirect()->route('student_exams.index');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         \Log::error('Error finishing exam: ' . $e->getMessage());
//         \Log::error('Error trace: ' . $e->getTraceAsString());
//         toastr()->error('حدث خطأ أثناء حفظ نتائج الاختبار. يرجى المحاولة مرة أخرى.');
//         return redirect()->route('student_exams.index');
//     }
// }

    public function finishExam(Request $request, $quizze_id)
    {
        try {
            DB::beginTransaction();
            $student_id = Auth::id();
            $quiz = Quizze::findOrFail($quizze_id);
            
            // Get all questions and student answers
            $questions = Question::where('quizze_id', $quizze_id)->get();
            $studentAnswers = StudentAnswer::where('student_id', $student_id)
                ->where('quiz_id', $quizze_id)
                ->get();
            
            $totalScore = 0;
            $detailedAnswers = [];
            
            // Calculate score for each question
            foreach ($questions as $question) {
                $studentAnswer = $studentAnswers->where('question_id', $question->id)->first();
                
                $isCorrect = false;
                $selectedAnswer = 'Not answered';
                
                if ($studentAnswer) {
                    $selectedAnswer = $studentAnswer->selected_answer;
                    
                    // Handle different right_answer formats
                    if (strpos($question->right_answer, 'answer_') === 0) {
                        // Get the field name from right_answer (e.g., answer_1, answer_image_2)
                        $rightAnswerField = $question->right_answer;
                        
                        // Check if it's an image answer
                        $isImageAnswer = strpos($rightAnswerField, 'image') !== false;
                        
                        if ($isImageAnswer) {
                            // For image answers, compare with the image path
                            $correctValue = $question->$rightAnswerField;
                            $isCorrect = ($selectedAnswer === $correctValue);
                        } else {
                            // For text answers, compare with the text value
                            $correctValue = $question->$rightAnswerField;
                            $isCorrect = ($selectedAnswer === $correctValue);
                        }
                        
                        // Update the StudentAnswer record
                        $studentAnswer->is_correct = $isCorrect;
                        $studentAnswer->save();
                    }
                    
                    if ($isCorrect) {
                        $totalScore += $question->score;
                    }
                }
                
                // Get the correct answer value for the record
                $correctAnswerValue = null;
                if (strpos($question->right_answer, 'answer_') === 0) {
                    $correctAnswerValue = $question->{$question->right_answer};
                }
                
                $detailedAnswers[] = [
                    'question_id' => $question->id,
                    'selected_answer' => $selectedAnswer,
                    'correct_answer' => $correctAnswerValue ?? $question->right_answer,
                    'is_correct' => $isCorrect,
                    'score' => $isCorrect ? $question->score : 0
                ];
            }
            
            // Save the final result
            $degree = new Degree();
            $degree->quizze_id = $quizze_id;
            $degree->student_id = $student_id;
            $degree->score = $totalScore;
            $degree->student_answer = json_encode($detailedAnswers);
            $degree->date = Carbon::now();
            $degree->save();
            
            DB::commit();
            toastr()->success("تم انهاء الاختبار. درجتك: {$totalScore}");
            return redirect()->route('student_exams.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error finishing exam: ' . $e->getMessage());
            \Log::error('Error trace: ' . $e->getTraceAsString());
            toastr()->error('حدث خطأ أثناء حفظ نتائج الاختبار. يرجى المحاولة مرة أخرى.');
            return redirect()->route('student_exams.index');
        }
    }

    public function ajaxNavigate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'quizze_id' => 'required|exists:quizzes,id',
                'current_question_id' => 'required|exists:questions,id',
                'direction' => 'required|in:next,prev'
            ]);

            $query = Question::where('quizze_id', $validatedData['quizze_id']);

            if ($validatedData['direction'] === 'next') {
                $nextQuestion = $query
                    ->where('id', '>', $validatedData['current_question_id'])
                    ->orderBy('id', 'asc')
                    ->first();
            } else {
                $nextQuestion = $query
                    ->where('id', '<', $validatedData['current_question_id'])
                    ->orderBy('id', 'desc')
                    ->first();
            }

            if (!$nextQuestion) {
                return response()->json(['error' => 'No more questions'], 404);
            }

            $questionNumber = Question::where('quizze_id', $validatedData['quizze_id'])
                ->where('id', '<=', $nextQuestion->id)
                ->count();

            $previousAnswer = StudentAnswer::where('student_id', Auth::id())
                ->where('question_id', $nextQuestion->id)
                ->first();

            $questionHtml = view('pages.Students.dashboard.exams.quiz', [
                'question' => $nextQuestion,
                'previousAnswer' => $previousAnswer ? $previousAnswer->selected_answer : null
            ])->render();

            return response()->json([
                'questionHtml' => $questionHtml,
                'questionId' => $nextQuestion->id,
                'questionNumber' => $questionNumber,
                'previousAnswer' => $previousAnswer ? $previousAnswer->selected_answer : null
            ]);
        } catch (\Exception $e) {
            \Log::error('Error navigating questions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load question'], 500);
        }
    }
}
