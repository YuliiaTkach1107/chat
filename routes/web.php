<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\AskController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PersonnalisationController;
use App\Http\Controllers\LandingController;


Route::get('/ask-stream', [\App\Http\Controllers\AskStreamController::class, 'index'])
    ->name('stream.index');
    
Route::post('/ask-stream', [\App\Http\Controllers\AskStreamController::class, 'stream'])
    ->name('stream.post');

Route::middleware(['auth'])->group(function () {
Route::get('/chat',[ConversationController::class,'index'])->name('conversation.index');
Route::get('/chat/{conversation}',[ConversationController::class,'show'])->name('conversation.show');
Route::post('/chat',[ConversationController::class,'store'])->name('conversation.store');
Route::delete('/chat/{conversation}',[ConversationController::class,'destroy'])->name('conversation.destroy');
Route::put('/chat/{conversation}', [ConversationController::class, 'update'])->name('conversation.update');
});

Route::post('/logout', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


Route::middleware(['auth'])->group(function() {
    Route::get('/personnalisation', [PersonnalisationController::class, 'index'])->name('personnalisation.index');
    Route::post('/personnalisation', [PersonnalisationController::class, 'update'])->name('personnalisation.update');
});



Route::middleware(['auth'])->group(function () {

   
Route::post('/chat/{conversation}/messages',[MessageController::class,'store'])->name('messages.store');
});
Route::post('/conversation/select-model', [ConversationController::class, 'selectModel'])
    ->name('model.select');

Route::get('/ask', [AskController::class, 'index'])->name('ask.index');
Route::post('/ask', [AskController::class, 'ask'])->name('ask.post');

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('landing');



require __DIR__.'/settings.php';
