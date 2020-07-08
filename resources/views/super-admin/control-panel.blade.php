@extends('layouts.master')

@section('users')

    <div class="user-box">
        <div class="user superadmin-media-user">
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
    <div class="admin">
        <h2 class="admin-title">Superadmin panel</h2>

        <div id="tabs">
            <ul class="inline-flex tabs">
                <li class="tab"><a class="admin-tab current-tab" href="#tabs-1">All Companies</a></li>
                <li class="tab"><a class="admin-tab" href="#tabs-2">All Admins</a></li>
                <li class="tab"><a class="admin-tab" href="#tabs-3">All Skills</a></li>
                <li class="tab"><a class="admin-tab" href="#tabs-4">All Job Titles</a></li>
            </ul>
            <div id="tabs-1" class="tab-view media-super-tab">
                    <span>
                        Companies:<br>
                        <input class="js-company-name" value="" placeholder="Add company name">
                        <span class="hidden js-admin-company-name"><br><br></span>
                        <button class="super-admin-btn js-add-company-btn">ADD</button>
                        <input class="search-company" type="search" placeholder="Search company"><i class="js-find-company fas fa-search"></i>
                        <div class="js-companies media-companies-list">
                        </div>
                    </span>
            </div>
            <div id="tabs-2" class="tab-view media-super-tab">
                <span>
                    Admins:<br><button class="js-superadmin-modal-btn js-new-admin-title super-admin-btn">Add new admin</button>
                    <div class="modal superadmin-modal">
                        <input class="js-admin" type="text" name="first-name" id="first-name" placeholder="first name" value="{{old('first_name')}}">
                        <span class="hidden js-error-admin-first-name"><br><br></span>
                        <input class="js-admin" type="text" name="last-name" id="last-name" placeholder="last name" value="{{old('last_name')}}">
                        <span class="hidden js-error-admin-last-name"><br><br></span>
                        <input class="js-admin" type="email" name="email" id="email" placeholder="email address" value="{{old('email')}}">
                        <span class="hidden js-error-admin-email"><br><br></span>
                        <input class="js-admin" type="password" name="password" id="password" placeholder="password" value="{{old('password')}}">
                        <span class="hidden js-error-admin-password"><br><br></span>
                        <input class="js-admin" type="password" name="password_confirmation" id="password-confirm" placeholder="confirm password">
                        <select name="company-id" id="company-id">
                            @forelse($companies as $company)

                                <option value="{{$company->id}}">{{$company->name}}</option>

                            @empty

                                <option disabled>No companies</option>

                            @endforelse
                        </select>
                        <button type="submit" class="super-admin-btn js-add-admin-btn">ADD</button>
                    </div>
                    <div class="js-admins"></div>
                </span>
            </div>
            <div id="tabs-3" class="tab-view media-super-tab">
                    <span>
                        Skills:<br>
                        <input class="js-skill" placeholder="Add new skill">
                        <span class="hidden js-add-skill"><br><br></span>
                        <button class="super-admin-btn js-add-skill-btn">ADD</button>
                        <div class="js-skills"></div>
                    </span>
            </div>
            <div id="tabs-4" class="tab-view media-super-tab">
                    <span>
                        Job Titles:<br>
                        <input name="position-name" class="js-position" value="" placeholder="Add job title">
                        <span class="hidden js-admin-job-title-name"><br><br></span>
                        <button class="super-admin-btn js-add-position-btn">ADD</button>
                        <input class="search-position" type="search" placeholder="Search job titles"><i class="js-find-position fas fa-search"></i>
                        <div class="js-positions">
                        </div>
                        <span class="js-pagination"></span>
                    </span>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="edit-modal">
        <div class="edit-title">EDIT ADMIN<button class="close-btn edit-btn js-edit-close"><i class="fas fa-times"></i></button></div>
        <div class="edit-form">
            <br>
            <span>
            <label for="first_name">First name</label>
            <input id="first_name" name="first_name" type="text">
            <span class="hidden js-error-admin-edit-first-name"><br><br></span>
        </span>
            <br>
            <span>
            <label for="last-name">Last name</label>
            <input id="last_name" name="last-name" type="text">
            <span class="hidden js-error-admin-edit-last-name"><br><br></span>
        </span>
            <br>
            <span>
            <label for="email">Email</label>
            <input id="admin-email" name="email" type="email">
            <span class="hidden js-error-admin-edit-email"><br><br></span>
        </span>
            <br>
            <div style="background-color: rgb(139, 139, 139);">
            <span>
                <label for="password">Password</label>
                <input class="js-admin" type="password" name="password" id="password1" placeholder="New password">
                <span class="hidden js-error-admin-edit-password"><br><br></span>
            </span>
                <br>
                <span>
                <label for="password_confirmation">Password Confirm</label>
                <input class="js-admin" type="password" name="password_confirmation" id="password-confirm1" placeholder="Confirm new password">
            </span>
                <br>
                <button type="button" class="super-admin-btn js-update-password">Update password</button>
            </div>
            <input type="hidden" name="hidden_id" id="hidden_id">
            <div style="width:30vw; text-align:center;">
                <button style="padding: 5px;" type="button" class="super-admin-btn js-edit-admin-btn">Edit</button>
            </div>
        </div>


    </div>

@endsection
@section('script')
    <script>

        $(document).ready(function () {

            $( function() {
                $( "#tabs" ).tabs();
            } );

            getAdmins();

            $('.js-edit-admin-btn').click(updateAdmin);

            getSkills();

            $(document).on('click', ".edit-skill", editSkill);

            $(document).on('click', ".delete-skill", deleteSkill);

            $('.js-add-admin-btn').click(addAdmin);

            $('.js-add-skill-btn').click(addSkill);

            $(document).on('click', ".delete-admin", deleteAdmin);

            $(".js-superadmin-modal-btn").click(getModal);

            $(".js-edit-modal").click(editAdmin);

            $('.js-edit-close').click(closeEdit);

            $('.js-update-password').click(updatePassword);

            getJobTitles();

            $('.js-add-position-btn').click(addJobTitle);

            $(document).on('click', ".edit-position", editJobTitle);

            $(document).on('click', ".delete-position", deleteJobTitle);

            getCompany();

            $('.js-add-company-btn').click(addCompany);

            $(document).on('click', ".delete-company", deleteCompany);

            $(document).on('click', ".edit-company", editCompany);

            //Job Titles Pagination
            $(document).on('click', '.pagination a', getPage);
        });

    </script>
@endsection
