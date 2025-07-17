# 🌦️ Weather Info & Forecast Bot using Google Dialogflow ES

This project is a weather assistant chatbot built with **Dialogflow ES** and integrated with **OpenWeatherMap API** using a PHP webhook. It supports two main use cases: fetching the **current weather** and the **5-day forecast** for any city.

---

## 🔧 Features

### ✅ Use Case 1 – Current Weather
- User can ask:  
  - "What's the weather in Islamabad?"
  - "Tell me the current weather in Karachi."
- The bot detects the city name and responds with real-time temperature and weather conditions.

### ✅ Use Case 2 – Forecast Weather
- User can ask:  
  - "What will be the weather in Lahore on Friday?"
  - "Is it going to rain in Karachi next Monday?"
- The bot detects both **city** and **date** and responds with forecasted temperature and description (from the next 7 days).

---

## ⚙️ Technologies Used

- **Dialogflow ES** (for NLP and intent handling)
- **PHP** (Webhook backend)
- **Ngrok** (Localhost tunneling for webhook testing)
- **OpenWeatherMap API**
  - `/data/2.5/weather` for current weather
  - `/data/2.5/onecall` for 7-day forecast

---

## 🛠️ How to Run

1. **Clone this repo**  
   ```bash
   git clone https://github.com/MinhajurRehman/WeatherBot-CurrentAndForecastWeather.git
   cd weatherbot
