<?php
$pythonPath = 'C:\Users\ASUS\AppData\Local\Programs\Python\Python310\python.exe';
$scriptPath = 'C:\Users\ASUS\gestion-cheques\ocr_script.py';
$imagePath = 'C:\Users\ASUS\Pictures\Screenshots\Capture d\'écran 2026-04-22 103544.png';

$command = '"' . $pythonPath . '" "' . $scriptPath . '" "' . $imagePath . '" 2>&1';
echo "Commande: " . $command . "\n\n";

$output = shell_exec($command);
echo "Output:\n" . $output;

$result = json_decode($output, true);
echo "\n\nDecoded:\n";
print_r($result);