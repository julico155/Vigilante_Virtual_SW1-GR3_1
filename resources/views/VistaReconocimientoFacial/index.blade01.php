@extends('Panza')
@section('Panza')
    <div class="min-h-screen flex flex-col bg-white text-gray-800">
        <header class="bg-blue-600 text-white p-4 shadow-lg">
            <h1 class="font-bold text-2xl">Detección de rostros</h1>
        </header>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div id="mensajeSuperposicion"
            class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 z-50 hidden animate-fadeIn">
            <div class="bg-red-600 text-white p-4 rounded shadow-lg">
                <p id="textoMensajeSuperposicion"></p>
            </div>
        </div>
        <div class="text-center mt-4">
            <div id="mensajeEmocion" class="inline-block bg-red-500 text-white p-2 rounded shadow-lg hidden"></div>
        </div>
        <main class="flex-1 p-4 flex flex-col items-center justify-center">
            <div class="relative mb-4">
                <video id="inputVideo" class="absolute z-10" style="transform: scaleX(-1);" autoplay muted
                    playsinline></video>
                <canvas id="overlay" class="relative z-20" style="transform: scaleX(-1);"></canvas>
            </div>
        </main>
        <div class="flex gap-4 justify-center mt-4">
            <button id="startButton"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg">Iniciar
                cámara</button>
            <button id="stopButton"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-lg">Detener
                cámara</button>
        </div>
        <footer class="bg-gray-900 text-white p-4">
            <div id="results" class="mt-4 p-4 border rounded bg-gray-800"></div>
        </footer>
    </div>
  <script src="{{ asset('js/camera_utils.js') }}" ></script>
    <script src="{{ asset('js/face_mesh.js') }}" ></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils@0.1/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils@0.1/control_utils.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils@0.1/drawing_utils.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh@0.1/face_mesh.js" crossorigin="anonymous"></script> --}}

    <script>
        const video = document.getElementById('inputVideo');
        const canvas = document.getElementById('overlay');
        const mensajeEmocion = document.getElementById('mensajeEmocion');
        const mensajeSuperposicion = document.getElementById('mensajeSuperposicion');
        const textoMensajeSuperposicion = document.getElementById('textoMensajeSuperposicion');
        const botonInicio = document.getElementById('startButton');
        const botonParada = document.getElementById('stopButton');

        let camaraEncendida = false;
        let mallaRostro = null;

        botonInicio.addEventListener('click', () => {
            navigator.mediaDevices.getUserMedia({
                    video: {
                        width: 1280,
                        height: 720
                    }
                })
                .then(transmision => {
                    video.srcObject = transmision;
                    camaraEncendida = true;
                })
                .then(() => {
                    mallaRostro = new FaceMesh({
                        locateFile: (archivo) => {
                            return `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh@0.1/${archivo}`;
                        }
                    });

                    const camara = new Camera(video, {
                        onFrame: async () => {
                            await mallaRostro.send({
                                image: video
                            });
                        },
                        width: 1280,
                        height: 720
                    });
                    camara.start();

                    mallaRostro.onResults(resultadosMallaRostro);
                });
        });

        botonParada.addEventListener('click', () => {
            if (mallaRostro) {
                mallaRostro.close();
                mallaRostro = null;
            }

            if (video.srcObject) {
                video.srcObject.getTracks().forEach(pista => {
                    pista.stop();
                });
            }

            camaraEncendida = false;
            mensajeEmocion.classList.add('hidden');
            mensajeSuperposicion.classList.add('hidden');
        });

        function resultadosMallaRostro(resultados) {
            if (results.multiFaceLandmarks && results.multiFaceLandmarks.length > 1) {
                if (!isChecking) {
                    console.log("ANOMALÍA DETECTADA: Hay más de 1 rostro en la cámara del usuario");
                    mensajeSuperposicion.classList.remove('hidden');
                    textoMensajeSuperposicion.innerText =
                        "Se detectaron más de una persona en la cámara. Por favor, mantén solo a una persona frente a la cámara.";
                    captureAndSaveScreenshot();
                    isChecking = true;
                }
            } else {
                if (isChecking) {
                    mensajeSuperposicion.classList.add('hidden');
                    stopFaceCheck();
                    isChecking = false;
                }
            }

        }
    </script>


    <!-- <script>
        const video = document.getElementById('inputVideo');
        const canvas = document.getElementById('overlay');
        const mensajeEmocion = document.getElementById('mensajeEmocion');
        const mensajeSuperposicion = document.getElementById('mensajeSuperposicion');
        const textoMensajeSuperposicion = document.getElementById('textoMensajeSuperposicion');
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');

        let isCameraOn = false;
        let faceMesh = null;

        startButton.addEventListener('click', () => {
            navigator.mediaDevices.getUserMedia({
                    video: {}
                })
                .then(stream => {
                    video.srcObject = stream;
                    isCameraOn = true;
                })
                .then(() => {
                    faceMesh = new FaceMesh({
                        locateFile: (file) => {
                            return `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh@0.1/${file}`;
                        }
                    });

                    const camera = new Camera(video, {
                        onFrame: async () => {
                            await faceMesh.send({
                                image: video
                            });
                        },
                        width: 640,
                        height: 480
                    });
                    camera.start();

                    faceMesh.onResults(onResultsFaceMesh);
                });
        });

        stopButton.addEventListener('click', () => {
            if (faceMesh) {
                faceMesh.close();
                faceMesh = null;
            }

            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => {
                    track.stop();
                });
            }

            isCameraOn = false;
            mensajeEmocion.classList.add('hidden');
            mensajeSuperposicion.classList.add('hidden');
        });

        function detectEmotion(results) {
            if (!results.multiFaceLandmarks) {
                return null;
            }

            const landmarks = results.multiFaceLandmarks[0];

            // Los puntos de referencia 61, 146, 291, 0, 33, 362, 308 son alrededor de la boca
            const mouthUpper = landmarks[61];
            const mouthLower = landmarks[146];
            const mouthLeft = landmarks[291];
            const mouthRight = landmarks[308];

            // Los puntos de referencia 159, 158, 157, 173 son alrededor del ojo izquierdo
            const leftEyeUpper = landmarks[159];
            const leftEyeLower = landmarks[158];
            const leftEyeLeft = landmarks[157];
            const leftEyeRight = landmarks[173];

            // Los puntos de referencia 386, 385, 384, 398 son alrededor del ojo derecho
            const rightEyeUpper = landmarks[386];
            const rightEyeLower = landmarks[385];
            const rightEyeLeft = landmarks[384];
            const rightEyeRight = landmarks[398];

            if (mouthLeft.y < mouthUpper.y && mouthRight.y < mouthUpper.y) {
                return 'feliz';
            }

            if (mouthLeft.y > mouthLower.y && mouthRight.y > mouthLower.y) {
                return 'triste';
            }

            if (leftEyeUpper.y > leftEyeLower.y && rightEyeUpper.y > rightEyeLower.y) {
                return 'neutral';
            }

            if (leftEyeUpper.y < leftEyeLower.y && rightEyeUpper.y < rightEyeLower.y) {
                return 'sorprendido';
            }

            if (mouthUpper.y > mouthLower.y) {
                return 'disgustado';
            }

            if (leftEyeUpper.y > leftEyeLower.y && rightEyeUpper.y > rightEyeLower.y && mouthUpper.y < mouthLower.y) {
                return 'temeroso';
            }

            if (leftEyeUpper.y > leftEyeLower.y && rightEyeUpper.y > rightEyeLower.y && mouthUpper.y > mouthLower.y) {
                return 'enojado';
            }

            return 'neutral';
        }

        function onResultsFaceMesh(results) {
            const emotion = detectEmotion(results);
            if (emotion) {
                mensajeEmocion.textContent = emotion;
                mensajeEmocion.classList.remove('hidden');
            } else {
                mensajeEmocion.classList.add('hidden');
            }
        }


    </script> -->
@endsection
