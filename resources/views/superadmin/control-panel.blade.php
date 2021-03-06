@extends('layouts.master')

@section('users')

<div class="feedback-app-navbar-profile-container js-logged-admin" id="{{auth()->user()->id}}">
    <img src="{{auth()->user()->profile->picture}}" alt="profile avatar" class="feedback-app-profile-avatar">
    <div>
        <div class="feedback-app-navbar-profile-name">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</div>
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="feedback-app-navbar-profile-logout">Log out</button>
        </form>
    </div>
</div>

@endsection

@section('content')
<div class="super-admin-container">
    <h1 class="super-admin-welcome">Welcome to the superadmin dashboard, Chosen one</h1>
    <div class="superadmin-forms-container">
        <div class="super-admin-navigation-bar">
            <label for="companies-panel" class="navigation-label js-navigation-label">Companies</label>
            <label for="admins" class="navigation-label js-navigation-label">Admins</label>
            <label for="job-titles" class="navigation-label js-navigation-label">Job Titles</label>
            <label for="skills" class="navigation-label js-navigation-label">Skills</label>
        </div>
        <input type="radio" id="companies-panel" name="navigation-radio" class="navigation-radio js-navigation-radio" checked />
        <div class="navigation-div">
            <h3 class="super-admin-titles">Companies Panel</h3>
            <div class="add-a-company-container">
                <label for="add-a-company" name="add-company" class="add-admin-label add-a-company-label js-input-textarea-label">Add a company</label>
                <input id="add-a-company" name="add-company" class="super-admin-input add-a-company-input js-company-name js-input-textarea" value="" placeholder="Add a company">
                <button class="super-admin-button add-company-button js-add-company-btn">ADD</button>
                <div class="super-admin-add-company-error js-add-company-error "></div>

            </div>
            <div class="add-a-company-container">
                <label for="search-company" name="search-a-company" class="add-admin-label add-a-company-label js-input-textarea-label">Search company</label>
                <input class="super-admin-input super-admin-search-company js-super-search-comapny js-input-textarea" id="search-company" name="search-a-company" type="text" placeholder="Search company">
            </div>
            <div class="all-companies-container js-companies">
            </div>
        </div>

        <input type="radio" id="admins" name="navigation-radio" class="navigation-radio js-navigation-radio" />
        <div class="navigation-div">
            <h3 class="super-admin-titles">Admins Panel</h3>
            <h4 class="super-admin-add-admin-title">All Admins</h4>
            <div class="super-admin-all-admins js-all-admins">
            </div>

            <div class="super-admin-add-admins">
                <h4 class="super-admin-add-admin-title">Add New Admin</h4>

                <div class="add-admin-input-container">
                    <label for="first-name" name="add-admin-first-name" class="add-admin-label js-input-textarea-label js-add-admin-input-label">First Name:</label>
                    <input class="super-admin-add-admins-input js-add-admin-input js-input-textarea" type="text" name="add-admin-first-name" id="first-name" placeholder="First Name" value="{{old('first_name')}}">
                    <div class="super-admin-add-admin-error js-error-add-admin-first-name"></div>
                </div>

                <div class="add-admin-input-container">
                    <label for="last-name" name="add-admin-last-name" class="add-admin-label js-input-textarea-label js-add-admin-input-label">Last Name:</label>
                    <input class="super-admin-add-admins-input js-add-admin-input js-input-textarea" type="text" name="add-admin-last-name" id="last-name" placeholder="Last Name" value="{{old('last_name')}}">
                    <div class="super-admin-add-admin-error js-error-add-admin-last-name"></div>
                </div>
                <div class="add-admin-input-container add-admin-email-container">
                    <label for="email" name="add-admin-email" class="add-admin-label js-input-textarea-label js-add-admin-input-label">Email:</label>
                    <input class="super-admin-add-admins-input js-add-admin-input js-input-textarea" type="email" name="add-admin-email" id="email" placeholder="Email" value="{{old('email')}}">
                    <div class="super-admin-add-admin-error js-error-add-admin-email"></div>
                </div>

                <div class="add-admin-input-container">
                    <label for="password" name="add-admin-password" class="add-admin-label js-input-textarea-label js-add-admin-input-label">Password:</label>
                    <input class="super-admin-add-admins-input js-add-admin-input js-input-textarea" type="password" name="add-admin-password" id="password" placeholder="Password" value="{{old('password')}}">
                    <div class="super-admin-add-admin-error js-error-add-admin-password"></div>
                </div>

                <div class="add-admin-input-container">
                    <label for="password-confirm" name="add-admin-password_confirmation" class="add-admin-label js-input-textarea-label js-add-admin-input-label">Confirm Password:</label>
                    <input class="super-admin-add-admins-input js-add-admin-input js-input-textarea" type="password" name="add-admin-password_confirmation" id="password-confirm" placeholder="Confirm Password">
                </div>
                <div class="add-admin-select-container">
                    <label for="company-id" name="company-id" class="add-admin-label-visible js-input-textarea-label">Company:</label>

                    <select class="super-admin-add-admins-select" name="company-id" id="company-id">
                        @forelse($companies as $company)

                        <option value="{{$company->id}}">{{$company->name}}</option>

                        @empty

                        <option disabled>No companies</option>

                        @endforelse
                    </select>
                </div>
                <button type="submit" class="super-admin-button super-admin-add-admin-button js-add-admin-btn">ADD ADMIN</button>
            </div>
            <div class="edit-admin-form-container js-edit-admin-form">
                <div class="edit-admin-form">
                    <div class="edit-admin-form-close js-edit-admin-form-close">&#10006;</div>
                    <h4 class="super-admin-add-admin-title">Edit Admin</h4>
                    <label for="first_name" name="first_name" class="add-admin-label js-input-textarea-label">First name:</label>
                    <input id="first_name" name="first_name" type="text" class="super-admin-input edit-admin-input js-input-textarea" placeholder="First Name">
                    <div class="super-admin-add-admin-error js-error-admin-edit-first-name"></div>

                    <label for="last-name" name="last-name" class="add-admin-label js-input-textarea-label">Last name:</label>
                    <input id="last_name" name="last-name" type="text" class="super-admin-input edit-admin-input js-input-textarea" placeholder="Last Name">
                    <div class="super-admin-add-admin-error js-error-admin-edit-last-name"></div>

                    <label for="email" name="email" class="add-admin-label js-input-textarea-label">Email:</label>
                    <input id="admin-email" name="email" type="email" class="super-admin-input edit-admin-input js-input-textarea" placeholder="Email">
                    <div class="super-admin-add-admin-error js-error-admin-edit-email"></div>

                    <label for="password1" name="password" class="add-admin-label js-input-textarea-label">Password:</label>
                    <input class="js-admin super-admin-input edit-admin-input js-input-textarea" type="password" name="password" id="password1" placeholder="Password">
                    <div class="super-admin-add-admin-error js-error-admin-edit-password"></div>

                    <label for="password-confirm1" name="password_confirmation" class="add-admin-label js-input-textarea-label">Confirm Passowrd:</label>
                    <input class="js-admin super-admin-input edit-admin-input js-input-textarea" type="password" name="password_confirmation" id="password-confirm1" placeholder="Confirm Passowrd">

                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <button style="padding: 5px;" type="button" class="super-admin-button js-edit-admin-btn">Save Changes</button>
                </div>

                <input type="hidden" name="hidden_id" id="hidden_id">
            </div>
        </div>

        <input type="radio" id="job-titles" name="navigation-radio" class="navigation-radio js-navigation-radio" />
        <div class="navigation-div">
            <h3 class="super-admin-titles">Job Titles Panel</h3>
            <div class="add-job-title-input-container">
                <label for="add-job-title" name="position-name" class="add-admin-label add-a-job-label js-add-job-label js-input-textarea-label">Add a job title</label>
                <input name="position-name" class="super-admin-input super-job-input js-add-job js-input-textarea" placeholder="Add a job title">
                <button class="super-admin-button add-job-button js-add-position-btn">ADD</button>
                <div class="super-admin-add-job-error js-add-job-error"></div>
            </div>
            <label for="search-jobs" name="jobs-search" class="add-admin-label add-a-job-label js-input-textarea-label">Search Jobs</label>
            <input class="super-admin-input super-job-input search-job-input js-search-jobs js-input-textarea" type="text" id="search-jobs" name="jobs-search" placeholder="Search Jobs">
            <h4 class="super-all-jobs-title">All-Jobs</h4>
            <div class="all-jobs-container js-jobs-container">
            </div>
        </div>

        <input type="radio" id="skills" name="navigation-radio" class="navigation-radio js-navigation-radio" />
        <div class="navigation-div">
            <h3 class="super-admin-titles">Skills Panel</h3>
            <div class="add-new-skill-container">
                <label for="add-new-skill" name="skill-name" class="add-admin-label add-a-skill-label js-add-skill-label js-input-textarea-label">Add new skill</label>
                <input class="super-admin-input add-new-skill-input js-add-new-skill js-input-textarea" id="add-new-skill" name="skill-name" placeholder="Add new skill">
                <button class="super-admin-button add-new-skill-button js-add-new-skill-button">ADD</button>
                <div class="super-admin-add-skill-error js-add-skill-error"></div>
            </div>
            <label for="search-skills" name="skills-search" class="add-admin-label add-a-skill-label js-input-textarea-label">Search Skills</label>
            <input class="super-admin-input super-job-input search-job-input js-search-skills js-input-textarea" type="text" id="search-skills" name="skills-search" placeholder="Search Skills">
            <h4 class="super-all-skills-title">All-Skills</h4>
            <div class="js-skills all-skills-container"></div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function() {
        getCompany();
        getJobTitles();
        getSkills();
        getAdmins();

        function SearchItems(searchField, ItemNameTag) {
            document.querySelectorAll(ItemNameTag).forEach(item => {
                console.log(item.attributes.name.value)
                if (searchField.value !== '' && !item.attributes.name.value.toLowerCase().includes(searchField.value.toLowerCase())) {
                    item.style.display = 'none';
                } else if (searchField.value !== '' && item.attributes.name.value.toLowerCase().includes(searchField.value.toLowerCase())) {
                    item.style.display = 'flex'
                } else if (searchField.value === '') {
                    item.style.display = 'flex'
                }
            });
        }
        document.querySelector('.js-super-search-comapny').addEventListener('input', function() {
            SearchItems(this, ".js-super-company-container")
        })

        document.querySelector('.js-search-jobs').addEventListener('input', function() {
            SearchItems(this, ".js-job-title-container")
        })

        document.querySelector('.js-search-skills').addEventListener('input', function() {
            SearchItems(this, ".js-skill-container")
        })

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


        $('.js-navigation-radio').each(function() {
            if (this.checked === true) {
                const checkedId = this.id
                $('.js-navigation-label').each(function() {
                    if (checkedId === $(this).attr('for')) {
                        $(this).addClass('nav-label-selected');
                    }
                })
            }
        })



        $('.js-navigation-label').click(function() {
            $('.js-navigation-label').removeClass('nav-label-selected');
            $(this).addClass('nav-label-selected');
        })

        $('.js-edit-admin-form-close').click(function() {
            $('.js-edit-admin-form').css({
                "opacity": "0",
                "visibility": "hidden"
            })
        })

        $('.js-edit-admin-btn').click(updateAdmin);


        $(document).on('click', ".js-change-skill-name", editSkill);

        $(document).on('click', ".js-delete-skill", deleteSkill);

        $('.js-add-admin-btn').click(addAdmin);

        $('.js-add-new-skill-button').click(addSkill);

        $(document).on('click', ".js-super-admin-delete-admin", deleteAdmin);

        $('.js-add-position-btn').click(addJobTitle);

        $(document).on('click', ".js-change-job-name", editJobTitle);

        $(document).on('click', ".js-delete-job", deleteJobTitle);


        $('.js-add-company-btn').click(addCompany);

        $(document).on('click', ".js-delete-company", deleteCompany);

        $(document).on('click', ".js-change-company-name", editCompany);
    });
</script>
@endsection