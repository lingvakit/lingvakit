<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConformityController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HomeWorkController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LessonVideoController;
use App\Http\Controllers\Admin\MediaFileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PresentationController;
use App\Http\Controllers\Admin\PresentationSlideController;
use App\Http\Controllers\Admin\QuestionOptionController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StageController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\Students\StudentCourseController;
use App\Http\Controllers\Admin\Teachers\TeacherController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PromocodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware(['auth', 'locale', 'role:superuser|admin|teacher'])->group(function (){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('articles', ArticleController::class);
    Route::put('articles/{article}/image-remove', [ArticleController::class, 'removeImage'])->name('articles.image.remove');

    Route::resource('media', MediaFileController::class);
    Route::get('media/download/file-{file}', [MediaFileController::class, 'downloadFile'])->name('media.download');
    Route::post('media/upload', [MediaFileController::class, 'ajaxStore'])->name('media.store-ajax');
    Route::get('media/{id}/get-data', [MediaFileController::class, 'getAjaxData'])->name('media.ajax.get-data');

    Route::get('files/download/file-{file}', [StudentCourseController::class, 'downloadFile'])->name('files.download');

    /* ROLES & PERMISSIONS */
    Route::resource('roles', RoleController::class)->middleware('role:superuser');
    Route::resource('permissions', PermissionController::class)->middleware('role:superuser');

    /* CATEGORIES */
    Route::resource('categories', CategoryController::class)->middleware(['role:superuser|admin']);

    /* LANGUAGES */
    Route::resource('languages', LanguageController::class)->middleware(['role:superuser|admin']);

    /* COURSES */
    Route::resource('courses', CourseController::class);

    /* Update index of topic */
    Route::put('topic/{topic}/index', [TopicController::class, 'updateIndex'])->name('topic.index');
    /* Update index of presentation */
    Route::put('slides/{slide}/index', [PresentationSlideController::class, 'updateIndex'])->name('slides.index');

    /* Show All of Courses */
    Route::get('all-courses', [CourseController::class, 'allCourses'])->middleware(['role:superuser|admin'])->name('courses.all');

    Route::prefix('courses/{course}')->group(function (){
        /* Remove Course  Media Files */
        Route::put('image-remove', [CourseController::class, 'removeImage'])->name('courses.image.remove');
        Route::put('video-remove', [CourseController::class, 'removeVideo'])->name('courses.video.remove');

        /* Stages CRUD */
        Route::post('stages/create', [StageController::class, 'store'])->name('stages.store');
        Route::put('stages/{stage}/edit', [StageController::class, 'update'])->name('stages.update');
        Route::delete('stages/{stage}', [StageController::class, 'destroy'])->name('stages.destroy');

        Route::prefix('stage-{stage}')->group(function (){
            /* Lessons */
            Route::resource('lessons', LessonController::class);
            Route::prefix('lessons/{lesson}')->group(function (){
                /* Remove Lesson Media Files */
//                Route::put('audio-remove', [LessonController::class, 'removeAudio'])->name('lessons.audio.remove');
                Route::delete('audio-remove/{audio}', [LessonController::class, 'removeAudio'])->name('lessons.audio.remove');
                Route::put('image-remove', [LessonController::class, 'removeImage'])->name('lessons.image.remove');
                Route::put('video-remove', [LessonController::class, 'removeVideo'])->name('lessons.video.remove');
                Route::put('file-remove/{file}', [LessonController::class, 'removeFile'])->name('lessons.file.remove');

                Route::get('detach-video/{video}', [LessonVideoController::class, 'detachVideo'])->name('lessons.video.detach');

                /* Presentations */
                Route::resource('presentations', PresentationController::class);

                /* Additional video */
                Route::get('video/attach', [LessonVideoController::class, 'attachVideoView'])->name('lessons.video.form');
                Route::post('video/attach', [LessonVideoController::class, 'attachVideo'])->name('lessons.video.attach');

                /* Home Works */
                Route::get('home-works/create', [HomeWorkController::class, 'create'])->name('lesson.home-works.create');
                Route::post('home-works/create', [HomeWorkController::class, 'store'])->name('lesson.home-works.store');
                Route::get('home-works/{homeWork}/edit', [HomeWorkController::class, 'edit'])->name('lesson.home-works.edit');
                Route::post('home-works/{homeWork}/edit', [HomeWorkController::class, 'update'])->name('lesson.home-works.update');
            });

            Route::resource('quizzes', QuizController::class); // Quizzes
            Route::prefix('quizzes/{quiz}')->group(function (){

                /* Remove Quiz Media Files */
                Route::put('audio-remove', [QuizController::class, 'removeAudio'])->name('quizzes.audio.remove');
                Route::put('image-remove', [QuizController::class, 'removeImage'])->name('quizzes.image.remove');
                Route::put('video-remove', [QuizController::class, 'removeVideo'])->name('quizzes.video.remove');

                Route::prefix('questions')->group(function () {

                    /* Question CRUD */
                    Route::get('{questionType}/create', [QuestionController::class, 'create'])->name('questions.create');
                    Route::post('{questionType}/create', [QuestionController::class, 'store'])->name('questions.store');
                    Route::get('{question}', [QuestionController::class, 'show'])->name('questions.show');
                    Route::get('{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
                    Route::put('{question}/edit', [QuestionController::class, 'update'])->name('questions.update');
                    Route::delete('{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

                    Route::prefix('{question}')->group(function () {

                        /* Conformity CRUD */
                        Route::prefix('conformity')->group(function (){
                            Route::get('create', [ConformityController::class, 'create'])->name('conformity.create');
                            Route::post('create', [ConformityController::class, 'store'])->name('conformity.store');
                            Route::get('{conformity}/edit', [ConformityController::class, 'edit'])->name('conformity.edit');
                            Route::put('{conformity}/edit', [ConformityController::class, 'update'])->name('conformity.update');
                            Route::delete('{conformity}', [ConformityController::class, 'destroy'])->name('conformity.destroy');

                            Route::prefix('{conformity}')->group(function (){
                                /* Remove Conformity Image & Audio */
                                Route::put('audio-remove', [ConformityController::class, 'removeAudio'])->name('conformity.audio.remove');
                                Route::put('image-remove', [ConformityController::class, 'removeImage'])->name('conformity.image.remove');
                            });
                        });

                        /* Remove Question Image & Audio */
                        Route::delete('audio-{audio}/remove', [QuestionController::class, 'removeAudio'])->name('questions.audio.remove');
                        Route::put('image-remove', [QuestionController::class, 'removeImage'])->name('questions.image.remove');

                        /* Changing the correct option */
                        Route::put('options/{option}/change', [QuestionOptionController::class, 'changeIsCorrect'])->name('options.change-is-correct');
                    });
                });
            });
        });

        /* Students on the Course */
        Route::get('students', [StudentCourseController::class, 'studentsList'])->name('course.students.list');
    });

    /* REVIEWS */
    Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.all');
    Route::put('reviews/{review}/ban', [ReviewController::class, 'ban'])->name('reviews.ban');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    /* PROMO CODES */
    Route::resource('promocodes', PromocodeController::class);

    /* STUDENTS */
    Route::prefix('students')->group(function (){
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/{student}/edit', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');

        Route::prefix('{student}')->group(function (){
            Route::get('add-course', [StudentCourseController::class, 'addCourse'])->name('students.course.add');
            Route::post('give-course-{course}', [StudentCourseController::class, 'giveAccessToCourse'])->name('students.course.give-access');
            Route::get('course/{course}', [StudentCourseController::class, 'show'])->name('students.course.show');
            Route::get('course/{course}/quiz/{quiz}/answers', [StudentCourseController::class, 'showAnswers'])->name('students.course.answers.show');

            Route::put('quiz-{quiz}/conformity-{conformity}', [StudentCourseController::class, 'acceptQuestion'])->name('students.accept-answer');
        });
    });

    /* GROUPS */
    Route::resource('groups', GroupController::class);
    Route::get('groups/{group}/students', [GroupController::class, 'studentsList'])->name('group.students-list');
    Route::post('groups/{group}/set-students', [GroupController::class, 'setStudentsList'])->name('group.set-students-list');
    Route::delete('groups/{group}/{student}/exclude', [GroupController::class, 'excludeStudent'])->name('group.student.exclude');

    /* TEACHERS */
    Route::prefix('teachers')->middleware(['role:superuser|admin'])->group(function (){
        Route::get('/', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teacher-{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
        Route::get('/new-courses', [TeacherController::class, 'coursesForModeration'])->name('courses.moderation');
        Route::put('/new-courses/course-{course}/moderate', [TeacherController::class, 'courseModerateSwitcher'])->name('courses.moderate-switcher');
    });

    /* ALL USERS */
    Route::prefix('users')->middleware(['role:superuser|admin'])->group(function (){
        Route::get('/', [UserController::class, 'adminUsersList'])->name('admin.users.index');
        Route::get('/{user}', [UserController::class, 'adminUserShow'])->name('admin.users.show');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    /* Actions with Users */
    Route::put('users/user-{user}/block', [UserController::class, 'banSwitcher'])->name('users.ban-switcher');
    Route::post('users/user-{user}/give-teacher-role', [UserController::class, 'giveTeacherRole'])->name('users.give-teacher-role');

    /* Home Works */
    Route::get('homeworks', [HomeWorkController::class, 'homeWorksList'])->name('dashboard.homeworks');
    Route::get('homeworks/{homeWorkResult}/change-assessment', [HomeWorkController::class, 'changeAssessment'])
        ->name('dashboard.homeworks.change-assessment');
});