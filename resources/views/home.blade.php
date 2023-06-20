@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Dashboard') }}</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            {{ __('You are logged in!') }}
          </div>
        </div>

        <div class="card-body">
          <ul class="navbar-nav mx-auto mt-2 mt-lg-10">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('fetchall') }}">
                <h4>
                    Go to ToDo List...
                </h4>
            </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection
