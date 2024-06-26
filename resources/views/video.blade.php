<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call</title>
    <script src="https://sdk.twilio.com/js/video/releases/2.14.0/twilio-video.min.js"></script>
</head>
<body>
    <h1>Video Call</h1>
    <input type="text" id="room-name" placeholder="Enter Room Name">
    <button onclick="startVideoCall()">Join Room</button>
    <div id="local-video"></div>
    <div id="remote-video"></div>

    <script>
        async function startVideoCall() {
            const roomName = document.getElementById('room-name').value;

            const response = await fetch('/video/token', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ identity: 'user-{{ auth()->user()->id }}', room: roomName })
            });

            const data = await response.json();
            const token = data.token;

            Twilio.Video.createLocalTracks({
                audio: true,
                video: { width: 640 }
            }).then(localTracks => {
                const localVideoTrack = localTracks.find(track => track.kind === 'video');
                document.getElementById('local-video').appendChild(localVideoTrack.attach());

                Twilio.Video.connect(token, {
                    name: roomName,
                    tracks: localTracks
                }).then(room => {
                    room.participants.forEach(participant => {
                        participant.tracks.forEach(publication => {
                            if (publication.isSubscribed) {
                                const track = publication.track;
                                document.getElementById('remote-video').appendChild(track.attach());
                            }
                        });
                    });

                    room.on('participantConnected', participant => {
                        participant.tracks.forEach(publication => {
                            if (publication.isSubscribed) {
                                const track = publication.track;
                                document.getElementById('remote-video').appendChild(track.attach());
                            }
                        });
                    });

                    room.on('trackSubscribed', (track, publication, participant) => {
                        document.getElementById('remote-video').appendChild(track.attach());
                    });
                });
            });
        }
    </script>
</body>
</html>
