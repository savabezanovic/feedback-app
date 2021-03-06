$(document).ready(function () {
    var addUserTimeout1 = false
    var addUserTimeout2 = false
    var addUserTimeout3 = false
    var addUserTimeout4 = false
    var addUserTimeout5 = false

    window.getUsers = function() {
        $.get(
            '/admin/users', function (data) {
                let output = [];

                $.each(data.users, function (i, user) {
                    output += `<tr class="company-users-table-body-row js-user-del${user.id}">
                                    <td class="company-users-table-body-data"> ${user.first_name}  </td><td class="company-users-table-body-data">  ${user.last_name}  </td>
                                    <td class="company-users-table-body-data">${user.email}</td>
                                    <td class="company-users-table-body-data">${user.profile.job_title !== null ? user.profile.job_title.name : "No job title"}</td>
                                    <td class="user-status-dot company-users-table-body-data">
                                    <input class="user-status-checkbox" data-id="${user.id}" name="chk-box" id="chk-box-${user.id}" value="1" type="checkbox" ${user.active === 1 ? "checked" : ""} 
                                    ${user.id.toString() === $('.js-logged-admin').attr('id') ? "disabled" : ""}>
                                        <label for="chk-box-${user.id}" class="user-status-toggle-outer">
                                            <span class="user-status-toggle-inner"></span>
                                        </label>
                                    </td>
                                    <td class="company-users-table-body-data users-table-center">
                                        <button id="${user.id}" class="users-table-button js-edit-user" data-id=${user.id}>
                                            <span class="table-button-large-screen-text">Edit</span><span class="table-button-small-screen-text">&#9998;</span>
                                        </button>
                                        ${user.id.toString() === $('.js-logged-admin').attr('id') ? '<span></span>' : 
                                        `<button class="users-table-button" id="delete-user" data-id=${user.id}>
                                            <span class="table-button-large-screen-text">Delete</span><span class="table-button-small-screen-text">&#10006;</span>
                                        </button>`}
                                    </td>
                                </tr>`
                });            
                $('.js-admins-list').append(output);
                $(".js-edit-user").click(editUser);
                function editUser(){
                    id = this.getAttribute('id');
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
                    $('#file').val("");
                    $('.js-image-upload-edit').html(`Upload an image<img class="admin-add-new-user-image-upload-icon" src="images/upload-icon.png" alt="upload">`)
                }

            }
        )
    };

    window.addUser = function(e) {
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
            type: "post", 
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            {
                console.log(data.request);
                console.log("ajax inside submit");
                alert('User added');
                $(".js-admins-list").empty().append(getUsers);
                $('.js-add-user-input').val('');
                $('.js-add-user-input').css('border-color', '#d3d4d5');
                $('.js-add-user-input-label').css({"opacity":0,"visibility":"hidden"})
                $('.js-image-upload-custom').html(`Upload an image <img class="admin-add-new-user-image-upload-icon" src="images/upload-icon.png" alt="upload">`)
                $(".js-statistics").load(location.href+" .js-statistics>*","");
            },
            error: (function(data){
                if (data.responseJSON.errors.first_name) {
                    if (!addUserTimeout1) {
                        addUserTimeout1 = true;
                        $('.js-error-add-user-first-name').text(data.responseJSON.errors.first_name[0]).css({"visibility" : "visible","opacity" : 1});
                        setTimeout(() => {
                            $('.js-error-add-user-first-name').css({"opacity" : 0, "visibility" : "hidden"});
                            addUserTimeout1= false;
                        }, 3000)
                    }

                }
                if (data.responseJSON.errors.last_name) {
                    if (!addUserTimeout2) {
                        addUserTimeout2 = true;
                        $('.js-error-add-user-last-name').text(data.responseJSON.errors.last_name[0]).css({"visibility" : "visible","opacity" : 1});
                        setTimeout(() => {
                            $('.js-error-add-user-last-name').css({"opacity" : 0, "visibility" : "hidden"});
                            addUserTimeout2 = false;
                        },3000)
                    }
                }
                if (data.responseJSON.errors.email) {
                    if (!addUserTimeout3) {
                        addUserTimeout3 = true
                        $('.js-error-add-user-mail').text(data.responseJSON.errors.email[0]).css({"visibility" : "visible","opacity" : 1});
                        setTimeout(() => {
                            $('.js-error-add-user-mail').css({"opacity" : 0, "visibility" : "hidden"});
                            addUserTimeout3 = false
                        },3000)
                    }
                }
                if (data.responseJSON.errors.password) {
                    if (!addUserTimeout4) {
                        addUserTimeout4 = true
                        $('.js-error-add-user-password').text(data.responseJSON.errors.password[0]).css({"visibility" : "visible","opacity" : 1});
                        setTimeout(() => {
                            $('.js-error-add-user-password').css({"opacity" : 0, "visibility" : "hidden"});
                            addUserTimeout4 = false
                        }, 3000)
                    }
                }
                if (data.responseJSON.errors.picture) {
                    if (!addUserTimeout5) {
                        addUserTimeout5 = true
                        $('.js-error-add-user-image').text(data.responseJSON.errors.picture[0]).css({"visibility" : "visible","opacity" : 1});
                        setTimeout(() => {
                            $('.js-error-add-user-image').css({"opacity" : 0, "visibility" : "hidden"});
                            addUserTimeout5 = false
                        },3000)
                    }
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
                success: editImage(),
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
            $('.js-admins-list').empty().append(getUsers),
            id === $('.js-logged-admin').attr('id') &&
            window.location.reload()
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

// DELETE USER

    window.deleteUser = function() {

        var id = this.getAttribute("data-id");

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

    window.editImage = function() {
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
        }).done();
    }
});
