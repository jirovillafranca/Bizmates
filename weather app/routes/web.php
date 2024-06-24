use App\Http\Controllers\TravelController;

Route::get('/', [TravelController::class, 'index']);
Route::post('/get-info', [TravelController::class, 'getInfo']);
