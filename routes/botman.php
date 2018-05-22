<?php
use App\Http\Controllers\BotManController;
use Illuminate\Support\Facades\Log;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    Log::info('*******hears***********');
	$user = $bot->getUser();
	$firstname = $user->getFirstName();
	$bot->reply('Hello, '.$firstname.'!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
