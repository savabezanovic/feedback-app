$(document).ready(function(){
    //Log in input animation
    $(".js-e-mail").change(function(){
        $(".e-mail").css("border-color", "#ec1940");
        $(".js-mail").toggle();
    });
    $(".js-password").change(function(){
        $(".password").css("border-color", "#ec1940");
        $(".js-pass").toggle();
    });
    $(".js-search").on("keyup", function(){
        var value = $(this).val().toLowerCase();
        $(".list li").filter(function(){
            $(this).toggle($(this).text().toLocaleLowerCase().indexOf(value) > -1);

        });
    });
    //Search teammate input
    $(".js-search").before("<i class='fas fasa js-live-search'>&#xf002;</i>");

    $(".js-search").attr('spellcheck',false);
    $(".write-feedback").attr('spellcheck',false);

    var $inputs = $(".js-search");
    $inputs.on("input", function() {
        var $filled = $inputs.filter(function() { return this.value.trim().length > 0; });
        $('.js-live-search').toggleClass('js-filled', $filled.length > 0);
    });

    $('.list li').click(getUser);

    $('.js-comments').click(getComments);
    function getComments(){
        $('.comments').slideToggle('500');
        $('.btn-container').find('i').toggleClass('fa-chevron-down fa-chevron-up')
    }

    $('.js-accepted').hide();

    function getUser() {
        // e.preventDefault();
        let id = $(this).attr('data-userId');

        $('.js-write'+id).blur(function(){
            if(!$(this).val()){
                $(this).removeClass("written");
            } else{
                $(this).addClass("written");
            }
            if (!$('.js-write'+id).val()){
                $('.js-hide'+id).addClass("hide");
            } else{
                $('.js-hide'+id).removeClass("hide");
            }
        });
        $('.js-write-two'+id).blur(function(){
            if(!$(this).val()){
                $(this).removeClass("written");
            } else{
                $(this).addClass("written");
            }
            if (!$('.js-write-two'+id).val()){
                $('.js-hide-2'+id).addClass("hide");
            } else{
                $('.js-hide-2'+id).removeClass("hide");
            }
        });

        $('.js-close'+id).click(closeFeedback);
        function closeFeedback(){
            $('.modal'+id).hide();
            $('.js-no-selected').show();
        }
        $.get('/feedback/user/'+id,
            {
                success:  function(){
                    $('.modal').css('display', 'none');
                    $('.modal'+id).show();
                    $('.js-no-selected').hide();
                    $('.js-accepted').hide()
                }
            }
        )
    }
    let star = $('.star-rating').text();
    $('.star-rating').html(getStars(star));
    function getStars(star) {
        star = Math.round(star * 2) / 2;
        let output = [];

        for (var i = star; i >= 1; i--)
            output.push('<i class="fa fa-star"  style="color: #ec1940;"></i>&nbsp;');

        if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true" style="color: #ec1940;"></i>&nbsp;');

        for (let i = (5 - star); i >= 1; i--)
            output.push('<i class="fa fa-star-o" aria-hidden="true" style="color: lightgray;"></i>&nbsp;');

        return output.join('');
    }
    $.fn.stars = function() {
        return $(this).each(function() {
            var val = parseFloat($(this).html());
            var size = Math.max(0, (Math.min(5, val))) * 16;
            var $span = $('<span />').width(size);
            $(this).html($span);
        });
    };

    $( document ).ready(function() {
        $('span.stars').stars();
    });
    $('.js-menu-media').click(getAside);
    function getAside(){
        $('.aside-media-view').toggle("slide");
        $('.js-main').toggle("slide");
    }

    var smallScreen = false;
    $(document).ready(function() {
        if($(window).width() < 426) {
            smallScreen = true;
        }
        $(window).resize(function() {
            if($(window).width() < 426) {
                smallScreen = true;
            } else {
                smallScreen = false;
            }
        });
        function getTeammates() {
            if(smallScreen) {
                $('.teammate').click(function(){
                    $('.aside-media-view').toggle("slide");
                    $('.js-main').toggle("slide");
                    console.log('getTeammates')
                })
            }
        }
        getTeammates();
    });
});
