@extends('layouts.master')

@section('users')

    <div class="user-box">
        <div class="user">
            <img src="https://source.unsplash.com/random" class="user-image">
            <div class="user-status">
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

        <div class="admin">

            <div class="edit-user-modal js-user-modal">
                <div class="edit-title">EDIT USER<button class="close-btn edit-btn js-edit-user-close"><i class="fas fa-times"></i></button></div>
                <div class="edit-form-admin">
                    <div>
                        <label>First name</label>
                        <input class="js-edit-fname" type="text">
                        <span class="hidden js-error-edit-user-first-name"><br>first name greska<br></span>
                        <br>
                        <label>Last name</label>
                        <input class="js-edit-lname" type="text">
                        <span class="hidden js-error-edit-user-last-name"><br>last name greska<br></span>
                        <br>
                        <label>User email</label>
                        <input class="js-edit-mail" type="email">
                        <span class="hidden js-error-edit-user-email"><br>email greska<br></span>
                        <br>
                        <input type="hidden" name="hidden_user_id" id="hidden_user_id">
                        <label for="job-title">Positions:</label>
                        <span>
                        <select name="job-title" id="update-job-title" required>
                        @forelse($positions as $position)

                                <option value="{{$position->id}}">
                                    {{$position->name}}
                                </option>

                            @empty

                                <option disabled>No positions</option>

                            @endforelse

                        </select>
                        </span>
                    </div>
                    <br>
                    <div style="background-color: rgb(139, 139, 139);">
                        {{-- <form name="picture-form" id="picture-form" enctype="multipart/form-data">--}}
                        <label for="add-img">Add profile picture</label>
                        <br>
                        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                            <input type="file" name="file" id="file">
                            <span class="hidden js-error-edit-user-picture"><br>add pic greska<br></span>
                            <button type="submit">Submit</button>
                        </form>
                        {{-- </form>--}}
                    </div>
                    <br>
                    <div style="background-color: rgb(139, 139, 139);">
                        <label style="background-color: rgb(139, 139, 139);" for="user-password">Password</label>
                        <input type="password" name="user-password" id="password1" placeholder="New password">
                        <span class="hidden js-error-edit-user-password"><br>Testttt<br></span>
                        <br><label style="background-color: rgb(139, 139, 139);" for="password_confirmation">Password Confirm</label>
                        <input type="password" name="password_confirmation" id="password-confirm1" placeholder="Confirm new password">
                    </div>
                    <div style="text-align: center;">
                        <button type="button" class="admin-btn js-user-update-password">Update password</button>
                    </div>

                    <div style="text-align: center;">
                        <button class="admin-btn js-update-user">Update</button>
                    </div>
                </div>
            </div>

            <h2 class="admin-title">{{auth()->user()->first_name}}, welcome to admin panel
                <br>
                Company: {{auth()->user()->company->name}}</h2>

            <div id="tabs">
                <ul class="inline-flex tabs">
                    <li class="tab"><a class="admin-tab current-tab" href="#tabs-1">Users</a></li>
                    <li class="tab"><a class="admin-tab" href="#tabs-mail">Send e-mail</a></li>
                </ul>
                <div id="tabs-1" class="js-edit-form tab-view admin-width media-tab">
                    <div class="media-menu">
                        <button class="js-show-new-user admin-btn" style="width: 10vw">New user</button>
                        <button class="js-show-time-update admin-btn" style="width: 10vw; margin-left: 15vw;">Edit time</button>
                        <button class="js-stats admin-btn" style="width: 10vw; margin-left: 15vw;">Statistics</button>
                    </div>
                    <div class="addon-modals">
                        <div class="addon-single-modal">
                            <div class="js-interactive-text js-media-show" style="padding: 5px; border: 1px solid #ec1940; font-size: 2rem;">
                                Add new <br> user to your <br> company
                            </div>
                            <div class="admin-modal js-admin-modal js-media-show media-input" style="padding: 5px; border: 1px solid #ec1940;">
                                <form id="form" action="" method="post" enctype="multipart/form-data">

                                    <input class="input-clear" type="text" name="first_name" id="first-name" placeholder="User first name">
                                    <span class="hidden js-error-first-name"><br><br></span>
                                    <input class="input-clear" type="text" name="last_name" id="last-name" placeholder="User last name">
                                    <span class="hidden js-error-last-name"><br><br></span>
                                    <input class="input-clear" type="email" name="email" id="email" placeholder="User e-mail">
                                    <span class="hidden js-error-email"><br><br></span>
                                    <input type="hidden" name="company_id" id="company-id" value="{{auth()->user()->company_id}}">
                                    <input class="input-clear" type="password" name="password" id="password" placeholder="User password">
                                    <span class="hidden js-error-password"><br><br></span>
                                    <input class="input-clear" type="password" name="password_confirmation" id="password-confirm" placeholder="Confirm password">
                                    <select name="job_title_id" id="job-title" class="media-job-title">
                                        @forelse($positions as $position)

                                            <option value="{{$position->id}}">
                                                {{$position->name}}
                                            </option>

                                        @empty

                                            <option disabled>No positions</option>

                                        @endforelse

                                    </select>
                                    <input type="file" name="image" id="image"/>
                                    <span class="hidden js-error-picture"><br><br></span>
                                    <button type="submit" class="js-add-user admin-btn">Add user</button>
                                </form>

                            </div>
                        </div>
                        <div style="flex-grow: 1;">
                        <div class="js-feedback-interval admin-modal-right admin-style js-media-time" style="font-size: 2rem;">
                                Change your <br> feedback time interval
                            </div>
                            <div id="tabs-2" class="admin-modal2 js-tab-2 admin-style js-media-time">
                                <label for="feedback-time">Change feedback time</label>
                                <select name="feedback_time" id="feedback-time">
                                    @foreach($durations as $duration)

                                        <option value="{{$duration->id}}" @if(auth()->user()->company->feedback_duration_id === $duration->id) selected @endif >{{$duration->name}} </option>

                                        <!-- <label for="add-img">Add profile picture</label>
                                        <br>
                                        <input name="add-img" id="add-img" type='file' />

                                        <button class="admin-btn js-add-user">Add user</button> -->
                                    @endforeach

                                </select>
                                <button data-id="{{auth()->user()->company->id}}" class="admin-btn admin-btn-feedback-duration">Submit</button>
                            </div>
                        </div>
                        <div style="flex-grow: 1;">
                        <div class="js-stats-info admin-style js-media-stats" style=" font-size: 2rem;">
                                Company <br> <hr>
                                Stats
                            </div>
                            <div class="js-statistics hidden-stats admin-style js-media-stats">
                                <span>Active users:{{count(auth()->user()->company->users())}}</span>
                                <br>
                                <span>Inactive users:{{count(auth()->user()->company->inactiveUsers())}}</span>
                                <br>
                                <span>Highest rated<br> {{$highest['user']}} : {{$highest['score']}}</span>
                                <br>
                                <span>Lowest rated<br>{{$lowest['user']}} : {{$lowest['score']}}</span>

                            </div>
                        </div>
                    </div>
                    <table class="admin-table media-table">
                        <thead class="media-thead">
                        <tr>
                            <th style="border: 1px solid #ec1940;position: sticky;top: 0;background-color: #22282d;">First Name</th>
                            <th style="border: 1px solid #ec1940;position: sticky;top: 0;background-color: #22282d;">Last Name</th>
                            <th style="border: 1px solid #ec1940;position: sticky;top: 0;background-color: #22282d;">Email</th>
                            <th style="border: 1px solid #ec1940;position: sticky;top: 0;background-color: #22282d;">Position</th>
                            <th style="border: 1px solid #ec1940;position: sticky;top: 0;background-color: #22282d; z-index:1;">Status</th>
                            <th style="border: 1px solid #ec1940;position: sticky;top: 0;background-color: #22282d;">Options</th>
                        </tr>
                        </thead>
                        <tbody class="js-admins-list">

                        </tbody>
                    </table>
                </div>
                <div id="tabs-mail" class="js-edit-form tab-view admin-width">
                    <h2>Type a message to all your users</h2>
                    <textarea name="message" id="message"style="resize: none; height:30vh;"
                    placeholder="Remember to be nice to your employees"></textarea>
                    <div>
                        <button type="submit" id="send" class="admin-btn">Send</button>
                    </div>
                </div>
            </div>


            </div>

        </div>

    @endif

@endsection


@section('script')
    <script>

        $(document).ready(function () {
            $( function() {
                $( "#tabs" ).tabs();
            } );

            getUsers();

            $('.js-update-user').click(updateUser);

            $('.js-user-update-password').click(updateUserPassword);


            $(document).on('click', "#delete-user", deleteUser);

            $(document).on('submit', "#form", submitTest);

            $('.js-stats').click(showStats);

            $('.admin-btn-feedback-duration').click(updateFeedbackDurationTime);

            $('.js-edit-user-close').click(closeEdit);

            $(document).on('change', "input[name='chk-box']", changeUserStatus);

            testScreen();

            $('.js-show-time-update').click(showTime);

            $('.js-show-new-user').click(showNew);

            $("#uploadimage").submit(editImage);

            $('#send').click(notifyUsers);


            $("#chk-box").click(getCheck);
            function getCheck(){
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
