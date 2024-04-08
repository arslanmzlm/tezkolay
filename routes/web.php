<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\App\DashboardController::class, 'index'])->name('app.dashboard.index');

    Route::get('/workspaces', [\App\Http\Controllers\App\WorkspaceController::class, 'index'])->name('app.workspace.list');
    Route::get('/workspace/create', [\App\Http\Controllers\App\WorkspaceController::class, 'create'])->name('app.workspace.create');
    Route::post('/workspace/store', [\App\Http\Controllers\App\WorkspaceController::class, 'store'])->name('app.workspace.store');
    Route::get('/workspace/edit/{workspace}', [\App\Http\Controllers\App\WorkspaceController::class, 'edit'])->name('app.workspace.edit');
    Route::post('/workspace/update/{workspace}', [\App\Http\Controllers\App\WorkspaceController::class, 'update'])->name('app.workspace.update');
    Route::post('/workspace/destroy/{workspace}', [\App\Http\Controllers\App\WorkspaceController::class, 'destroy'])->name('app.workspace.destroy');

    Route::get('/templates', [\App\Http\Controllers\App\TemplateController::class, 'index'])->name('app.template.list');
    Route::get('/template/create', [\App\Http\Controllers\App\TemplateController::class, 'create'])->name('app.template.create');
    Route::post('/template/store', [\App\Http\Controllers\App\TemplateController::class, 'store'])->name('app.template.store');
    Route::get('/template/show/{template}', [\App\Http\Controllers\App\TemplateController::class, 'show'])->name('app.template.show');
    Route::get('/template/edit/{template}', [\App\Http\Controllers\App\TemplateController::class, 'edit'])->name('app.template.edit');
    Route::post('/template/update/{template}', [\App\Http\Controllers\App\TemplateController::class, 'update'])->name('app.template.update');
    Route::post('/template/destroy/{template}', [\App\Http\Controllers\App\TemplateController::class, 'destroy'])->name('app.template.destroy');

    Route::get('/group/{group}/patients/edit', [\App\Http\Controllers\App\GroupPatientController::class, 'edit'])->name('app.group.patients.edit');
    Route::post('/group/{group}/patients/update', [\App\Http\Controllers\App\GroupPatientController::class, 'update'])->name('app.group.patients.update');

    Route::get('/group/{group}/surveys/edit', [\App\Http\Controllers\App\GroupSurveyController::class, 'edit'])->name('app.group.surveys.edit');
    Route::post('/group/{group}/surveys/update', [\App\Http\Controllers\App\GroupSurveyController::class, 'update'])->name('app.group.surveys.update');

    Route::get('/surveys', [\App\Http\Controllers\App\SurveyController::class, 'index'])->name('app.survey.list');
    Route::post('/survey/initialize/{survey}', [\App\Http\Controllers\App\SurveyController::class, 'initialize'])->name('app.survey.initialize');

    Route::get('/survey-item/{survey}/{patient}', [\App\Http\Controllers\App\SurveyItemController::class, 'show'])->name('app.survey.item.show');
    Route::post('/survey-item/update/{surveyItem}', [\App\Http\Controllers\App\SurveyItemController::class, 'update'])->name('app.survey.item.update');
});

require __DIR__ . '/auth.php';
