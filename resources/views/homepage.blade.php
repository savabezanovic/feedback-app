@extends('layouts.master')

@section('content')
<div class="login">
    <form action="{{route('login')}}" method="POST" class="login-form-container">
        @csrf
        <h1 class="login-form-title">Log in to provide a feedback</h1>
        <div class="login-form-input-container">
            <label class="login-form-input-label  js-input-textarea-label" name="email" for="mail">Email</label>
            <input class="login-form-input js-input-textarea" type="email" id="mail" name="email" placeholder="email" required>
        </div>
        <div class="login-form-input-container">
            <label class="login-form-input-label js-input-textarea-label" name="password" for="pass">Password</label>
            <input class="login-form-input js-input-textarea" type="password" id="pass" name="password" placeholder="password" required><br>
        </div>
        <input type="submit" class="login-form-submit" value="LOG IN">
    </form>
</div>


@endsection

@section('script')
<script>

document.querySelectorAll('.js-input-textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                if (this.name !== "email" && this.name !== "password") {
                    this.style.height = `auto`;
                    this.style.height = `${this.scrollHeight + (this.offsetHeight - this.clientHeight)}px`;
                }
                if (this.value !== '') {
                    document.querySelectorAll('.js-input-textarea-label').forEach(label => {
                        if (this.name == label.attributes.name.value) {
                            label.style.opacity = 1;
                            label.style.visibility = 'visible';
                        }
                    })
                    this.style.borderColor = '#ec1940';
                } else {
                    document.querySelectorAll('.js-input-textarea-label').forEach(label => {
                        if (this.name == label.attributes.name.value) {
                            label.style.opacity = 0;
                            label.style.visibility = 'hidden';
                        }
                    })
                    this.style.borderColor = '#d3d4d5';
                }
            });
});


</script>
@endsection