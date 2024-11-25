<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-center p-10">

  <h1 class="text-5xl font-extrabold underline text-blue-600 hover:text-blue-800 transition-all duration-300">
    Hello world!
  </h1>

  <p class="mt-5 text-lg text-gray-700">
    This is an example of a paragraph styled with Tailwind CSS. 
  </p>

  <button class="mt-5 px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
    Click Me!
  </button>

  <div class="mt-10 flex justify-center space-x-4">
    <div class="w-24 h-24 bg-red-500 rounded-lg shadow-lg hover:scale-105 transform transition-all duration-300"></div>
    <div class="w-24 h-24 bg-green-500 rounded-lg shadow-lg hover:scale-105 transform transition-all duration-300"></div>
    <div class="w-24 h-24 bg-yellow-500 rounded-lg shadow-lg hover:scale-105 transform transition-all duration-300"></div>
  </div>

</body>
</html>
