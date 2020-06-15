@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="text" class="form-control" id="password">
      </div>
      <button type="button" id="sub-btn" class="btn btn-primary">Submit</button>
    </div>
  </div>
</div>
@endsection