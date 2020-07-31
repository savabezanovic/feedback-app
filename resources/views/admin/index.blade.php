@extends('layouts.master')

@section('users')

<div class="user-box">
    <div class="user">
        <img src="{{auth()->user()->profile->picture}}" class="user-image js-admin-profile-picture" >
        <div class="user-status js-logged-admin" id="{{auth()->user()->id}}">
            <form action="{{route('logout')}}" method="POST">
                @csrf
                <p class="user-name">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</p>
                <span><button type="submit" class="logout-btn">Log out</button></span>
            </form>
        </div>
    </div>
</div>

@endsection

@section('content')
@component('components.alert')
@slot('class')
warning
@endslot
@slot('title')
Warning Message
@endslot
Please input correct data!
@endcomponent


@if(!auth()->user()->active)
<h2 class="admin-title">Your account is temporarily deactivated</h2>
@elseif (!auth()->user()->company->active)
<h2 class="admin-title">Your company is temporarily deactivated</h2>
@else

<div class="admin-profile-form-container">
    <h1 class="admin-profile-form-title">Welcome to your admin dashboard,{{auth()->user()->first_name}}:</h1>
    <div class="company-users-table-container">
        <div class="company-users-table-scroll">
            <table class="company-users-table">
                <thead class="company-users-table-head">
                    <th class="company-users-table-head-content"><span>First Name</span></th>
                    <th class="company-users-table-head-content"><span>Last Name</span></th>
                    <th class="company-users-table-head-content"><span>Email</span></th>
                    <th class="company-users-table-head-content"><span>Position</span></th>
                    <th class="company-users-table-head-content"><span>Status</span></th>
                    <th class="company-users-table-head-content"><span>Options</span></th>
                </thead>
                <tbody class="company-users-table-body js-admins-list">

                </tbody>
            </table>
        </div>
    </div>
    <div class="admin-edit-user-form-container js-edit-user-form">
        <form class="admin-edit-user-form">
            <div class="admin-edit-user-form-close js-admin-edit-user-close">&#10006;</div>
            <div class="admin-edit-user-form-title">EDIT USER FORM</div>
            <label class="admin-user-input-label js-input-textarea-label" name="first-name-edit" for="edit-first-name">First Name</label>
            <input type="text" placeholder="First Name" class="admin-user-input js-input-textarea js-edit-fname js-edit-user-input" id="edit-first-name" name="first-name-edit">
            <div name="first-name-edit" class="admin-user-edit-error js-edit-error">First name is requiered</div>
            <label class="admin-user-input-label js-input-textarea-label" name="last-name-edit" for="edit-last-name">Last name</label>
            <input type="text" placeholder="Last Name" class="admin-user-input js-input-textarea js-edit-lname js-edit-user-input" id="edit-last-name" name="last-name-edit">
            <div name="last-name-edit" class="admin-user-edit-error js-edit-error">Last name is requiered</div>
            <label class="admin-user-input-label js-input-textarea-label" name="email-edit" for="edit-email">Email</label>
            <input type="email" placeholder="Email" class="admin-user-input js-input-textarea js-edit-mail js-edit-user-input" name="email-edit" id="edit-email">
            <div name="email-edit" class="admin-user-edit-error js-edit-error">Email is requiered</div>
            <input type="hidden" name="hidden_user_id" id="hidden_user_id">
            <label class="admin-user-input-label js-input-textarea-label " name="user-password" for="password1">Password</label>
            <input type="password" name="user-password" id="password1" placeholder="New password" class="admin-user-input js-input-textarea js-edit-user-input">
            <div name="email-edit" class="admin-user-edit-error js-edit-error-password">Passowrds must match</div>
            <label  class="admin-user-input-label js-input-textarea-label" name="edit-password-confirmation" for="password-confirm1">Password Confirm</label>
            <input type="password" name="edit-password-confirmation" id="password-confirm1" placeholder="Confirm new password" class="admin-user-input js-input-textarea js-edit-user-input">
            <div name="email-edit" class="admin-user-edit-error js-edit-error-password">Passowrds must match</div>
            <label class="admin-user-input-label admin-user-input-label-visible" for="job-title">Positions:</label>
            <select name="job-title" id="update-job-title" class="admin-add-new-user-select" required>
                @forelse($positions as $position)

                <option value="{{$position->id}}">
                    {{$position->name}}
                </option>

                @empty

                <option disabled>No positions</option>

                @endforelse

            </select>
          
            <label for="file" class="admin-add-new-user-select-label">Change image for the user:</label>
            <label for="file" class="admin-add-new-user-image-upload-custom js-image-upload-edit">Upload an image <img class="admin-add-new-user-image-upload-icon" src="images/upload-icon.png" alt="upload"></label>
            <span class="hidden js-error-edit-user-picture"><br>add pic greska<br></span>
            <button class="admin-edit-user-form-button js-update-user">Update</button>

            {{-- <form name="picture-form" id="picture-form" enctype="multipart/form-data">--}}
                        <label for="add-img" style="display: none;">Add profile picture</label>
                        <br>
                        <form  action="" method="post" enctype="multipart/form-data">
                            <input type="file" name="file" id="file" style="display: none;" accept="image/x-png,image/gif,image/jpeg">
                        </form>
                        {{-- </form>--}}

        </form>
    </div>
    <div class="admin-options-container">
        <form id="form" action="" method="post" enctype="multipart/form-data" class="admin-add-new-user-form">
            <div class="admin-forms-title">Add a new user to the team</div>
            <label for="first-name" class="admin-user-input-label js-input-textarea-label" name="first_name">First Name</label>
            <input type="text" class="admin-user-input js-input-textarea" id="first-name" name="first_name" placeholder="First Name" />
            <span class="hidden js-error-first-name"><br><br></span>
            <label for="last-name" class="admin-user-input-label js-input-textarea-label" name="last_name">Last Name</label>
            <input type="text" class="admin-user-input js-input-textarea" id="last-name" name="last_name" placeholder="Last Name" />
            <span class="hidden js-error-last-name"><br><br></span>
            <label for="email" class="admin-user-input-label js-input-textarea-label" name="email">Email</label>
            <input type="email" class="admin-user-input js-input-textarea" id="email" name="email" placeholder="E-Mail" />
            <span class="hidden js-error-email"><br><br></span>
            <input type="hidden" name="company_id" id="company-id" value="{{auth()->user()->company_id}}">
            <label for="password" class="admin-user-input-label js-input-textarea-label" name="password">Pasword</label>
            <input class="input-clear admin-user-input js-input-textarea" type="password" name="password" id="password" placeholder="User password">
            <span class="hidden js-error-password"><br><br></span>
            <label for="password_confirmation" class="admin-user-input-label js-input-textarea-label" name="password_confirmation">Confirm Password</label>
            <input class="input-clear admin-user-input js-input-textarea" type="password" name="password_confirmation" id="password-confirm" placeholder="Confirm password">
            <label for="job-title" class="admin-add-new-user-select-label">Select position for the new user:</label>
            <select name="job_title_id" id="job-title" class="admin-add-new-user-select">
                @forelse($positions as $position)
                <option class="admin-add-new-user-select-option" value="{{$position->id}}">
                    {{$position->name}}
                </option>
                @empty
                <option disabled>No positions</option>
                @endforelse
            </select>
            <label for="image" class="admin-add-new-user-select-label">Upload an image for the new user:</label>
            <label for="image" class="admin-add-new-user-image-upload-custom js-image-upload-custom">Upload an image <img class="admin-add-new-user-image-upload-icon" src="images/upload-icon.png" alt="upload"></label>
            <input type="file" name="image" id="image" class="admin-add-new-user-image-upload js-image-upload" accept="image/x-png,image/gif,image/jpeg" />
            <span class="hidden js-error-picture"><br><br></span>
            <button type="submit" class="admin-add-new-user-button js-add-user">Add user</button>
        </form>
        <div class="admin-stats-time-container">
            <div class="admin-user-stats-container">
                <div class="admin-forms-title">Users statistics</div>
                <div class="admin-user-stats">Active users:<div class="admin-user-stats-info">{{count(auth()->user()->company->users())}}</div>
                </div>
                <div class="admin-user-stats">Inactive users:<div class="admin-user-stats-info">{{count(auth()->user()->company->inactiveUsers())}}</div>
                </div>
                <div class="admin-user-stats">Highest rating:<div class="admin-user-stats-info">
                    @isset($highest['user']) {{$highest['user']}} @endisset 
                    @empty($highest['user']) No User @endempty
                    @isset($highest['score']) ({{$highest['score']}}) @endisset
                    @empty($highest['score']) No Score @endempty
                </div>
                </div>
                <div class="admin-user-stats">Lowest rating:<div class="admin-user-stats-info">
                    @isset($lowest['user']) {{$lowest['user']}} @endisset 
                    @empty($lowest['user']) No User @endempty
                    @isset($lowest['score']) ({{$lowest['score']}}) @endisset
                    @empty($lowest['score']) No Score @endempty
                </div>
                </div>
            </div>
            <form class="admin-feedback-time-form">
                <div class="admin-forms-title">Change duration of feedbacks</div>
                <div class="admin-feedback-time-form-select-container">
                    <select name="feedback_time" id="feedback-time" class="admin-feedback-time-form-select">
                        @foreach($durations as $duration)
                        <option value="{{$duration->id}}">
                            {{$duration->name}} @if(auth()->user()->company->feedback_duration_id === $duration->id) -active @endif
                        </option>
                        @endforeach
                    </select>
                    <button data-id="{{auth()->user()->company->id}}" class="admin-feedback-time-form-button admin-btn-feedback-duration">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endif

@endsection


@section('script')
<script>
    document.querySelectorAll('.js-input-textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            if (this.tagName === "TEXTAREA") {
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

    document.querySelector('.js-image-upload').addEventListener("change", function() {
        if (this.value !== "") {
            document.querySelector('.js-image-upload-custom').innerHTML = `Image uploaded<img class="admin-add-new-user-image-upload-icon" src="images/upload-icon.png" alt="upload">`
        }
    })

    document.getElementById("file").addEventListener("change", function() {
        if (this.value !== "") {
            document.querySelector('.js-image-upload-edit').innerHTML = `Image uploaded<img class="admin-add-new-user-image-upload-icon" src="images/upload-icon.png" alt="upload">`
        }
    })



    $(document).ready(function() {
        $(function() {
            $("#tabs").tabs();
        });

        getUsers();

        $('.js-update-user').click(updateUser);

        $(document).on('click', "#delete-user", deleteUser);

        $(document).on('submit', "#form", submitTest);

        $('.js-stats').click(showStats);

        $('.admin-btn-feedback-duration').click(updateFeedbackDurationTime);


        $(document).on('change', "input[name='chk-box']", changeUserStatus);

        testScreen();

        $('.js-show-time-update').click(showTime);

        $('.js-show-new-user').click(showNew);

        $("#uploadimage").click(editImage);

        $('#send').click(notifyUsers);


        $("#chk-box").click(getCheck);

        function getCheck() {
            chk = $("#chk-box").checked ? 1 : 0;
            $.ajax({
                type: 'GET',
                url: '',
                data: {}
            });
        }
    });
</script>
@endsection