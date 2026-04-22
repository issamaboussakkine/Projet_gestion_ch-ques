import sys
import json
import re
from paddleocr import PaddleOCR

def main():
    if len(sys.argv) < 2:
        print(json.dumps({"error": "No image path provided"}))
        return
    
    image_path = sys.argv[1]
    
    try:
        ocr = PaddleOCR(use_angle_cls=True, lang='fr', show_log=False)
        result = ocr.ocr(image_path, cls=True)
        
        text = ""
        if result and result[0]:
            for line in result[0]:
                text += line[1][0] + " "
        
        print(json.dumps({"success": True, "text": text}))
        
    except Exception as e:
        print(json.dumps({"success": False, "error": str(e)}))

if __name__ == "__main__":
    main()