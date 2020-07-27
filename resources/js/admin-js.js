$(document).ready(function () {
    window.getUsers = function() {
        $.get(
            '/admin/users', function (data) {
                let output = [];

                $.each(data.users, function (i, e) {
                    output += `<tr class="company-users-table-body-row js-user-del${e.id}">
                                    <td class="company-users-table-body-data"> ${e.first_name}  </td><td class="company-users-table-body-data">  ${e.last_name}  </td>
                                    <td class="company-users-table-body-data">${e.email}</td>
                                    <td class="company-users-table-body-data">${e.profile.job_title.name}</td>
                                    <td class="user-status-dot company-users-table-body-data">
                                    <input class="user-status-checkbox" data-id="${e.id}" name="chk-box" id="chk-box-${e.id}" value="1" type="checkbox" ${e.active === 1 ? "checked" : ""} >
                                        <label for="chk-box-${e.id}" class="user-status-toggle-outer">
                                            <span class="user-status-toggle-inner"></span>
                                        </label>
                                    </td>
                                    <td class="company-users-table-body-data users-table-center">
                                        <button id="${e.id}" class="users-table-button js-edit-user" data-id=${e.id}>Edit</button>
                                        <button class="users-table-button" id="delete-user" data-id=${e.id}>Delete</button>
                                    </td>
                                </tr>`
                });
                $('.js-admins-list').append(output);
                $(".js-edit-user").click(editUser);
                function editUser(e){
                    id = e.target.getAttribute('id');
                    console.log(id)
                    $.get('/admin/users/'+id, function(data){
                            $('.js-edit-fname').val(data.user.first_name);
                            $('.js-edit-lname').val(data.user.last_name);
                            $('.js-edit-mail').val(data.user.email);
                            $('#update-job-title').val(data.user.profile.job_title_id);
                            document.querySelectorAll('.js-edit-user-input').forEach(input => {
                                if (input.value === "") {
                                    input.style.borderColor = "#d3d4d5"
                                    document.querySelectorAll(".js-input-textarea-label").forEach(label => {
                                        if(input.name === label.attributes.name.value) {
                                            label.style.opacity = 0;
                                            label.style.visibility = 'hidden';
                                            }
                                    })
                                } else {
                                    input.style.borderColor = "#ec1940"
                                    document.querySelectorAll(".js-input-textarea-label").forEach(label => {
                                        if(input.name === label.attributes.name.value) {
                                            label.style.opacity = 1;
                                            label.style.visibility = 'visible';
                                        }
                                    })
                                }
                            })                        
                        }
                    )
                    $('#hidden_user_id').val(id);
                    $(".js-edit-error").css("max-height", "0");
                    $(".js-edit-error-password").css("max-height", "0");
                    $(".js-edit-user-form").css({"visibility":"visible","opacity":"1"});
                    $('#password1').val("");
                    $('#password-confirm1').val("");
     
                }

            }
        )
    };

    window.submitTest = function(e) {
        e.preventDefault();
        let form_data = new FormData();
        form_data.append('first_name', $('#first-name').val());
        form_data.append('last_name', $('#last-name').val());
        form_data.append('email', $('#email').val());
        form_data.append('password', $('#password').val());
        form_data.append('password_confirmation', $('#password-confirm').val());
        form_data.append('company_id', $('#company-id').val());
        form_data.append('job_title_id', $('#job-title').val());
        form_data.append('picture', $('#image')[0].files[0]);
// debugger;
        $.ajax({
            url: "/admin/users",
            type: "post", // Type of request to be send, called as method
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data) // A function to be called if request succeeds
            {
                console.log(data.request);
                console.log("ajax inside submit");
                alert('User added');
                $(".js-admins-list").empty().append(getUsers);
                $('.input-clear').val('');
                $(".js-statistics").load(location.href+" .js-statistics>*","");
            },
            error: (function(data){
                if (data.responseJSON.errors.first_name) {
                    $('.js-error-first-name').slideDown().text(data.responseJSON.errors.first_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
                if (data.responseJSON.errors.last_name) {
                    $('.js-error-last-name').slideDown().text(data.responseJSON.errors.last_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
                if (data.responseJSON.errors.email) {
                    $('.js-error-email').slideDown().text(data.responseJSON.errors.email[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
                if (data.responseJSON.errors.password) {
                    $('.js-error-password').slideDown().text(data.responseJSON.errors.password[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
                if (data.responseJSON.errors.picture) {
                    $('.js-error-picture').slideDown().text(data.responseJSON.errors.picture[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
        })
    };




// UPDATE USER

    window.updateUser = function(event){
        event.preventDefault()
        id = $('#hidden_user_id').val();
        first_name = $('.js-edit-fname').val();
        last_name = $('.js-edit-lname').val();
        email = $('.js-edit-mail').val();
        job_title_id = $('#update-job-title').val();
        if ($('.js-edit-fname').val() === "" || $('.js-edit-lname').val() === "" || 
            $('.js-edit-mail').val() === "" || ($('#password1').val() !== "" && $('#password-confirm1').val() !== $('#password1').val())) {
            document.querySelectorAll('.js-edit-user-input').forEach(input => {
                if(input.value === "" && input.name !== "user-password") {
                    document.querySelectorAll('.js-edit-error').forEach(error => {
                        if (input.name === error.attributes.name.value) {
                            error.style.maxHeight = "100vh"
                        } 
                    })
                } else if(input.value !== "" && input.name !== "user-password") {
                    document.querySelectorAll('.js-edit-error').forEach(error => {
                        if (input.name === error.attributes.name.value) {
                            error.style.maxHeight = "0"
                        } 
                    })                }
                
                if (input.value !=="" && input.name === "user-password" && input.value !== $('#password-confirm1').val()) {
                    document.querySelectorAll(".js-edit-error-password").forEach(passwordError => {
                        passwordError.style.maxHeight = "100vh"
                    })
                } else if (input.value !=="" && input.name === "user-password" && input.value === $('#password-confirm1').val()) {
                    document.querySelectorAll(".js-edit-error-password").forEach(passwordError => {
                        passwordError.style.maxHeight = "0"
                    })
                }
                
            })
             
                return
        }  
       
        $.ajax (
            {
                url: "/admin/users/" + id,
                type: 'PUT',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    job_title_id: job_title_id,
                },
                success: updateUserPassword(),
                error: (function(data){
                    if (data.responseJSON.errors.first_name) {
                        $('.js-error-edit-user-first-name').slideDown().text(data.responseJSON.errors.first_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                    }
                    if (data.responseJSON.errors.last_name) {
                        $('.js-error-edit-user-last-name').slideDown().text(data.responseJSON.errors.last_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                    }
                    if (data.responseJSON.errors.email) {
                        $('.js-error-edit-user-email').slideDown().text(data.responseJSON.errors.email[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                    }
                }),
            }).done(alert("User upadted"),
            $(".js-edit-user-form").css({"opacity":"0", "visibility":"hidden"}),
            $('.js-admins-list').empty().append(getUsers)
        );      



    };
// UPDATE USER PASSWORD


    window.updateUserPassword = function(){
        id = $('#hidden_user_id').val();
        password = $('#password1').val();
        password_confirmation = $('#password-confirm1').val();
        $.ajax ( {
            url: "/admin/users/"+id+"/update/password",
            type: 'PUT',
            data: {
                password: password,
                password_confirmation: password_confirmation
            },
            error: (function(data){
                if (data.responseJSON.errors.password) {
                    $('.js-error-edit-user-password').slideDown().text(data.responseJSON.errors.password[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
        }).done()
    };
//ADD USER MODAL BUTTON

    window.showNew = function(){
        var ix = $(this).index();
        $('.js-admin-modal').toggle( ix === '1' ? '0' : '1');
        $('.js-interactive-text').toggle( ix === '0' ? '1' : '0');
        if($(this).text()=="New user"){
            $(this).text("Close");
        } else {
            $(this).text("New user");
        }
    }
//EDIT FEEDBACK TIME MODAL BUTTON

    window.showTime = function(){
        var ix = $(this).index();
        $('.js-tab-2').toggle( ix === '1' ? '0' : '1');
        $('.js-feedback-interval').toggle( ix === '0' ? '1' : '0');
        if($(this).text()=="Edit time"){
            $(this).text("Close");
        } else {
            $(this).text("Edit time");
        }
    };
//SHOW STATS BUTTON

    window.showStats = function(){
        var ix = $(this).index();
        $('.js-statistics').toggle( ix === '1' ? '0' : '1');
        $('.js-stats-info').toggle( ix === '0' ? '1' : '0');
        if($(this).text()=="Statistics"){
            $(this).text("Close");
        } else {
            $(this).text("Statistics");
        }
    };
    //MOBILE VIEW TEST
    window.testScreen = function(){
        var width = window.innerWidth;
        if(width < 430 ){
            $('.js-media-show').click(mediaUsers);
            function mediaUsers(){
                $('.js-admin-modal').toggle();
                $('.js-interactive-text').toggle();
            }
            $('.js-media-time').click(mediaTime);
            function mediaTime(){
                $('.js-tab-2').toggle();
                $('.js-feedback-interval').toggle();
            }
            $('.js-media-stats').click(mediaStats);
            function mediaStats(){
                $('.js-statistics').toggle();
                $('.js-stats-info').toggle();
            }
        }
    };

// DELETE USER

    window.deleteUser = function(e) {

        var id = e.target.getAttribute("data-id");

        console.log(id)
        $.ajax (
            {
                url: "/admin/users/" + id,
                type: 'DELETE',
                data: {
                    id: id
                },
            }).done(function (data) {
            alert(data.success);
            $(".js-statistics").load(location.href+" .js-statistics>*","");
            $(".js-user-del"+id).remove();
        })
    };

// UPDATE COMPANY FEEDBACK DURATION

    window.updateFeedbackDurationTime = function() {

        let id = $(this).data('id');
        let feedback_duration_id = $('#feedback-time').val();
        $.ajax (
            {
                url: "/admin/companies/" + id,
                type: 'PUT',
                data: {
                    feedback_duration_id: feedback_duration_id,
                }
            }).done(function (data) {
            alert('Feedback time is updated.')
        });
    };

    $('.js-admin-edit-user-close').click(function() {
        $(".js-edit-user-form").css({"opacity":"0", "visibility":"hidden"})
    });


// change user status

    window.changeUserStatus = function() {

        let id = $(this).data('id');

        $.ajax({
            url: '/admin/users/' + id + '/update/status',
            type: 'put',
            data: {
                id: id
            }
        }).done(function (data) {
            $(".js-statistics").load(location.href+" .js-statistics>*","");
            alert(data.success);
        })
    };

    // edit image

    window.editImage = function(e) {

        e.preventDefault();
        let form_data = new FormData();
        form_data.append('picture', $('#file')[0].files[0]);
        form_data.append('_method', 'PUT');
        $.ajax({
            url: "/admin/users/" + $('#hidden_user_id').val() + "/update/picture",
            type: "post", // Type of request to be send, called as method
            data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData:false, // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
            {
                console.log(data.request)
            },
            error: (function(data){
                if (data.responseJSON.errors.picture) {
                    $('.js-error-edit-user-picture').slideDown().text(data.responseJSON.errors.picture[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
        }).done(alert('Picture is updated'));
    }
});
