 Sistema de Reconocimiento Facial – Prototipo

Este es un prototipo funcional de un sistema de reconocimiento facial  que integra:  

Base de datos MySQL
para registrar usuarios y guardar detecciones. 
 
Formulario en PHP
 para registrar usuarios con nombre, cédula y foto de referencia.  

Script en Python (OpenCV + Mediapipe + DeepFace)
 para reconocimiento en tiempo real.  

----------------------------------------------------------------------------------------------------------------
**************************************************************************
A) Características
**************************************************************************
 el proyecto piloto tiene:
1.Registro de usuarios con:
  - Nombre
  - Cédula (máx. 10 dígitos)
  - Foto de referencia
2. Al detectar un rostro en cámara:
  - Verifica contra las imágenes registradas.
  - Si hay coincidencia entonces muestra los datos ingresados anteriormente en el registro:nombre, cédula y fecha/hora en pantalla**.
  - Guarda automáticamente la detección en la base de datos.  
-3.Dashboard PHP sencillo con un botón para abrir la cámara (nota: solo funciona para visualización en vivo,aun no esta  ligado al detector por questiones de tiempo).  


**************************************************************************
B). Requisitos
**************************************************************************
1.[XAMPP](para Apache + MySQL) 
2. Python 3.10+
3.Virtualenv o entorno de Python
4.una camara conectada al PC

++Nota importante el entorno virtual debe llamarse exactamente **`PilotoCV`** para mantener la coherencia en la ejecución y evitar conflictos.++
---
**************************************************************************
C)Configuración
**************************************************************************
1. Crear entorno virtual PilotoCV

en la terminal de comandos (si es en visual studio code puedes llamarlo con ctrl+ñ,manten presionado el boton contro y luego la letra ñ)
escribe en esa terminal este comando:
.........................................
python -m venv PilotoCV
.........................................
luego para activar ese entorno escribe
....................................................
   PilotoCV\Scripts\activate
   # en Windows
....................................................
   source PilotoCV/bin/activate
  # en Linux/Mac
....................................................
para validar que esta activo deberia salirte en la direccion un icono asi: (PilotoCV)  al inicio de la terminal de comandos


D) Instalar dependencias en PilotoCV


una vez activo el entorno deberias poder escribir este  comando y ten paciencia con la instalacion:
..................................................................................................................
pip install opencv-python mediapipe deepface mysql-connector-python tf-keras
..................................................................................................................

E)Clonar el proyecto en htdocs de XAMPP
para que a la hora de activar el servidor de xampp pueda reconocer la union de la base de datos con la pagina
............................................................
C:\xampp\htdocs  y deberia quedar la direccion asi: C:\xampp\htdocs\PilotoCV-main
............................................................

E)Base de datos

En phpMyAdmin:

1. Crear la base de datos con el nombre (reconocimiento_facial) sin los parentesis 
2. Importar el archivo (reconocimiento_facial.sql) incluido en este repositorio.

F)Carpeta para imágenes

Crear la carpeta imagenes/ dentro del proyecto.

El formulario subirá ahí las fotos de referencia.

entonces la arquitectura aproximada de la carpeta deberia verse asi
---------------------------
carpetas disponibles:

imagenes
PilotoCV
----------------
archivos individuales:
.gitignore
ProyectoVer1.py
README-LEEME.txt
reconocimiento_facial.sql
registro.php
requeriments.txt
----------------
**************************************************************************
 instrucciones de uso:
**************************************************************************
-para poder usar correctamente el programa debes tener activo apache para el acceso  al formulario donde se carga la informacion(registro.php)
-MySQL activo para sincronizar la base de datos reconocimiento_facial
-el entorno virtual preparado con las respectivas librerias para que ejecute lo pertinente

Bueno ahora tienes que acceder a un navegador y escribir "localhost", si tu apache esta activo este te permitira entrar a un indexado de carpetas de esas busca la carpeta llamada "proyecto Piloto CV"
dentro de la carpeta presiona en el archivo registro.php,esto te accedera al formulario,ahi es donde debes ingresar los datos con la imagen 

entra a la base de datos en phpmyadmin por medio de: http://localhost/phpmyadmin/

busca la base de datos reconocimiento_facial y verifica en la tabla de usuarios si se subio los datos del fomulario

una ves validado esto en tu caja de comandos donde este activo el entorno virtual si no esta activo accede a la carpeta y escribe esto:
 (PilotoCV\Scripts\activate)

una vez que tengas el icono  (PilotoCV) activo ingresa este script para ejecutar el archivo python ProyectoVer1.py  o en su defecto:
 python .\ProyectoVer1.py

ten paciencia en que vaya ejecutando cada proceso y una vez que el programa haya cargado te aparecera una pestaña de python donde esta accedera a tu camara que tienes conectada y buscara coincidencias con la imagen que hayas subido,si este coincide con patrones faciales de la foto se reflejara en la camara 

y listo eso seria la dinamica del prototipo!

*************************************************************************
 (añadido):instrucciones de instalacion por xampp con clonacion directa del repositorio
**************************************************************************
descripcion:
Yo personalmente diseñe todo esto en el entorno xampp asi que por comodidad pueden usar esta guia para ejecutarlo tal cual como lo hize yo

Descarga XAMPP desde  https://www.apachefriends.org/download.html


Instálalo en la ruta por defecto deberia verse asi:
 C:\xampp\

ahora para  clonar el proyecto en la carpeta de XAMPP abre PowerShell y ejecuta script por script:

cd C:\xampp\htdocs
git clone https://github.com/redsonic28/PilotoCV.git
cd ProyectoPilotoCV

Configuración de la Base de Datos

 entra al aplicativo XAMPP,activa tanto apache como mySQL ahora:

1. Abre phpMyAdmin desde tu XAMPP (http://localhost/phpmyadmin).

2. Crea una base de datos con el nombre: reconocimiento_facial
3. Ve a la pestaña Importar y selecciona el archivo "reconocimiento_facial.sql" incluido en este repositorio.
4. Haz clic en "Import" y las tablas se crearán automáticamente.



**************************************************************************
Notas a tener en cuenta:
**************************************************************************
Este prototipo es de uso demostrativo.
No implementa seguridad avanzada ni optimizaciones de rendimiento.
En PCs con GPU limitada puede experimentar ralentizaciones 

Autor: Daniel Felipe Chavez
Versión: Prototipo v1.0.2 (2025)

<<<<<<<< English Version>>>>>>>>>

Facial Recognition System – Prototype

This is a functional prototype of a facial recognition system that integrates:

MySQL database
to register users and save detections.

PHP form
to register users with name, ID, and reference photo.

Python script (OpenCV + Mediapipe + DeepFace)
for real-time recognition.

----------------------------------------------------------------------------------------------------------------

A) Features
The pilot project includes:
1. User registration with:
- Name
- ID (max. 10 digits)
- Reference photo
2. When a face is detected on camera:
- Verifies against the recorded images.
- If there is a match, the data previously entered in the registration is displayed on the screen: name, ID, and date/time.
- Automatically saves the detection to the database.
-3. Simple PHP dashboard with a button to launch the camera (note: only works for live viewing; it's not yet linked to the detector due to time constraints).

----------------------------------------------------------------------------------------------------------------------------------

B). Requirements

1. [XAMPP] (for Apache + MySQL) you can download it at: https://www.apachefriends.org/)
2. Python 3.10+
3. Virtualenv or Python environment

++Important note: the virtual environment must be named exactly **`PilotoCV`** to maintain consistency in execution and avoid conflicts.++
---

C) Configuration

1. Create the PilotoCV virtual environment

In the command terminal (if it's in Visual Studio Code, you can call it with Ctrl+ñ, hold down the Ctrl button, and then press the letter ñ),
type this command in that terminal:
.........................................
python -m venv PilotoCV
.........................................
Then to activate that environment, type
..................................................
PilotoCV\Scripts\activate
# on Windows
..................................................
source PilotoCV/bin/activate
# on Linux/Mac
..................................................
for Validate that it's active. An icon like this should appear in the address bar: (PilotoCV) at the start of the command prompt.

D) Install dependencies in PilotoCV

Once the environment is active, you should be able to type this command:
................................................................................................................
pip install opencv-python mediapipe deepface mysql-connector-python tf-keras
................................................................................................................

E) Clone the project in XAMPP htdocs
so that when you activate the XAMPP server, it can recognize the database connection with the page.
................................................................
C:\xampp\htdocs and the address should look like this: C:\xampp\htdocs\PilotoCV-main
..............................................................

E) Database

In phpMyAdmin:

1. Create the database with the name (reconocimiento_facial) without the parentheses.
2. Import the file (reconocimiento_facial.sql) included in this repository.

F) Image Folder

Create the imagenes/ folder within the project.

The form will upload the reference photos there.

The approximate folder architecture should look like this:
---------------------------
Available folders:

images
PilotoCV
----------------
Individual files:
.gitignore
ProjectoVer1.py
README-LEEME.txt
reconocimiento_facial.sql
registro.php
requirements.txt
----------------
****************************************************************************
(added): XAMPP installation instructions with direct cloning of the repository
********************************************************************************
Description:
I personally designed all of this in the XAMPP environment, so for convenience, you can use this guide to run it exactly as I did.

Download XAMPP from https://www.apachefriends.org/download.html

Install it in the default path. It should look like this:
C:\xampp\

Now, to clone the project in the XAMPP folder, open PowerShell and run script by script:

cd C:\xampp\htdocs
git clone https://github.com/redsonic28/PilotoCV.git
cd ProyectoPilotoCV

Database Configuration

Go to XAMPP application, activate both Apache and MySQL now:

1. Open phpMyAdmin from your XAMPP (http://localhost/phpmyadmin).

2. Create a database named: facial_recognition.
3. Go to the Import tab and select the "facial_recognition.sql" file included in this repository.
4. Click "Import" and the tables will be created automatically.
-------------------
Notes:

This prototype is for demonstration purposes only.
It does not implement advanced security or performance optimizations.
You may experience slowdowns on PCs with limited GPUs.

Author: Daniel Felipe Chavez
Version: Prototype v1.0.2 (2025)

