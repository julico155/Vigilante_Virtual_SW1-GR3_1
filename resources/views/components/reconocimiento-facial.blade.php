<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Video Call with Face Detection</title>
    <script src="https://sdk.twilio.com/js/video/releases/2.14.0/twilio-video.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils@0.1/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils@0.1/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils@0.1/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh@0.1/face_mesh.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="relative w-full h-full flex items-center justify-center">
        <video class="input_video2 w-full h-full object-cover" autoplay></video>
        <canvas class="output2 w-full h-full absolute top-0 left-0"></canvas>
        <div class="loading absolute top-0 left-0 w-full h-full flex items-center justify-center">
            <div class="spinner"></div>
        </div>
        <div class="control2 hidden"></div>
    </div>

    <script>
        const video2 = document.getElementsByClassName('input_video2')[0];
        const out2 = document.getElementsByClassName('output2')[0];
        const controlsElement2 = document.getElementsByClassName('control2')[0];
        const canvasCtx = out2.getContext('2d');
        let isChecking = true;
        let detectionPaused = false;
        const ejecucionId = '{{ $ejecucion_id }}';
        const studentName = '{{ Auth::user()->name }}'; // Obtener el nombre del estudiante desde la autenticación de Laravel
        const fpsControl = new FPS();
        const spinner = document.querySelector('.loading');
        spinner.ontransitionend = () => {
            spinner.style.display = 'none';
        };

        function onResultsFaceMesh(results) {
            document.body.classList.add('loaded');
            fpsControl.tick();

            canvasCtx.save();
            canvasCtx.clearRect(0, 0, out2.width, out2.height);
            canvasCtx.drawImage(
                results.image, 0, 0, out2.width, out2.height);

            if (results.multiFaceLandmarks != undefined && results.multiFaceLandmarks.length == 1) {
                desactivarBloqueo();
            } else {
                if (results.multiFaceLandmarks == undefined) {
                    activarBloqueo('nf');
                } else {
                    activarBloqueo('mf');
                }
            }

            if (results.multiFaceLandmarks) {
                drawFaceMesh(results);
                if (!detectionPaused) {
                    checkForMultipleFaces(results);
                }
            } else {
                if (!detectionPaused) {
                    checkForNoFaces();
                }
            }
            canvasCtx.restore();
        }

        function drawFaceMesh(results) {
            for (const landmarks of results.multiFaceLandmarks) {
                //drawConnectors(canvasCtx, landmarks, FACEMESH_TESSELATION, { color: '#C0C0C070', lineWidth: 1 });
                //drawConnectors(canvasCtx, landmarks, FACEMESH_RIGHT_EYE, { color: '#E0E0E0', lineWidth: 1 });
                //drawConnectors(canvasCtx, landmarks, FACEMESH_RIGHT_EYEBROW, { color: '#E0E0E0', lineWidth: 1 });
                //drawConnectors(canvasCtx, landmarks, FACEMESH_LEFT_EYE, { color: '#E0E0E0', lineWidth: 1 });
                //drawConnectors(canvasCtx, landmarks, FACEMESH_LEFT_EYEBROW, { color: '#E0E0E0', lineWidth: 1 });
                //drawConnectors(canvasCtx, landmarks, FACEMESH_FACE_OVAL, { color: '#E0E0E0', lineWidth: 1 });
                //drawConnectors(canvasCtx, landmarks, FACEMESH_LIPS, { color: '#E0E0E0', lineWidth: 1 });
            }
        }

        function checkForMultipleFaces(results) {
            if (results.multiFaceLandmarks.length > 1) {
                if (isChecking) {
                    console.log("ANOMALÍA DETECTADA: Hay más de 1 rostro en la cámara del usuario");
                    captureAndSendScreenshot(1); // Tipo de anomalia 1: Más de una persona detectada
                    isChecking = false;
                }
            } else {
                if (!isChecking) {
                    startFaceCheck();
                }
            }
        }

        function checkForNoFaces() {
            if (isChecking) {
                console.log("ANOMALÍA DETECTADA: No se detecta ningún rostro en la cámara del usuario");
                captureAndSendScreenshot(2); // Tipo de anomalia 2: No se detecta ningún rostro
                isChecking = false;
            }
        }

        const bloqueo = document.getElementById('bloqueo');
        const motivo = document.getElementById('motivo');

        function activarBloqueo(razon) {
            bloqueo.classList.remove('hidden');
            if (razon == 'nf') {
                motivo.textContent = 'No se detectan rostros en la pantalla';
            } else {
                motivo.textContent = 'Mas de un rostro detectado en la pantalla';
            }
        }

        function desactivarBloqueo() {
            bloqueo.classList.add('hidden');
        }

        function startFaceCheck() {
            isChecking = true;
        }

        function pauseDetection() {
            detectionPaused = true;
            setTimeout(() => {
                detectionPaused = false;
                startFaceCheck();
            }, 30000); // Pausa la detección por 30 segundos
        }

        function captureAndSendScreenshot(tipoAnomalia) {
            const imageData = out2.toDataURL('image/jpeg');
            fetch('{{ route("guardar_foto_anomalia") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    image: imageData,
                    tipo_anomalia_id: tipoAnomalia,
                    ejecucion_id: ejecucionId
                })
            }).then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    pauseDetection();
                }).catch((error) => {
                    console.error('Error:', error);
                });
        }

        const faceMesh = new FaceMesh({
            locateFile: (file) => {
                return `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh@0.1/${file}`;
            }
        });
        faceMesh.onResults(onResultsFaceMesh);

        async function joinRoom() {
            const roomName = '{{ $ejecucion_id }}'; // Usar el ID de ejecución directamente

            const response = await fetch('/video/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ identity: studentName, room: roomName })
            });

            if (!response.ok) {
                const errorData = await response.json();
                alert('Error: ' + errorData.error);
                return;
            }

            const data = await response.json();
            const token = data.token;

            Twilio.Video.createLocalVideoTrack({
                width: 640
            }).then(localVideoTrack => {
                video2.srcObject = new MediaStream([localVideoTrack.mediaStreamTrack]);

                const camera = new Camera(video2, {
                    onFrame: async () => {
                        await faceMesh.send({
                            image: video2
                        });
                    },
                    width: 512,
                    height: 512
                });
                camera.start();

                Twilio.Video.connect(token, {
                    tracks: [localVideoTrack]
                });
            });
        }

        new ControlPanel(controlsElement2, {
            maxNumFaces: 5,
            minDetectionConfidence: 0.5,
            minTrackingConfidence: 0.5
        })
            .add([
                fpsControl
            ])
            .on(options => {
                faceMesh.setOptions(options);
            });

        startFaceCheck();

        // Conectar automáticamente cuando se carga la página
        document.addEventListener('DOMContentLoaded', (event) => {
            joinRoom();
        });

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                console.log('La ventana está minimizada o el usuario ha cambiado de pestaña.');
            } else {
                console.log('La ventana está activa.');
            }
        });
    </script>
</body>
</html>
