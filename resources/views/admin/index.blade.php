@extends('admin.layouts.app')
@section('title', __('Dashboard'))

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total Accounts Registered</p>
                        <h2>{{ $userCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total In-game Characters</p>
                        <h2>{{ $charCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total Amount of Gold</p>
                        <h2>{{ number_format($totalGold , 0, ',')}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <p>Total Amount of Silk</p>
                        <h2>{{ number_format($totalSilk , 0, ',')}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mt-3 mb-3 border-bottom">
            <h1 class="h2">iSRO-CMS Updates</h1>
        </div>

        <div class="row">
            <widgetbot
                server="1004443821570019338"
                channel="1374482240427528254"
                width="100%"
                height="600"
            ></widgetbot>
            <script src="https://cdn.jsdelivr.net/npm/@widgetbot/html-embed"></script>
        </div>
    </div>
@endsection
