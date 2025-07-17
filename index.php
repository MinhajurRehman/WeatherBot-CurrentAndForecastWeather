<?php
// Enable error display during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Read Dialogflow request
$input = json_decode(file_get_contents("php://input"), true);

// Extract parameters safely
$city = $input['queryResult']['parameters']['geo-city'] ?? null;
$date = $input['queryResult']['parameters']['date'] ?? null;

$apiKey = "d0dd1d1a9d5c7bbd18b8e339e30ed522";
$responseText = "";

// Basic check
if (!$city) {
    $responseText = "Please provide the city name.";
} else if ($date) {
    // Forecast Weather
    $geoUrl = "http://api.openweathermap.org/geo/1.0/direct?q=$city&limit=1&appid=$apiKey";
    $geoData = json_decode(file_get_contents($geoUrl), true);

    if (!empty($geoData)) {
        $lat = $geoData[0]['lat'];
        $lon = $geoData[0]['lon'];


       // ✅ Use 5-day forecast API instead (every 3-hour interval) for free
        $forecastUrl = "https://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&units=metric&appid=$apiKey";
        $forecastData = json_decode(file_get_contents($forecastUrl), true);
    
    if (!empty($forecastData['list'])) {
        $targetDate = date('Y-m-d', strtotime($date));
        $found = false;
    
        foreach ($forecastData['list'] as $entry) {
            $entryDate = date('Y-m-d', strtotime($entry['dt_txt']));
            if ($entryDate === $targetDate) {
                $temp = $entry['main']['temp'];
                $desc = $entry['weather'][0]['description'];
                $formatted = date('l, d M Y', strtotime($entryDate));
                $responseText = "Forecast for $city on $formatted: {$temp}°C, $desc.";
                $found = true;
                break;
            }
        }
    
        if (!$found) {
            $responseText = "No forecast found for that date. Try within next 5 days.";
        }
    } else {
        $responseText = "Forecast data not available for $city.";
    }    
    } else {
        $responseText = "Could not find location '$city'.";
    }
} else {
    // Current Weather
    $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$apiKey";
    $weatherData = json_decode(file_get_contents($url), true);

    if (!empty($weatherData) && isset($weatherData['main']['temp'])) {
        $temp = $weatherData['main']['temp'];
        $desc = $weatherData['weather'][0]['description'];
        $responseText = "Current weather in $city: " . $temp . "°C, " . $desc . ".";
    } else {
        $responseText = "Could not get current weather for '$city'.";
    }
}

// Final response
header('Content-Type: application/json');
echo json_encode(['fulfillmentText' => $responseText]);