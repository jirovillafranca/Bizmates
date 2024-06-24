<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Info</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="container">
        <h1>Travel Info for Japan</h1>
        <form id="travel-form">
            <div class="form-group">
                <label for="city">Select a city:</label>
                <select id="city" class="form-control">
                    @foreach($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Get Info</button>
        </form>
        <div id="result" class="mt-4"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#travel-form').on('submit', function(e) {
                e.preventDefault();
                let city = $('#city').val();

                $.post('/get-info', { city: city, _token: '{{ csrf_token() }}' }, function(data) {
                    let weatherHtml = '<h3>Weather Forecast</h3><ul>';
                    data.weather.list.forEach(function(forecast) {
                        weatherHtml += `<li>${forecast.dt_txt}: ${forecast.weather[0].description}, Temp: ${forecast.main.temp}K</li>`;
                    });
                    weatherHtml += '</ul>';

                    let placesHtml = '<h3>Places to Visit</h3><ul>';
                    data.places.forEach(function(place) {
                        placesHtml += `<li>${place.name} - ${place.location.address}</li>`;
                    });
                    placesHtml += '</ul>';

                    $('#result').html(weatherHtml + placesHtml);
                });
            });
        });
    </script>
</body>
</html>
