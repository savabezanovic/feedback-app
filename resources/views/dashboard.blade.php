@extends("layouts.master")

@section("users")




<div class="feedback-app-navbar-profile-container">
    <img src="{{auth()->user()->profile->picture}}" alt="profile avatar" class="feedback-app-profile-avatar">
    <div>
        <div class="feedback-app-navbar-profile-name js-feedback-app-logged-user">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</div>
        <form action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="feedback-app-navbar-profile-logout">Log out</button>
        </form>
    </div>
</div>
<div class="feedback-app-navbar-teammates-search-container">
    <div class="feedback-app-navbar-your-teammates">Your teammates</div>
    <input type="checkbox" id="teammatesCheckbox" class="feedback-app-navbar-your-teammates-checkbox">
    <label for="teammatesCheckbox" class="feedback-app-navbar-your-teammates-label">Your teammates <span class="your-teammates-label-arrow">&#9660;</span></label>
    <div class="feedback-app-navbar-search-and-users-list-container">
        <div class="feedback-app-navbar-search-container">
            <label for="navbarSearch"><img src="images/search-icon.png" class="feedback-app-navbar-search-icon" alt="search icon"></label>
            <input id="navbarSearch" class="feedback-app-search-input js-feedback-app-search" type="text" placeholder="Search a teammate" />
        </div>
        <ul class="feedback-app-navbar-users-list js-teammates-list">
            @forelse(auth()->user()->teammates() as $user)
            @if($user->hasFeedback())
            <li id="{{$user->id}}" class="feedback-app-navabar-users-list-item js-feedback-app-teammate js-teammate-{{$user->id}} already-reviewed">
                <img src="{{$user->profile->picture}}" class="feedback-app-navbar-users-list-image" />
                {{$user->first_name}} {{$user->last_name}}
                <img src="images/user-reviewed.png" alt="check mark" style="display:block" class="feedback-app-navbar-users-list-reviewed js-reviewed-checkmark-{{$user->id}}">
            </li>
            @else
            <li id="{{$user->id}}" class="feedback-app-navabar-users-list-item js-feedback-app-teammate js-teammate-{{$user->id}}">
                <img src="{{$user->profile->picture}}" class="feedback-app-navbar-users-list-image" />
                {{$user->first_name}} {{$user->last_name}}
                <img src="images/user-reviewed.png" alt="check mark" class="feedback-app-navbar-users-list-reviewed js-reviewed-checkmark-{{$user->id}}">
            </li>
            @endif
            @empty

            <p>There are no teammates here</p>

            @endforelse
        </ul>
    </div>
</div>

@endsection

@section('content')

@if(!auth()->user()->active)
<h2>Your account is temporarily deactivated</h2>
@elseif (!auth()->user()->company->active)
<h2>Your company is temporarily deactivated</h2>
@else

<div class="js-feedback-status-container">
    @if(auth()->user()->doneFeedback())
    <div class="feedback-status">
        <img src="images/feedback-accepted-smiley.png" alt="happy smiley" class="feedback-status-image">
        <h1 class="feedback-status-title">
            You reviewed all your team
        </h1>
        <p class="feedback-status-text">
            Great job! You must wait for the next
            feedback session at
            {{auth()->user()->company->nextFeedbackSessionDate()}}
        </p>
    </div>
    @else
    <div class="feedback-status js-teammate-not-selected">
        <img src="images/teammate-not-selected-smiley.png" alt="serious smiley" class="feedback-status-image">
        <h1 class="feedback-status-title">No teammate selected</h1>
        <p class="feedback-status-text">To provide a feedback you should select an employee from the teammates list or to search by a name using the search field</p>
    </div>
    <div class="feedback-status feedback-status-accepted js-feedback-accepted">
        <img src="images/feedback-accepted-smiley.png" alt="happy smiley" class="feedback-status-image">
        <h1 class="feedback-status-title">Your feedback accepted</h1>
        <p class="feedback-status-text">You can review your other teammates</p>
    </div>
    <div class="feedback-status feedback-status-accepted js-teammate-already-reviewed">
        <img src="images/teammate-already-reviewed.png" alt="suprised smiley" class="feedback-status-image">
        <h1 class="feedback-status-title">You have already reviewed this teammate</h1>
        <p class="feedback-status-text">Please selecet someone else</p>
    </div>
    <div class="feedback-status feedback-status-accepted js-all-reviewed">
        <img src="images/feedback-accepted-smiley.png" alt="happy smiley" class="feedback-status-image">
        <h1 class="feedback-status-title">
            You reviewed all your team
        </h1>
        <p class="feedback-status-text">
            Great job! You must wait for the next
            feedback session at
            {{auth()->user()->company->nextFeedbackSessionDate()}}
        </p>
    </div>
    @endif
</div>

@if(count(auth()->user()->activeFeedbacks()))

<div class="logged-user-container js-logged-user-container">
    <div class="profile-form-name-image-container">
        <img src="{{auth()->user()->profile->picture}}" alt="profile picture" class="profile-form-image">
        <div class="profile-form-name-container">
            <div class="profile-form-name js-logged-user-name">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</div>
            <div class="profile-form-name-profession">{{$user->profile->jobTitle->name}}</div>
        </div>
        <div class="logged-user-average-score-container">
            <div class="logged-user-average-score">AVERAGE SCORE</div>
            <div class="logged-user-stars-contianer logged-user-stars-container-overall">
                <div class="logged-user-stars-rating logged-user-stars-rating-overall"><span class="js-logged-user-stars-rating">{{number_format(auth()->user()->averageFeedbackScore(), 1, '.', '')}}</span>
                </div>
                <div class="stars-layer-1 stars-layer-1-overall">
                    <div class="stars-layer-2">
                    </div>
                    <div class="stars-layer-3">
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-form-esc-x-container">
            <div class="profile-form-name-x-button js-profile-form-close">&#10006;</div>
            <div class="profile-form-name-esc">
                <div>ES</div>
                <div>C</div>
            </div>
        </div>
    </div>
    <div class="logged-user-feddback-summary">
        Feedback summary
    </div>
    <div class="profile-form-personal-skills">Personal skills and competences</div>
    <ul class="feedback-list-container">

        @foreach($skills as $skill)

        <li class="feedback-list-item">
            {{$skill->name}}
            <div class="logged-user-stars-contianer">
                <div class="logged-user-stars-rating">
                    (<span class="js-logged-user-stars-rating">
                        @if($skill->averageForUser(auth()->user())){{$skill->averageForUser(auth()->user())}}@else 0 @endif
                    </span>)
                </div>
                <div class="stars-layer-1">
                    <div class="stars-layer-2">
                    </div>
                    <div class="stars-layer-3">
                    </div>
                </div>
            </div>
        </li>

        @endforeach
    </ul>
    @endif
    <div class="logged-user-feedbacks-container">
        <input type="checkbox" id="feedbacksCheckbox" class="feedbacks-checkbox">
        <label for="feedbacksCheckbox" class="feedbacks-checkbox-label">Feedbacks @if(auth()->user()->activeFeedbacks())({{count(auth()->user()->activeFeedbacks())}}) @else (0) @endif
            <img src="images/down-arrow.png" alt="down arrow" class="feedbacks-checkbox-label-down-arrow">
        </label>
        <div class="logged-user-all-feedbacks">
            @forelse(auth()->user()->activeFeedbacks() as $feedback)
            <div class="logged-user-feedback">
                <div class="feedbacks-user-container">
                    <img class="profile-form-image" src="https://cdn3.vectorstock.com/i/thumb-large/17/72/halloween-red-smiling-monster-avatar-vector-26041772.jpg" alt="user icon">
                    <div>{{$feedback->creator->first_name}} {{$feedback->creator->last_name}}
                        <div class="feedbacks-user-profession"></div>
                    </div>
                    <div class="logged-user-stars-contianer">
                        <div class="logged-user-stars-rating feedbacks-user-rating">
                            <span class="js-logged-user-stars-rating">
                                @if($feedback->creator->averageFeedbackScore()){{round($feedback->creator->averageFeedbackScore(), 1)}} @else (0) @endif
                            </span>
                        </div>
                        <div class="stars-layer-1">
                            <div class="stars-layer-2">
                            </div>
                            <div class="stars-layer-3">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feedbacks-comment-container">
                    <div class="feedbacks-comment-type"><img class="feedback-comment-list-bullet" src="images/feedbacks-type-symbold.png" alt="list bullets">
                        WHAT IS WRONG:
                    </div>
                    <div class="feedbacks-comment-text">
                        {{$feedback->comment_wrong}}
                    </div>
                </div>
                <div class="feedbacks-comment-container">
                    <div class="feedbacks-comment-type"><img class="feedback-comment-list-bullet" src="images/feedbacks-type-symbold.png" alt="list bullets">
                        WHAT COULD BE IMPROVED:
                    </div>
                    <div class="feedbacks-comment-text">
                        {{$feedback->comment_improve}}
                    </div>
                </div>
            </div>
            @empty
            <div>No feedbacks</div>
            @endforelse

        </div>
    </div>
</div>

@forelse(auth()->user()->teammates() as $user)

<form class="profile-form-container js-profile-form-continer-{{$user->id}}">
    <div class="profile-form-name-image-container">
        <img src="{{$user->profile->picture}}" alt="profile picture" class="profile-form-image">
        <div class="profile-form-name-container">
            <div class="profile-form-name">{{$user->first_name}} {{$user->last_name}} </div>
            <div class="profile-form-name-profession">{{$user->profile->jobTitle->name}}</div>
        </div>
        <div class="profile-form-esc-x-container">
            <div class="profile-form-name-x-button js-profile-form-close">&#10006;</div>
            <div class="profile-form-name-esc">
                <div>ES</div>
                <div>C</div>
            </div>
        </div>
    </div>
    <div class="profile-form-provide-feedback">Provide Feedback</div>
    <div class="profile-form-personal-skills">Personal skills and competences</div>
    <ul class="feedback-list-container">
        @forelse($skills as $skill)
        <li class="feedback-list-item js-feedback-list-item js-skill-{{$user->id}}">
            {{$skill->name}}
            <div class="feedback-list-stars-container">
                <input type="radio" name="{{$skill->id}}-{{$user->id}}" value="5" class="stars-radio-5" id="{{$skill->name}}-{{$user->id}}-5">
                <input type="radio" name="{{$skill->id}}-{{$user->id}}" value="4" class="stars-radio-4" id="{{$skill->name}}-{{$user->id}}-4">
                <input type="radio" name="{{$skill->id}}-{{$user->id}}" value="3" class="stars-radio-3" id="{{$skill->name}}-{{$user->id}}-3">
                <input type="radio" name="{{$skill->id}}-{{$user->id}}" value="2" class="stars-radio-2" id="{{$skill->name}}-{{$user->id}}-2">
                <input type="radio" name="{{$skill->id}}-{{$user->id}}" value="1" class="stars-radio-1" id="{{$skill->name}}-{{$user->id}}-1">
                <label for="{{$skill->name}}-{{$user->id}}-5" class="star-5 stars-label">&#9734;</label>
                <label for="{{$skill->name}}-{{$user->id}}-4" class="star-4 stars-label">&#9734;</label>
                <label for="{{$skill->name}}-{{$user->id}}-3" class="star-3 stars-label">&#9734;</label>
                <label for="{{$skill->name}}-{{$user->id}}-2" class="star-2 stars-label">&#9734;</label>
                <label for="{{$skill->name}}-{{$user->id}}-1" class="star-1 stars-label">&#9734;</label>
            </div>
        </li>
        @empty
        <div>No skills for feedback</div>
        @endforelse
    </ul>
    <div class="profile-form-write-a-feedback">Write a feedback</div>
    <div class="profile-form-feedback-textarea-container">
        <label for="whatIsWrongText-{{$user->id}}" name="wrong-{{$user->id}}" class="profile-form-feedback-textarea-label js-input-textarea-label">
            What is wrong
        </label>
        <textarea cols="30" rows="1" id="whatIsWrongText-{{$user->id}}" name="wrong-{{$user->id}}" placeholder="What is wrong" class="feedback-textarea js-input-textarea js-wrong-{{$user->id}}"></textarea>
    </div>
    <div class="profile-form-feedback-textarea-container">
        <label for="whatToImproveText-{{$user->id}}" name="improved-{{$user->id}}" class="profile-form-feedback-textarea-label js-input-textarea-label">
            What could be improved
        </label>
        <textarea cols="30" rows="1" id="whatToImproveText-{{$user->id}}" name="improved-{{$user->id}}" placeholder="What could be improved" class="feedback-textarea js-input-textarea js-improve-{{$user->id}}"></textarea>
    </div>
    <input type="submit" class="profile-form-submit-button js-submit " value="SUBMIT">
</form>
@empty
<div>No teammates for feedback</div>
@endforelse

@endif

@endsection

@section('script')

<script>
    let userId = null;
    let userNotSelectedTimeout = null;
    const allSkills = {!! $skills !!}
    window.addEventListener('load', function() {
        let noTeammateSelected = document.querySelector('.js-teammate-not-selected')
         console.log([...document.querySelectorAll('.js-feedback-app-teammate')])
        console.log([...$('.js-feedback-app-teammate')])
        document.querySelectorAll('.js-feedback-app-teammate').forEach(teammate => {
            teammate.addEventListener('click', function() {
                if (noTeammateSelected !== null) {
                    userId = this.id;
                    userNotSelectedTimeout !== null && clearTimeout(userNotSelectedTimeout)
                    noTeammateSelected.style.display = "none"
                    document.querySelector('.js-feedback-status-container').style.display = "block"
                    document.querySelector('.js-feedback-accepted').style.display = "none"
                    document.querySelector('.js-teammate-already-reviewed').style.display = "none"
                    document.querySelector('.js-logged-user-container').style.display = "none"
                    document.querySelectorAll(".profile-form-container").forEach(form => {
                        form.style.display = "none"
                    });
                    document.querySelectorAll(".js-feedback-app-teammate").forEach(teammate => {
                        teammate.style.backgroundColor = "transparent"
                    });
                    this.style.backgroundColor = "#383d42"
                    if (this.classList.contains('already-reviewed')) {
                        document.querySelector('.js-teammate-already-reviewed').style.display = "block"
                    } else {
                        document.querySelector(`.js-profile-form-continer-${userId}`).style.display = "flex";
                    }
                }
            })

        });

        document.querySelectorAll('.js-profile-form-close').forEach(closeButton => {
            closeButton.addEventListener('click', function() {
                this.parentElement.parentElement.parentElement.style.display = 'none';
                document.querySelector('.js-feedback-status-container').style.display = "block"
                if (noTeammateSelected !== null) {
                    noTeammateSelected.style.display = 'block'
                    document.querySelector('.js-feedback-accepted').style.display = "none"
                    document.querySelector('.js-teammate-already-reviewed').style.display = "none"
                } else {
                    document.querySelector('.js-all-reviewed').style.display = "block";
                }
                document.querySelectorAll(".js-feedback-app-teammate").forEach(teammate => {
                    teammate.style.backgroundColor = "transparent"
                });
            })
        });

        document.querySelector('.js-feedback-app-search').addEventListener('input', function() {
            document.querySelectorAll('.js-feedback-app-teammate').forEach(teammate => {
                if (this.value !== '' && !teammate.innerText.toLowerCase().includes(this.value.toLowerCase())) {
                    teammate.style.display = 'none';
                } else if (this.value !== '' && teammate.innerText.toLowerCase().includes(this.value.toLowerCase())) {
                    teammate.style.display = 'flex'
                } else if (this.value === '') {
                    teammate.style.display = 'flex'
                }
            });
        });

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

        document.querySelectorAll(".js-logged-user-stars-rating").forEach(rating => {
            const layer2AcceptablePercent = ["20", "40", "60", "80", "100"];
            const starsPercent = (rating.innerText / 5) * 100;
            const starsRounded = `${(Math.round(starsPercent /10) *10)}`;
            rating.parentElement.nextElementSibling.firstElementChild.style.width = `${layer2AcceptablePercent.includes(starsRounded) ? starsRounded : parseInt(starsRounded,10) + 10}%`;
            rating.parentElement.nextElementSibling.firstElementChild.nextElementSibling.style.width = `${starsRounded}%`
        })

        document.querySelector('.js-feedback-app-logged-user').addEventListener("click", function() {
            userNotSelectedTimeout !== null && clearTimeout(userNotSelectedTimeout)
            document.querySelector('.js-feedback-status-container').style.display = "none"
            document.querySelectorAll(".profile-form-container").forEach(form => {
                form.style.display = "none"
            });
            document.querySelectorAll(".js-feedback-app-teammate").forEach(teammate => {
                teammate.style.backgroundColor = "transparent"
            });
            document.querySelector('.js-logged-user-container').style.display = "block"
        })

        document.querySelectorAll('.js-submit').forEach(submitButton => {
            submitButton.addEventListener("click", function(event) {
                event.preventDefault();
                let feedbacks = {
                    feedback_1: document.querySelector(`.js-wrong-${userId}`).value,
                    feedback_2: document.querySelector(`.js-improve-${userId}`).value,
                    user_id: userId
                }
                let skillRatings = {}

                allSkills.forEach(function(skill) {
                    const slectedUserReview = `${skill.id}-${userId}`
                    skillRatings[slectedUserReview] = $(`input[name="${slectedUserReview}"]:checked`).val();
                });

                $.post('feedback/store', {
                        data: feedbacks,
                        ratings: skillRatings,
                        skills: allSkills,
                        success: function() {}
                    }).done(function() {
                        $(`.js-profile-form-continer-${userId}`).hide();
                        $(".js-feedback-app-teammate").css("background-color", "transparent")
                        $(`.js-teammate-${userId}`).addClass('already-reviewed');
                        $(`.js-reviewed-checkmark-${userId}`).show();
                        const usersArray = [...$('.js-feedback-app-teammate')]
                        if (usersArray.every(function(user) {return user.classList.contains('already-reviewed')})) {
                            noTeammateSelected = null;
                            $('.js-feedback-accepted').show();
                            userNotSelectedTimeout = setTimeout(function() {
                                $(".js-feedback-accepted").hide();
                                $('.js-all-reviewed').show();
                            }, 2500)
                        } else {
                            $('.js-feedback-accepted').show();
                            userNotSelectedTimeout = setTimeout(function() {
                                $(".js-feedback-accepted").hide();
                                $(".js-teammate-not-selected").show();
                            }, 2500)
                        }
                    })
                    .fail(function(jqxhr, settings, ex) {
                        alert('Fill out all fields');
                    })
            })
        })
    });
</script>
@endsection