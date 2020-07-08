@extends('layouts.master')

@section("users")
    <div class="user-box">
        <div class="user">
            <img src="{{auth()->user()->profile->picture}}" class="user-image">
            <div class="user-status">
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    @if(auth()->user()->hasAnyRole('superadmin', 'admin'))
                        test
                    @else
                        <a class="user-name" href="{{route('user.profile', auth()->user()->id)}}">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
                    @endif
                    <span><button type="submit" class="logout-btn">Log out</button></span>
                </form>
            </div>
        </div>
        <div>
            <a style="text-decoration: none;color:#9c9c9c;" href="/dashboard">Back to feedbacks</a>
        </div>
        <!-- @if(auth()->user()->active)

        <div class="search-area">
            <h4>YOUR TEAMMATES</h4>
            <input class="search-teammate js-search js-live-search" type="search" placeholder="Search a teammate">
            <ul class="list">

                @forelse(auth()->user()->teammates() as $user)

                    <li data-userId="{{$user->id}}" class="teammate js"><a href="#"><img src="{{$user->profile->picture}}" class="teammate-image"></a> <a href="#" class="teammate-name js{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</a>@if($user->hasFeedback())<i class="fas fa-check reviewed"></i>@endif</li>

                @empty

                    <p>No users in this team.</p>

                @endforelse
            </ul>
        </div>
        @endif -->
    </div>
@endsection

@section('content')

    @if(!auth()->user()->active)
        <h2>Your account is temporarily deactivated</h2>
    @elseif (!auth()->user()->company->active)
        <h2>Your company is temporarily deactivated</h2>
    @else

@if(count(auth()->user()->activeFeedbacks()))
<div data-userId="{{$user->id}}" class=" modal{{$user->id}}">
    <div class="single-feedback">
        <div class="feedback-person">
            <img class="feedback-image" src="{{auth()->user()->profile->picture}}">
            <div class="feedback-person-info media-profile-info">
                <span class="js-user">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</span>
                <span class="js-position">{{$user->profile->jobTitle->name}}</span>
            </div>
            <div class="feedback-person-info"><span style="font-size: 0.8rem; color: #9c9c9c;">Average score: </span>
                <span class="average-score-big">{{number_format(auth()->user()->averageFeedbackScore(), 1, '.', '')}}<span class="star-rating media-profile-info">{{round(auth()->user()->averageFeedbackScore(), 1)}}</span></span>
            </div>
            <!-- <button class="close-btn js-close{{$user->id}}"><i class="fas fa-times"> <br> ESC</i></button> -->
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="feedback-title">Feedback summery</div>
                <span>Personal skills and competences</span>
                <div class="my-rating"></div>
                    @foreach($skills as $skill)
                    <span>
                        <p class="media-profile-rating" style="color: #bdbcbc;">{{$skill->name}}:
                        <span class="float-right">
                        <span>(@if($skill->averageForUser(auth()->user())){{$skill->averageForUser(auth()->user())}}) </span> @else 0 @endif
                        <span class="test1">@if($skill->averageForUser(auth()->user())){{$skill->averageForUser(auth()->user())}}</span> @else 0 @endif
                        </span>
                        </p>
                    </span>
                    @endforeach

                @endif

            </div>

        </div>

        <div class="row">
            <div class="all-feedbacks">
                <div style="flex-grow: 1;">
                    <h4 style="color: rgb(167, 167, 167);">Feedbacks @if(auth()->user()->activeFeedbacks())({{count(auth()->user()->activeFeedbacks())}}) @else (0) @endif</h4>
                </div>
                <div class="btn-container">
                    <button class="all-feedback-btn js-comments"><i class="fas fa-chevron-down"></i></button>

                </div>

            </div>


            <div class="col-md-12 comments">
                @forelse(auth()->user()->activeFeedbacks() as $feedback)
                <div class="single-review">
                    <div class="user">
                        <img src="https://source.unsplash.com/random" class="user-image">
                        <div class="user-status-profile">
                            <p class="user-info">{{$feedback->creator->first_name}} {{$feedback->creator->last_name}}
                                <span class="position"><br>{{$user->profile->position}}</span>
                            </p>
                                <span style="margin: auto 0;">@if($feedback->creator->averageFeedbackScore()){{round($feedback->creator->averageFeedbackScore(), 1)}}
                                <span class="test1">{{round($feedback->creator->averageFeedbackScore(), 1)}}
                                </span>@else 0 @endif
                                </span>
                        </div>

                    </div>
                    <div>
                        <h3><i class="fas fa-quote-right red"></i> WHAT IS WRONG</h3>
                        <p class="feed">{{$feedback->comment_wrong}}</p>
                        <h3><i class="fas fa-quote-right red"></i> WHAT COULD BE IMPROVED</h3>
                        <p class="feed">{{$feedback->comment_improve}}</p>
                    </div>
                </div>
                @empty

                    <p>You dont have any feedback.</p>

                @endforelse

            </div>
        </div>
    </div>
</div>
@endif

@endsection
@section('script')
<script>
    $('.test1').html(getStars)
function getStars(){
    let star = $(this).text()
    star = Math.round(star * 2) / 2;
        let output = [];
        // Append all the filled whole stars
        for (var i = star; i >= 1; i--)
        output.push('<i class="fa fa-star"  style="color: #ec1940;"></i>&nbsp;');

        // If there is a half a star, append it
        if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true" style="color: #ec1940;"></i>&nbsp;');
        // Fill the empty stars
        for (let i = (5 - star); i >= 1; i--)
        output.push('<i class="fa fa-star-o" aria-hidden="true" style="color: lightgray;"></i>&nbsp;');

        return output.join('');
    }

</script>

@endsection
