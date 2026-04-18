import os
from PIL import Image

folder = r"c:\xampp\htdocs\livoliav2\theme\assets\img"

for filename in os.listdir(folder):
    if filename.endswith(".jpg") or filename.endswith(".png"):
        path = os.path.join(folder, filename)
        try:
            with Image.open(path) as img:
                width, height = img.size
                # Crop 60 pixels from the bottom
                cropped_img = img.crop((0, 0, width, height - 60))
            
            # Save it back (overwrite)
            cropped_img.save(path)
            print(f"Cropped {filename} successfully.")
        except Exception as e:
            print(f"Failed to crop {filename}: {e}")
