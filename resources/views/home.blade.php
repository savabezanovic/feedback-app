@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form id="myForm">
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
        <button class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@endsection