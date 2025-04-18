<!DOCTYPE html>
<html>
<head>
    <title>Report Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .task-box {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .collapse-box {
            padding-top: 10px;
        }
        .task-header a {
    cursor: pointer;
}

    </style>
</head>
<body class="p-3">
<div class="container">

@if(Auth::check())
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            👤 Hi {{ Auth::user()->name }}
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
        </form>
    </div>
@endif

<h3 class="mb-3">📅 Daily Detail</h3>

<form method="POST" action="/report">
    @csrf
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="report_date" value="{{ date('Y-m-d') }}" class="form-control" required>
    </div>
    @foreach($allUser as $items)
    <div class="task-box">
        <div class="task-header">
            <!-- 👇 名前もクリック可能に -->
            <a href="#collapse-{{ $items->id }}"
               data-toggle="collapse"
               role="button"
               aria-expanded="false"
               aria-controls="collapse-{{ $items->id }}"
               class="text-dark text-decoration-none fw-bold">
                {{ $items->name }}
            </a>

            <!-- 👇 ボタンも引き続き collapse 対応 -->
            <button class="btn btn-sm btn-primary" type="button"
                    data-toggle="collapse"
                    data-target="#collapse-{{ $items->id }}"
                    aria-expanded="false"
                    aria-controls="collapse-{{ $items->id }}">
                Detail
            </button>
        </div>

        <div class="collapse collapse-box" id="collapse-{{ $items->id }}">
            <div class="card card-body">
                ユーザーID：{{ $items->id }}
                <!-- タスク内容など表示 -->
            </div>
        </div>
    </div>
@endforeach
</form>
</div>

<!-- JSライブラリ -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9cIpjj1z9v+CWtlu41cUu8D89pBqU2QDbQ4rF"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
