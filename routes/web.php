<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
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
   return redirect()->route('index');
});

Route::get('index', [MainController::class, 'index'])->name('index');

Route::resource('users', UserController::class)->except('show');
Route::resource('question', QuestionController::class);

Route::get('game/start', [GameController::class, 'start'])->name('game.start');
Route::post('game/{game}/stop', [GameController::class, 'stop'])->name('game.stop');
Route::get('game/play/{game}/{round_number}', [GameController::class, 'play'])->name('game.play');
Route::get('game/{game}/finalRound', [GameController::class, 'finalRound'])->name('game.final');
Route::get('game/continue/{game}', [GameController::class, 'continueGame'])->name('game.continue');
Route::get('game/{game}/statistics', [GameController::class, 'statistics'])->name('game.statistics');

Route::get('question/control/{result}/{round}', [GameController::class, 'control'])->name('question.control');
Route::get('round/{round}/bank', [GameController::class, 'bank'])->name('round.bank');
Route::get('round/{round}/stop', [GameController::class, 'roundStop'])->name('round.stop');
Route::post('round/{round}/next', [GameController::class, 'roundNext'])->name('round.next');
