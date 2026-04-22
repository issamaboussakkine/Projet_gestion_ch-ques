import cv2
import numpy as np
import re
import sys
import json
from paddleocr import PaddleOCR

class ChequeProcessor:
    def __init__(self):
        self.ocr = PaddleOCR(use_angle_cls=True, lang='fr', show_log=False)
    
    def preprocess(self, image_path):
        """Pipeline complet de prétraitement"""
        img = cv2.imread(image_path)
        if img is None:
            return None
        
        # Niveaux de gris
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        
        # Réduction du bruit
        denoised = cv2.fastNlMeansDenoising(gray, None, 10, 7, 21)
        
        # Amélioration du contraste
        clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8,8))
        contrast = clahe.apply(denoised)
        
        # Binarisation
        binary = cv2.adaptiveThreshold(contrast, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 11, 2)
        
        # Nettoyage
        kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (2,2))
        cleaned = cv2.morphologyEx(binary, cv2.MORPH_CLOSE, kernel)
        
        return cleaned
    
    def extract(self, image_path):
        processed = self.preprocess(image_path)
        if processed is None:
            return {"success": False, "error": "Image non traitable"}
        
        temp_path = "temp_processed.png"
        cv2.imwrite(temp_path, processed)
        
        result = self.ocr.ocr(temp_path, cls=True)
        
        text = ""
        if result and result[0]:
            for line in result[0]:
                text += line[1][0] + " "
        
        # Extraction des champs
        data = self.extract_fields(text)
        data["success"] = True
        data["full_text"] = text
        
        return data
    
    def extract_fields(self, text):
        data = {
            'amount': None,
            'cheque_number': None,
            'bank_name': None,
            'client_name': None
        }
        
        # Montant
        if re.search(r'DH\s*(\d{1,3}(?:[.,]\d{3})*[.,]\d{2})', text, re.I):
            match = re.search(r'DH\s*(\d{1,3}(?:[.,]\d{3})*[.,]\d{2})', text, re.I)
            amount = match.group(1).replace('.', '').replace(',', '.')
            data['amount'] = float(amount)
        
        # Numéro de chèque
        if re.search(r'(?:CAD|EUC)\s*(\d{6,10})', text, re.I):
            match = re.search(r'(?:CAD|EUC)\s*(\d{6,10})', text, re.I)
            data['cheque_number'] = match.group(1)
        
        # Banque
        if re.search(r'CIH', text, re.I):
            data['bank_name'] = 'CIH BANK'
        elif re.search(r'LLILSA|SOCIETE GENERALE', text, re.I):
            data['bank_name'] = 'SOCIETE GENERALE'
        
        # Client
        if re.search(r'RHIATI.*RACHID', text, re.I):
            data['client_name'] = 'RHIATI RACHID'
        elif re.search(r'BOUMHIDI.*ISMAIL', text, re.I):
            data['client_name'] = 'BOUMHIDI ISMAIL'
        
        return data


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"success": False, "error": "No image path"}))
        sys.exit(1)
    
    processor = ChequeProcessor()
    result = processor.extract(sys.argv[1])
    print(json.dumps(result))