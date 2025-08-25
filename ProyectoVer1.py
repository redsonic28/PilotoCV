import cv2
import mediapipe as mp
from deepface import DeepFace
from datetime import datetime
import mysql.connector
import os

# --- Carpeta base relativa al script ---
BASE_DIR = os.path.dirname(os.path.abspath(__file__))  # carpeta donde está este script

# --- Conexión a MySQL ---
conexion = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="reconocimiento_facial"   
)
cursor = conexion.cursor(dictionary=True)

# Obtener usuarios registrados
cursor.execute("SELECT id, nombre, cedula, imagen_ref FROM usuarios")
usuarios = cursor.fetchall()

# --- Configuración MediaPipe ---
mp_face_detection = mp.solutions.face_detection
mp_drawing = mp.solutions.drawing_utils

# Ejecutar la cámara
cap = cv2.VideoCapture(0)

with mp_face_detection.FaceDetection(model_selection=0, min_detection_confidence=0.5) as face_detection:
    while cap.isOpened():
        ret, frame = cap.read()
        if not ret:
            break

        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        results = face_detection.process(rgb_frame)

        if results.detections:
            for detection in results.detections:
                mp_drawing.draw_detection(frame, detection)

                bboxC = detection.location_data.relative_bounding_box
                h, w, c = frame.shape
                x, y, w_box, h_box = int(bboxC.xmin * w), int(bboxC.ymin * h), \
                                     int(bboxC.width * w), int(bboxC.height * h)
                
                rostro = frame[y:y+h_box, x:x+w_box]

                if rostro.size > 0:
                    temp_path = os.path.join(BASE_DIR, "temp.jpg")
                    cv2.imwrite(temp_path, rostro)

                    for u in usuarios:
                        # --- Ruta absoluta y normalizada desde la carpeta del script ---
                        ruta_ref = u['imagen_ref']
                        if not os.path.isabs(ruta_ref):
                            ruta_ref = os.path.join(BASE_DIR, ruta_ref)
                        ruta_ref = os.path.normpath(ruta_ref)

                        if not os.path.exists(ruta_ref):
                            print(f"[ADVERTENCIA] Imagen de referencia no encontrada: {ruta_ref}")
                            continue
                        img_test = cv2.imread(ruta_ref)
                        if img_test is None:
                            print(f"[ADVERTENCIA] Imagen corrupta o formato no soportado: {ruta_ref}")
                            continue

                        try:
                            result = DeepFace.verify(
                                img1_path=temp_path,
                                img2_path=ruta_ref,
                                detector_backend="mediapipe",
                                enforce_detection=False
                            )

                            if result["verified"]:
                                fecha_hora = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
                                texto = f"{u['nombre']} | CC: {u['cedula']} | {fecha_hora}"
                                cv2.putText(frame, texto, (x, y-10), cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0,255,0), 2)

                                cursor.execute(
                                    "INSERT INTO detecciones (usuario_id, fecha) VALUES (%s, %s)", 
                                    (u['id'], fecha_hora)
                                )
                                conexion.commit()
                                break

                        except Exception as e:
                            print(f"[ERROR] Al verificar {ruta_ref}: {e}")

        cv2.imshow("Reconocimiento Facial", frame)

        if cv2.waitKey(1) & 0xFF == ord('x'):
            break

cap.release()
cv2.destroyAllWindows()
conexion.close()
