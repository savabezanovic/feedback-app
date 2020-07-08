@extends("layouts.master")

@section("users")
    <div>
        <div>
            <img src="{{auth()->user()->profile->picture}}" class="user-image">
            <div>
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <a href="{{route('user.profile', auth()->user()->id)}}">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
                    <span><button type="submit" class="logout-btn">Log out</button></span>
                </form>
            </div>
        </div>

        @if(auth()->user()->active)

        <div class="search-area">
            <h4>YOUR TEAMMATES</h4>
            <input class="search-teammate js-search js-live-search" type="search" placeholder="Search a teammate">
            <ul class="list">

                @forelse(auth()->user()->teammates() as $user)

                    <li data-userId="{{$user->id}}" class="teammate js"><img class="teammate-image" src="{{$user->profile->picture}}"><a class="teammate-name js">{{$user->first_name}} {{$user->last_name}}</a>@if($user->hasFeedback())<i class="fas fa-check reviewed"></i>@endif<span class="hidden js{{$user->id}}"><i class="fas fa-check reviewed"></i></span></li>

                @empty

                    <p>No users in this team.</p>

                @endforelse
            </ul>
        </div>
        @endif
    </div>

@endsection

@section('content')

    @if(!auth()->user()->active)
        <h2>Your account is temporarily deactivated</h2>
    @elseif (!auth()->user()->company->active)
        <h2>Your company is temporarily deactivated</h2>
    @else
    <div class="js-check-done">
    @if(auth()->user()->doneFeedback())
        <div class="container js-no-selected">
            <i class='far'>&#xf11a;</i>
            <div class="messages">
                You reviewed <br> all your team
            </div>
            <p class="info">
                Great job! You can only wait for the <br>
                feedback session at
                {{auth()->user()->company->nextFeedbackSessionDate()}}
            </p>
        </div>
    @else
    <div class='container js-accepted'>
        <i class='far'>&#xf118;</i>
        <div class='messages'> Your feedback <br>accepted</div>
        <p class='info'>You can review other your teammate</p>
    </div>
    @endif
    </div>
    @if (!auth()->user()->doneFeedback())
    <div class="container js-no-selected">
        <i class='far'>&#xf11a;</i>
        <div class="messages">
            No teammate <br>selected
        </div>
        <p class="info">
            To provide a feedback you should select <br>
            an employee from teammmates list or<br>
            to search by a name using the search field
        </p>
    </div>
@endif
    @forelse(auth()->user()->teammates() as $user)

        <!--Modal-->
        <div data-userId="{{$user->id}}" class="modal modal{{$user->id}}">
            <div class="single-feedback">
                <div class="feedback-person">
                    <img class="feedback-image" src="{{$user->profile->picture}}">
                    <div class="feedback-person-info">
                        <span class="js-user">{{$user->first_name}} {{$user->last_name}}</span>
                        <span class="js-position">{{$user->profile->jobTitle->name}}</span>
                    </div>
                    <button class="close-btn js-close{{$user->id}}"><i class="fas fa-times"> <br> ESC</i></button>
                </div>
                <div class="feedback-title">Provide feedback</div>
                <span>Personal skills and competences</span>


                @if($user->hasFeedback())
                    @foreach($user->hasFeedback()->skills as $skill)

                        <span class="single-skill">
            <p class="skill-name">{{$skill->name}}</p>
                <fieldset class="rating">
                    @for($i = 5; $i > 0; $i--)
                        <input disabled type="radio" id="star{{$i}}_{{$skill->id}}{{$user->id}}" name="rating_{{$skill->id}}{{$user->id}}" value="5" @if($skill->pivot->score == $i) checked @endif/><label class = "full" for="star{{$i}}_{{$skill->id}}{{$user->id}}" title="{{$titles[$i-1]}}"></label>
                    @endfor
                </fieldset>
        </span>
                    @endforeach
                @else

                    @forelse($skills as $skill)

                        <span class="single-skill">
            <p class="skill-name">{{$skill->name}}</p>
                <fieldset class="rating js-rating{{$user->id}}">
                        <input type="radio" id="star5_{{$skill->id}}{{$user->id}}" name="rating_{{$skill->id}}{{$user->id}}" value="5" required/><label class = "full" for="star5_{{$skill->id}}{{$user->id}}" title="Awesome"></label>
                        <input type="radio" id="star4_{{$skill->id}}{{$user->id}}" name="rating_{{$skill->id}}{{$user->id}}" value="4" required/><label class = "full" for="star4_{{$skill->id}}{{$user->id}}" title="Pretty good"></label>
                        <input type="radio" id="star3_{{$skill->id}}{{$user->id}}" name="rating_{{$skill->id}}{{$user->id}}" value="3" required/><label class = "full" for="star3_{{$skill->id}}{{$user->id}}" title="Meh"></label>
                        <input type="radio" id="star2_{{$skill->id}}{{$user->id}}" name="rating_{{$skill->id}}{{$user->id}}" value="2" required/><label class = "full" for="star2_{{$skill->id}}{{$user->id}}" title="Kinda bad"></label>
                        <input type="radio" id="star1_{{$skill->id}}{{$user->id}}" name="rating_{{$skill->id}}{{$user->id}}" value="1" required/><label class = "full" for="star1_{{$skill->id}}{{$user->id}}" title="Really bad"></label>
                </fieldset>
        </span>
                    @empty

                        <p>Currently no skills.</p>

                    @endforelse

                @endif

                <div class="alert alert-success">

                </div>

                <span style="margin:20px 0px;">Write a feedback</span>

                <label class="show js-hide{{$user->id}}" for="feedback_1">What is wrong</label>
                <textarea id="comment_wrong{{$user->id}}" class="written write-feedback js-write{{$user->id}} js-wrong{{$user->id}}" placeholder="What is wrong" name="feedback_1" @if($user->hasFeedback()) disabled @else required @endif>@if($user->hasFeedback()) {{$user->hasFeedback()->comment_wrong}} @endif</textarea>
                <label class="show js-hide-2{{$user->id}}" for="feedback_2">What could be improved</label>
                <textarea id="comment_improve{{$user->id}}" class="written write-feedback js-write-two{{$user->id}} js-improve{{$user->id}}" placeholder="What could be improved" name="feedback_2" @if($user->hasFeedback()) disabled @else required @endif>@if($user->hasFeedback()) {{$user->hasFeedback()->comment_improve}} @endif</textarea>

                {{--    <label for="skill_name">Skill name test</label>--}}
                {{--    <input type="text" id="skill_name" name="skill_name">--}}

                @if(!$user->hasFeedback())

                    <div class="submit-feedback">
                        <input class="submit-feedback-btn js-submit js-submit{{$user->id}}" type="submit" id="submit" value="SUBMIT">
                    <!-- <button class="submit-feedback-btn js-submit{{$user->id}}"  id="submit{{$user->id}}" type="submit">SUBMIT</button> -->
                    </div>

                @endif
            </div>
        </div>

    @empty

        <p>No users in this team.</p>

    @endforelse

    @endif


@endsection

@section('script')
    <script>
        var skills = {!! $skills !!};

        $(document).ready(function () {

            var id1 = '';

            $(document).on('click', '.list li', function () {
                id1 = $(this).attr('data-userId');
                console.log('id1 = ' + id1)
                $(".list li").removeClass("active-teammate");
                $(this).addClass("active-teammate");
            });

            $('.js-submit').click(function(e) {
                e.preventDefault();
                var data = {
                    feedback_1: $('#comment_wrong'+id1).val(),
                    feedback_2: $('#comment_improve'+id1).val(),
                    user_id: id1
                };
                var ratings = {};

                skills.forEach(function (entry) {
                    var current = 'rating_' + entry.id + id1;
                    ratings[current] = $(`input[name="${current}"]:checked`).val();
                });

                $.post('feedback/store',
                    {
                        data: data,
                        ratings: ratings,
                        skills: skills,
                        success: function(){

                    }
                    },
                    

                ).done(function(){
                    $('.js-accepted').show();
                            $(".js-check-done").load(location.href+" .js-check-done>*","");
                            $(".js-accepted").hide();
                    $('.modal').hide();
                    $('.js-submit'+id1).hide();
                    $('.js'+id1).removeClass('hidden');
                    $('.js-wrong'+id1).attr('disabled', true)
                    $('.js-improve'+id1).attr('disabled', true)
                    $('.js-rating'+id1).attr('disabled', true)
                })
                    .fail(function(jqxhr, settings, ex) { alert('Enter all data'); })
            });

        });

    </script>

@endsection