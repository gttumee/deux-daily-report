<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <style>
        .task-item {
            border: 1px solid #ccc;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .delete-btn {
            margin-top: 5px;
        }
    </style>
</head>
<body class="p-3">
    <div class="container">
        @if(Auth::check())
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>👤Hi {{ Auth::user()->name }}</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @if (Auth::user()->role === 'admin')
                    <a href="{{route('detail-report')}}"   class="btn btn-sm btn-outline-secondary">View Reports</a>
                    @endif                    
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Log out</button>
                    </form>
            </div>
        @endif
        <h3 class="mb-3">📅Daily Report</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    <form method="GET" action="/report">
      <div class="mb-3">
        <label for="report_date">Select Date</label>
        <input type="date" id="report_date" name="report_date" value="{{ $reportDate }}" class="form-control" required onchange="this.form.submit()">
      </div>
    </form>
    </form>
        <form method="POST" action="/report">
            @csrf
            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="report_date" value="{{ $reportDate }}" class="form-control" style="display: none;">
                </div>
            <div id="task-list">
                @if ($report && $report->tasks->count())
                    @foreach ($report->tasks as $i => $task)
                        <div class="task-item row g-2 align-items-center">
                            <div class="col-12 col-md-4">
                                <input type="text" name="tasks[{{ $i }}][description]" class="form-control"
                                       value="{{ $task->description }}" placeholder="Task" required>
                            </div>
                            <div class="col-6 col-md-2">
                                <input type="time" name="tasks[{{ $i }}][start]" class="form-control"
                                       value="{{ $task->start_time }}" onchange="calcHours(this)" placeholder="hh:mm" required>
                            </div>
                            <div class="col-6 col-md-2">
                                <input type="time" name="tasks[{{ $i }}][end]" class="form-control"
                                       value="{{ $task->end_time }}" onchange="calcHours(this)" placeholder="hh:mm" required>
                            </div>
                            <div class="col-6 col-md-2">
                                <input type="text" name="tasks[{{ $i }}][hours]" class="form-control"
                                       value="{{ $task->hours }}" readonly>
                            </div>
                            <div class="col-6 col-md-2 text-end">
                                <button type="button" class="btn btn-outline-danger delete-btn" onclick="deleteTask(this)">Delete</button>
                            </div>
                        </div>
                    @endforeach
                    @php $taskIndex = $report->tasks->count(); @endphp
                @else
                    {{-- 1つだけ初期タスク --}}
                    <div class="task-item row g-2 align-items-center">
                        <div class="col-12 col-md-4">
                            <input type="text" name="tasks[0][description]" class="form-control" placeholder="Task" required>
                        </div>
                        <div class="col-6 col-md-2">
                            <input type="time" name="tasks[0][start]" class="form-control" onchange="calcHours(this)" placeholder="hh:mm" required>
                        </div>
                        <div class="col-6 col-md-2">
                            <input type="time" name="tasks[0][end]" class="form-control" onchange="calcHours(this)"  placeholder="hh:mm" required>
                        </div>
                        <div class="col-6 col-md-2">
                            <input type="text" name="tasks[0][hours]" class="form-control" placeholder="Total time" readonly>
                        </div>
                        <div class="col-6 col-md-2 text-end">
                            <button type="button" class="btn btn-outline-danger delete-btn" onclick="deleteTask(this)">Delete</button>
                        </div>
                    </div>
                    @php $taskIndex = 1; @endphp
                @endif
            </div>

            <button type="button" class="btn btn-secondary mb-3" onclick="addTask()">+ Add task</button><br>
            <button type="submit" class="btn btn-primary">✅ Submit </button>
        </form>
    </div>

    <script>
        let taskIndex = {{ $taskIndex ?? 1 }}; // Bladeからの値挿入

        function addTask() {
            const taskList = document.getElementById('task-list');
            const html = `
            <div class="task-item row g-2 align-items-center">
                <div class="col-12 col-md-4">
                    <input type="text" name="tasks[${taskIndex}][description]" class="form-control" placeholder="Task" required>
                </div>
                <div class="col-6 col-md-2">
                    <input type="time" name="tasks[${taskIndex}][start]" class="form-control" onchange="calcHours(this)" placeholder="hh:mm" required>
                </div>
                <div class="col-6 col-md-2">
                    <input type="time" name="tasks[${taskIndex}][end]" class="form-control" onchange="calcHours(this)"  placeholder="hh:mm" required>
                </div>
                <div class="col-6 col-md-2">
                    <input type="text" name="tasks[${taskIndex}][hours]" class="form-control" placeholder="Total time" readonly>
                </div>
                <div class="col-6 col-md-2 text-end">
                    <button type="button" class="btn btn-outline-danger delete-btn" onclick="deleteTask(this)">Delete</button>
                </div>
            </div>`;
            taskList.insertAdjacentHTML('beforeend', html);
            taskIndex++;
        }

        function deleteTask(button) {
            const row = button.closest('.task-item');
            row.remove();
        }

        function calcHours(input) {
            const row = input.closest('.task-item');
            const start = row.querySelector('input[name*="[start]"]').value;
            const end = row.querySelector('input[name*="[end]"]').value;
            const hoursField = row.querySelector('input[name*="[hours]"]');

            if (start && end) {
                const startTime = toMinutes(start);
                const endTime = toMinutes(end);
                let diff = (endTime - startTime) / 60;
                if (diff < 0) diff += 24;
                hoursField.value = diff.toFixed(2);
            }
        }

        function toMinutes(t) {
            const [h, m] = t.split(':').map(Number);
            return h * 60 + m;
        }
    </script>
</body>
</html>
