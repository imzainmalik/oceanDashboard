@extends('layouts.app')
@section('content')
    <style>
        .bg-dark {
            background-color: #21252966 !important;
        }
    </style>
    <style>
        :root {
            --bg: #0f1724;
            --card: #0b1220;
            --accent: #5eead4;
            --muted: #94a3b8;
            --glass: rgba(255, 255, 255, 0.04);
        }

        /* player container */
        .audio-player {
            max-width: 100%;
            background: linear-gradient(180deg, #071024, #021018) !important;
            margin: 24px auto;
            padding: 18px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.6);
            color: #e6eef6;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            display: flex;
            gap: 18px;
            align-items: center;
        }

        /* album / thumbnail */
        .audio-thumb {
            width: 96px;
            height: 96px;
            border-radius: 8px;
            background: linear-gradient(135deg, #081226 0%, #0b2638 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex: 0 0 96px;
        }

        .audio-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* main controls column */
        .audio-main {
            flex: 1;
            min-width: 0;
        }

        .audio-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin: 0 0 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .audio-sub {
            font-size: 0.85rem;
            color: var(--muted);
            margin: 0 0 12px;
        }

        /* controls row */
        .controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-play {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: linear-gradient(180deg, #062131, #05304a);
            border: 1px solid rgba(255, 255, 255, 0.03);
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: transform .12s ease, box-shadow .12s ease;
            flex: 0 0 56px;
        }

        .btn-play:active {
            transform: scale(.98);
        }

        .btn-play svg {
            width: 22px;
            height: 22px;
            fill: var(--accent);
        }

        /* progress */
        .progress-wrap {
            flex: 1;
            min-width: 0;
        }

        .progress {
            position: relative;
            height: 8px;
            background: var(--glass);
            border-radius: 999px;
            overflow: hidden;
            cursor: pointer;
        }

        .progress>.bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent), #60a5fa);
            transition: width .08s linear;
        }

        .progress .knob {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 4px 12px rgba(2, 6, 23, 0.6);
            left: 0%;
            pointer-events: none;
            opacity: 0;
            transition: opacity .12s ease, left .08s linear;
        }

        .progress:hover .knob {
            opacity: 1;
            pointer-events: auto;
        }

        /* time and extra controls */
        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
            font-size: 0.85rem;
            color: var(--muted);
        }

        .meta-left {
            display: flex;
            gap: 14px;
            align-items: center;
            min-width: 0;
        }

        .meta-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* volume / download buttons */
        .icon-btn {
            background: transparent;
            border: 0;
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 6px 8px;
            border-radius: 8px;
        }

        .icon-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.02);
        }

        /* volume slider */
        .vol-slider {
            width: 100px;
            accent-color: var(--accent);
        }

        @media (max-width:640px) {
            .audio-player {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 14px;
            }

            .audio-thumb {
                margin: 0 auto;
            }

            .btn-play {
                width: 48px;
                height: 48px;
            }

            .vol-slider {
                width: 80px;
            }
        }
    </style>
    <div class="content-card">
        <div class="container-fluid p-0">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="content">
                            <h3>Family owner Dashboard</h3>
                        </div>
                    </div>
                    <div class="col-md-7 text-md-end">
                        <div class="addBtns">
                            {{-- <a href="javascript:;" class="btn btn-secondary"><i class="fab fa-plus"></i> Add
                                Information</a> --}}
                            <a href="{{ route('familyOwner.tasks.index') }}" class="btn btn-secondary"><i
                                    class="fab fa-plus"></i> Add
                                Task</a>
                            <a href="{{ route('familyOwner.add_member') }}" class="btn btn-secondary"><i
                                    class="fab fa-plus"></i> Add
                                Member</a>
                        </div>
                    </div>
                </div>
            </div>

            @if ($voice_notes != null) 
                <div class="audio-player" id="custom-audio">
                    <div class="audio-thumb" aria-hidden="true">
                        <img src="{{ asset('display_picture/' . $senior->user->d_pic . ' ') }}" alt="thumbnail">
                    </div>

                    <div class="audio-main">
                        <div class="audio-title" id="audio-title">{{ $voice_notes->title ?? 'Voice Note' }}</div>
                        <div class="audio-sub" id="audio-sub">Recorded by: {{ $senior->user->name }}</div>

                        <div class="controls" role="group" aria-label="Audio controls">
                            <button class="btn-play" id="playBtn" title="Play / Pause" aria-pressed="false">
                                <!-- Play icon (switches to pause in JS) -->
                                <svg viewBox="0 0 24 24" id="playIcon">
                                    <path d="M6 4.5v15l13-7.5z"></path>
                                </svg>
                            </button>

                            <div class="progress-wrap" id="progressWrap">
                                <div class="progress" id="progressBar" aria-valuemin="0" aria-valuemax="100"
                                    role="progressbar" tabindex="0">
                                    <div class="bar" id="bar"></div>
                                    <div class="knob" id="knob" aria-hidden="true"></div>
                                </div>

                                <div class="meta">
                                    <div class="meta-left">
                                        <div id="currentTime">00:00</div>
                                        <div id="duration">/ 00:00</div>
                                    </div>

                                    <div class="meta-right">
                                        <input type="range" id="volume" class="vol-slider" min="0"
                                            max="1" step="0.01" value="1" aria-label="Volume">
                                        <button class="icon-btn" id="downloadBtn" title="Download">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                <path d="M7 10l5 5 5-5" />
                                                <path d="M12 15V3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- hidden native audio -->
                    <audio id="audio" preload="metadata"
                        src="{{ asset('storage/' . $voice_notes->file_path) }}"></audio>
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    @if ($senior != null)
                        <div class="primary-card overview-card">
                            <div class="primary-card-header">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5>Elder’s Overview</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="profile-card">
                                        <img src="{{ asset('display_picture/' . $senior->user->d_pic) }}" alt="">
                                        <h6>{{ $senior->user->name }}</h6>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="profile-border-card">
                                        <div class="img">
                                            <img src="{{ asset('caregiver/assets/images/eo1.png') }}" alt="">
                                        </div>
                                        <div class="txt">
                                            <span> Gender </span>
                                            <p>{{ $senior->gender }}</p>
                                        </div>

                                    </div>

                                    <div class="profile-border-card">
                                        <div class="img">
                                            <img src="{{ asset('caregiver/assets/images/eo2.png') }}" alt="">
                                        </div>
                                        <div class="txt">
                                            <span> Age </span>
                                            <p>{{ Carbon\Carbon::parse($senior->dob)->age }} y.o.</p>
                                        </div>

                                    </div>

                                    <div class="profile-border-card">
                                        <div class="img">
                                            <img src="{{ asset('caregiver/assets/images/eo3.png') }}" alt="">
                                        </div>
                                        <div class="txt">
                                            <span> Blood Type </span>
                                            <p>{{ $senior->blood_type }}</p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="seeMore">
                                <a href="javascript:;" class="btn btn-secondary">See all information</a>
                            </div>

                        </div>
                    @else
                        <div class="card shadow-sm border-0 mb-4 position-relative">
                            <!-- Overlay -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 
                            d-flex justify-content-center align-items-center text-white fw-bold"
                                style="z-index: 10;">
                                No Senior Found
                            </div>

                            <!-- Header -->
                            <div class="card-header text-white">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="mb-0">Elder’s Overview</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-0">
                                <!-- Profile Image + Name -->
                                <div class="col-lg-6 d-flex justify-content-center align-items-center p-3">
                                    <div class="text-center">
                                        <img src="{{ asset('family_owner/assets/images/user_not_found.png') }}"
                                            alt="Elder Image" class="rounded-circle mb-2">
                                        <h6 class="mb-0">Elder Name</h6>
                                    </div>
                                </div>

                                <!-- Details -->
                                <div class="col-lg-6 p-3">
                                    <div class="d-flex align-items-center border rounded p-2 mb-2">
                                        <img src="{{ asset('caregiver/assets/images/eo1.png') }}" class="me-2"
                                            alt="icon">
                                        <div>
                                            <span class="text-muted d-block">Gender</span>
                                            <p class="mb-0">N/A</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center border rounded p-2 mb-2">
                                        <img src="{{ asset('caregiver/assets/images/eo2.png') }}" class="me-2"
                                            alt="icon">
                                        <div>
                                            <span class="text-muted d-block">Age</span>
                                            <p class="mb-0">N/A</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center border rounded p-2">
                                        <img src="{{ asset('caregiver/assets/images/eo3.png') }}" class="me-2"
                                            alt="icon">
                                        <div>
                                            <span class="text-muted d-block">Blood Type</span>
                                            <p class="mb-0">N/A</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer text-center">
                                <a href="#" class="btn btn-secondary">See all information</a>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="primary-card request-card">
                        <div class="primary-card-header">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5>Request & Response</h5>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="orderTable table-responsive">
                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th> Name </th>
                                                <th> Task </th>
                                                <th> Assigned On </th>
                                                <th> Status </th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($requests as $task)
                                                <tr>
                                                    <td>
                                                        <div class="user">
                                                            <img src="{{ $task->assignee->d_pic
                                                                ? asset('display_picture/' . $task->assignee->d_pic)
                                                                : asset('caregiver/assets/images/default.png') }}"
                                                                alt="">
                                                            <p>{{ $task->assignee->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td>{{ $task->title }}</td>
                                                    <td><span
                                                            class="date">{{ $task->created_at->format('d-m-Y') }}</span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'accepted' => 'badge-green',
                                                                'unread' => 'badge-purple',
                                                                'declined' => 'badge-red',
                                                                'seen_no_response' => 'badge-yellow',
                                                                'pending' => 'badge-gray',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge-table {{ $statusColors[$task->status] ?? 'badge-gray' }}">
                                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btnIconDetail">
                                                            <button type="button" class="dropdown-toggle"
                                                                data-bs-toggle="dropdown" data-bs-display="static"
                                                                aria-expanded="false">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('familyOwner.tasks.edit', $task->id) }}">Edit</a>
                                                                </li>
                                                                <li><a class="dropdown-item" href="javascript:;"
                                                                        onclick="deleteTask({{ $task->id }})">Delete</a>

                                                                    <form method=""></form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No requests found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-8">
                    <div class="primary-card">
                        <div class="primary-card-header">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5>Assigned Roles Tracker</h5>
                                </div>
                            </div>
                        </div>
                        <div class="orderTable table-responsive">
                            <table class="table">
                                <tbody>
                                    @forelse($requests as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>

                                            <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>

                                            <td><span class="date">{{ $task->created_at->format('d-m-Y') }}</span></td>

                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'accepted' => 'badge-green',
                                                        'unread' => 'badge-purple',
                                                        'declined' => 'badge-red',
                                                        'seen_no_response' => 'badge-yellow',
                                                        'pending' => 'badge-gray',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge-table {{ $statusColors[$task->status] ?? 'badge-gray' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <div class="btn-group btnIconDetail">
                                                    <button type="button" class="dropdown-toggle"
                                                        data-bs-toggle="dropdown" data-bs-display="static"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('familyOwner.tasks.edit', $task->id) }}">Edit</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:;"
                                                                onclick="deleteTask({{ $task->id }})">Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No tasks available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="primary-card family-card">
                        <div class="primary-card-header">
                            <div class="row">
                                <div class="col-md-11">
                                    <h5>Family Notes & Feedback</h5>
                                </div>
                            </div>
                        </div>

                        <div class="primary-card-body">
                            @if ($notes->count() > 0)
                                @foreach ($notes as $note)
                                    <div class="notes">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <p><b>{{ $note->title }}</b></p> <br>
                                                <p>{{ $note->content }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@push('js')
    <script>
        function deleteTask(id) {
            Swal.fire({
                title: 'Warning!',
                text: 'This action can\'t be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>


    <script>
        (function() {
            const audio = document.getElementById('audio');
            const playBtn = document.getElementById('playBtn');
            const playIcon = document.getElementById('playIcon');
            const bar = document.getElementById('bar');
            const knob = document.getElementById('knob');
            const progressBar = document.getElementById('progressBar');
            const currentTimeEl = document.getElementById('currentTime');
            const durationEl = document.getElementById('duration');
            const volume = document.getElementById('volume');
            const downloadBtn = document.getElementById('downloadBtn');

            // format seconds => mm:ss
            function fmt(t) {
                if (isNaN(t) || t === Infinity) return '00:00';
                const m = Math.floor(t / 60).toString().padStart(2, '0');
                const s = Math.floor(t % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            }

            // update duration when metadata loaded
            audio.addEventListener('loadedmetadata', () => {
                durationEl.textContent = '/ ' + fmt(audio.duration);
            });

            // update progress
            audio.addEventListener('timeupdate', () => {
                const pct = (audio.currentTime / audio.duration) * 100 || 0;
                bar.style.width = pct + '%';
                knob.style.left = pct + '%';
                currentTimeEl.textContent = fmt(audio.currentTime);
            });

            // play/pause toggle
            function setPlaying(val) {
                playBtn.setAttribute('aria-pressed', String(val));
                if (val) {
                    playIcon.innerHTML = '<path d="M5 4h4v16H5zM15 4h4v16h-4z"></path>'; // pause
                } else {
                    playIcon.innerHTML = '<path d="M6 4.5v15l13-7.5z"></path>'; // play
                }
            }

            playBtn.addEventListener('click', () => {
                if (audio.paused) {
                    audio.play();
                    setPlaying(true);
                } else {
                    audio.pause();
                    setPlaying(false);
                }
            });

            audio.addEventListener('play', () => setPlaying(true));
            audio.addEventListener('pause', () => setPlaying(false));
            audio.addEventListener('ended', () => setPlaying(false));

            // seek on click
            progressBar.addEventListener('click', (e) => {
                const rect = progressBar.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const pct = Math.max(0, Math.min(1, x / rect.width));
                if (!isNaN(audio.duration)) audio.currentTime = pct * audio.duration;
            });

            // keyboard accessibility: space toggles play
            progressBar.addEventListener('keydown', (e) => {
                if (e.code === 'Space' || e.key === ' ') {
                    e.preventDefault();
                    if (audio.paused) audio.play();
                    else audio.pause();
                }
            });

            // volume
            volume.addEventListener('input', (e) => {
                audio.volume = parseFloat(e.target.value);
            });

            // download
            downloadBtn.addEventListener('click', () => {
                const src = audio.currentSrc || audio.src;
                const a = document.createElement('a');
                a.href = src;
                a.download = (document.getElementById('audio-title').textContent || 'audio') + '.mp3';
                document.body.appendChild(a);
                a.click();
                a.remove();
            });

            // initialize times if ready
            if (audio.readyState >= 1) durationEl.textContent = '/ ' + fmt(audio.duration);
        })();
    </script>
@endpush
