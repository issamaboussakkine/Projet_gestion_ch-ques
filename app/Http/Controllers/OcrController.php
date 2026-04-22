<?php

namespace App\Http\Controllers;

use App\Services\OcrService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OcrController extends Controller
{
    protected OcrService $ocrService;

    public function __construct(OcrService $ocrService)
    {
        $this->ocrService = $ocrService;
    }

    public function scan(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,bmp,gif,webp',
                    'max:5120',
                ]
            ], [
                'image.required' => 'Veuillez sélectionner une image de chèque.',
                'image.image' => 'Le fichier doit être une image valide.',
                'image.mimes' => 'Formats acceptés : JPEG, JPG, PNG, BMP, GIF, WEBP.',
                'image.max' => 'La taille de l\'image ne doit pas dépasser 5 MB.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation échouée.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $file = $request->file('image');
            
            // Créer le dossier temp s'il n'existe pas
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
            
            // Sauvegarder l'image temporairement
            $tempPath = $tempDir . '/ocr_' . uniqid() . '.jpg';
            $imageContent = file_get_contents($file->getRealPath());
            file_put_contents($tempPath, $imageContent);
            
            // Appeler le service OCR
            $result = $this->ocrService->extractChequeData($tempPath);
            
            // Supprimer le fichier temporaire
            @unlink($tempPath);
            
            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de l\'extraction OCR.',
                    'error' => $result['error'] ?? 'Erreur inconnue'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Scan effectué avec succès.',
                'data' => [
                    'full_text' => $result['full_text'] ?? '',
                    'amount' => $result['amount'] ?? null,
                    'date' => $result['date'] ?? null,
                    'cheque_number' => $result['cheque_number'] ?? null,
                    'client_name' => $result['client_name'] ?? null,
                    'bank_name' => $result['bank_name'] ?? null,
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('OCR scan error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}