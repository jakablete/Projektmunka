<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Köszönjük a vásárlást</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="thank-you-container">
        <h1>Köszönjük a vásárlást!</h1>
        <button onclick="window.location.href='./index.php'">Vissza a főoldalra</button>
        <button onclick="window.location.href='../logout.php'">Kijelentkezés</button>
    </div>
</body>
</html>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
}

.thank-you-container {
    text-align: center;
    background-color: white;
    padding: 50px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

</style>