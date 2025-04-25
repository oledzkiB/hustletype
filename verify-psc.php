<?php
header('Content-Type: application/json');

// Odczytaj dane JSON z żądania POST
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Sprawdź, czy przesłano kod i plan
if (!isset($data['code']) || !isset($data['plan'])) {
    echo json_encode([
        "success" => false,
        "error" => "Brak wymaganych danych."
    ]);
    exit;
}

$code = trim($data['code']);
$plan = trim($data['plan']);

// Prosta walidacja kodu PSC
if (!preg_match('/^\d{16}$/', $code)) {
    echo json_encode([
        "success" => false,
        "error" => "Nieprawidłowy kod. Upewnij się, że składa się z 16 cyfr."
    ]);
    exit;
}

// Zapisz do pliku (stwórz plik jeśli nie istnieje)
$entry = date("Y-m-d H:i:s") . " | Plan: $plan | Kod: $code\n";
file_put_contents("psc_kody.txt", $entry, FILE_APPEND);

// Zwróć link do grupy
echo json_encode([
    "success" => true,
    "link" => "https://t.me/+u-wYhoolDxEwODI0"
]);