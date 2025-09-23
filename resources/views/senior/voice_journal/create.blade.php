@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h3>🎤 Record / Upload Voice Journal</h3>

        <form method="POST" action="{{ route('senior.voice-journal.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Title (optional)</label>
                <input type="text" name="title" class="form-control">
            </div>

            <div class="mb-3">
                <label>Upload Voice File</label>
                <input type="file" name="recorded_voice" class="form-control" accept="audio/*">
            </div>

            <hr>
            <h5>Or Record New Voice Note</h5>
            <div class="mb-3">
                <button type="button" class="btn btn-primary" id="startRecord">Start Recording</button>
                <button type="button" class="btn btn-danger" id="stopRecord" disabled>Stop Recording</button>
            </div>

            <audio id="audioPreview" controls class="d-none"></audio>
            <input type="hidden" name="recorded_voice" id="recordedVoiceInput">

            <button class="btn btn-success mt-3">Save</button>
            <a href="{{ route('senior.voice-journal.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
@endsection

@push('js')
    <script>
        let mediaRecorder;
        let audioChunks = [];

        document.getElementById("startRecord").addEventListener("click", async () => {
            audioChunks = [];
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: true
            });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = e => {
                audioChunks.push(e.data);
            };

            console.log(mediaRecorder, audioChunks);

            mediaRecorder.onstop = e => {
                const blob = new Blob(audioChunks, {
                    type: 'audio/webm'
                });
                const audioUrl = URL.createObjectURL(blob);

                const audioPreview = document.getElementById("audioPreview");
                audioPreview.src = audioUrl;
                audioPreview.classList.remove("d-none");

                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    document.getElementById("recordedVoiceInput").value = reader.result;
                }
            };

            mediaRecorder.start();
            document.getElementById("startRecord").disabled = true;
            document.getElementById("stopRecord").disabled = false;
        });

        document.getElementById("stopRecord").addEventListener("click", () => {
            mediaRecorder.stop();
            document.getElementById("startRecord").disabled = false;
            document.getElementById("stopRecord").disabled = true;
        });
    </script>
@endpush
