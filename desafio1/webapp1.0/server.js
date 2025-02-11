const express = require("express");
const axios = require("axios");
const app = express();

// Cargar variables de entorno
require('dotenv').config();

// Configurar el motor de vistas a EJS
app.set("view engine", "ejs");

// Servir la carpeta pública como archivos estáticos
app.use(express.static("public"));

// Middleware para agregar el dia y la hora actual a todas las vistas
const addDateTime = (req, res, next) => {
  res.currentDateTime = new Date().toLocaleString();
  next();
};

// Usar el middleware en todas las rutas
app.use(addDateTime);

// Renderizar la plantilla index con valores predeterminados para el clima y el error
app.get("/", (req, res) => {
  res.render("index", { weather: null, error: null, currentDateTime: res.currentDateTime });
});

// Establecer el puerto a la variable de entorno PORT o 3000
const PORT = process.env.PORT || 3000;

// Manejar la ruta /weather
app.get("/weather", async (req, res) => {
  // Obtener la ciudad de los parámetros de consulta
  const city = req.query.city;
  // Hacer una solicitud a la API de OpenWeatherMap
  const Url = `http://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${process.env.API_KEY}`;
  let weather;
  let error = null;
  try {
    const response = await axios.get(Url);
    weather = response.data;
  } catch (error) {
    weather = null;
    error = "Error, por favor intenta de nuevo";
  }
  // Renderizar la plantilla index con los datos del clima y el mensaje de error
  res.render("index", { weather, error, currentDateTime: res.currentDateTime });
});

// Mensaje en consola para saber que el servidor está corriendo
app.listen(PORT, () => {
  console.log(`El servidor está corriendo en el puerto ${PORT}`);
});