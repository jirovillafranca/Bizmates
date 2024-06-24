namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TravelController extends Controller
{
    public function index()
    {
        $cities = ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'];
        return view('travel.index', compact('cities'));
    }

    public function getInfo(Request $request)
    {
        $city = $request->city;

        // Fetch weather data
        $weatherUrl = "https://api.openweathermap.org/data/2.5/forecast?q={$city},JP&appid=" . env('OPENWEATHERMAP_API_KEY');
        $weatherResponse = Http::get($weatherUrl)->json();

        // Fetch places data
        $foursquareUrl = "https://api.foursquare.com/v2/venues/search?near={$city},JP&limit=5&client_id=" . env('FOURSQUARE_CLIENT_ID') . "&client_secret=" . env('FOURSQUARE_CLIENT_SECRET') . "&v=20230623";
        $placesResponse = Http::get($foursquareUrl)->json();

        return response()->json([
            'weather' => $weatherResponse,
            'places' => $placesResponse['response']['venues']
        ]);
    }
}
