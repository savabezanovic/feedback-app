$(document).ready(function () {
    var timeout1 = false;
    var timeout2 = false;
    var timeout3 = false;
    var timeout4 = false;
    var timeout5 = false;
    window.getAdmins = function(){
        $.get(
            '/superadmin/admins', function (data) {
                let output = [];
                data.admins.forEach(function (admin) {
                    const companyName = $(`.js-current-company-name-${admin.company_id}`).html();
                    output += `<div class="super-admin-admin-container">
                                    <div class="super-admin-admin-name">${admin.first_name} ${admin.last_name}</div>
                                    <div class="super-admin-admin-email">${admin.email}</div>
                                    <div class="super-admin-admin-company-name">${companyName}</div>
                                    <button class="super-admin-button super-admin-admins-button js-super-admin-edit-admin" id=${admin.id}>
                                        <span class="super-admin-admin-button-large-screen">Edit Admin</span><span class="super-admin-admin-button-small-screen">&#9998;</span>                                    
                                    </button>
                                    <button data-id="${admin.id}" class="super-admin-button super-admin-admins-button super-admin-admins-button-delete js-super-admin-delete-admin">
                                        <span class="super-admin-admin-button-large-screen">Delete</span><span class="super-admin-admin-button-small-screen">&#10006;</span>
                                    </button>
                               </div>`
                });
                $('.js-all-admins').append(output);
                function editAdmin(){
                    id = $(this).attr('id');
                    $.get('/superadmin/admins/'+id+'/update', function(data){
                            $('#first_name').val(data.admin.first_name);
                            $('#last_name').val(data.admin.last_name);
                            $('#admin-email').val(data.admin.email);
                            $('#password1').val("");
                            $('#password-confirm1').val("");
                            document.querySelectorAll('.js-input-textarea').forEach(input => {
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
                    );
                    $('#hidden_id').val(id);
                   
                    $('.js-edit-admin-form').css({"visibility" : "visible", "opacity": "1"})
                }
                $(".js-super-admin-edit-admin").click(editAdmin);

            }
        )
    };

    window.updateAdmin = function(){
        id = $('#hidden_id').val();
        first_name = $('#first_name').val();
        last_name = $('#last_name').val();
        email = $('#admin-email').val();
        password = $('#password1').val();
        password_confirmation = $('#password-confirm1').val();
        $.ajax (
            {
                url: "/superadmin/admins/" + id + "/update",
                type: 'PUT',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email
                }, success: updatePassword()
            }).fail(function (data) {
            if (data.responseJSON.errors.first_name) {
                if (!timeout1) {
                    timeout1 = true
                    $('.js-error-admin-edit-first-name').text(data.responseJSON.errors.first_name[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-admin-edit-first-name').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout1= false
                    },3000)
                }
            }
            if (data.responseJSON.errors.last_name) {
                if (!timeout2) {
                    timeout2 = true
                    $('.js-error-admin-edit-last-name').text(data.responseJSON.errors.last_name[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-admin-edit-last-name').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout2 = false
                    },3000)
                }
            }
            if (data.responseJSON.errors.email) {
                if (!timeout3) {
                    timeout3 = true
                    $('.js-error-admin-edit-email').text(data.responseJSON.errors.email[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-admin-edit-email').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout3 = false
                    },3000)
                }
            }
            
        })
            .done(function(data){
                $(".js-all-admins").empty();
                getAdmins();
                if (password !== password_confirmation) {
                    return
                } else if (password.lengt < 8 && password !== "") {
                    return
                }
                $('.js-edit-admin-form').css({"opacity" : "0", "visibility" : "hidden"})
            })
    };

    window.updatePassword = function(){
        id = $('#hidden_id').val();
        password = $('#password1').val();
        password_confirmation = $('#password-confirm1').val();
        $.ajax( {
            url: "superadmin/admins/"+id+"/update/password",
            type: 'PUT',
            data: {
                password: password,
                password_confirmation: password_confirmation
            },
        }).fail(function (data) {
            if (data.responseJSON.errors.password) {
                if (data.responseJSON.errors.password[0] !== "The password field is required.") {
                    if (!timeout4) {
                        timeout4 = true
                        console.log(data.responseJSON.errors.password[0])
                        $('.js-error-admin-edit-password').text(data.responseJSON.errors.password[0]).css({"visibility" : "visible","opacity" : 1});
                        setTimeout(() => {
                            $('.js-error-admin-edit-password').css({"opacity" : 0, "visibility" : "hidden"});
                            timeout4= false
                        },3000)
                    }
                }   
            }     
        })
            .done(
                $('#password').val(''),
                $('#password-confirm').val('')
            );
    }


    //ADD ADMIN

    window.addAdmin = function(){
        let first_name = $('#first-name').val();
        let last_name = $('#last-name').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let password_confirmation = $('#password-confirm').val();
        let company_id = $('#company-id').val();
        $.post('/superadmin/admins',
            {
                first_name: first_name,
                last_name: last_name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
                company_id: company_id
            }
        ).fail(function (data) {
            if (data.responseJSON.errors.first_name) {
                if (!timeout1) {
                    timeout1 = true
                    $('.js-error-add-admin-first-name').text(data.responseJSON.errors.first_name[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-add-admin-first-name').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout1= false
                    },3000)
                }

            }
            if (data.responseJSON.errors.last_name) {
                if (!timeout2) {
                    timeout2 =true
                    $('.js-error-add-admin-last-name').text(data.responseJSON.errors.last_name[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-add-admin-last-name').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout2 = false
                    },3000)
                }
            }
            if (data.responseJSON.errors.email) {
                if (!timeout3) {
                    timeout3 = true
                    $('.js-error-add-admin-email').text(data.responseJSON.errors.email[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-add-admin-email').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout3= false
                    },3000)
                }

            }
            if (data.responseJSON.errors.password) {
                if (!timeout4) {
                    timeout4 =true
                    $('.js-error-add-admin-password').text(data.responseJSON.errors.password[0]).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-error-add-admin-password').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout4 = false
                    },3000)
                }
            }
        })
            .done(function(){
                $('.js-all-admins').empty();
                getAdmins();
                $('.js-add-admin-input').val("");
                $('.js-input-textarea').css("border-color","#d3d4d5")
                $('.js-add-admin-input-label').css({"opacity": "0", "visibility" : "hidden"})
                
            })
    };


    window.getSkills = function(){
        $.get(
            '/superadmin/skills', function (data) {
                let output = [];
                data.skills.forEach(function (skill) {
                    output += `<div class="skill-container js-skill-container" name="${skill.name}">
                    <div class="skill-name">${skill.name}</div>
                    <input type="text" id="edit-skill-${skill.id}" data-id="${skill.id}" name="skill-edit-${skill.id}" class="super-admin-input change-skill-input js-change-skill-name-${skill.id} js-input-textarea" placeholder="Change skill name"/>
                    <button class="super-admin-button skill-button js-change-skill-name" data-id="${skill.id}">
                        <span class="super-skills-button-large-screen">Change</span><span class="super-skills-button-small-screen">&#9998;</span>                                    
                    </button>
                    <button data-id="${skill.id}" class="super-admin-button skill-button js-delete-skill">
                        <span class="super-skills-button-large-screen">Delete</span><span class="super-skills-button-small-screen">&#10006;</span>                                    
                    </button>
                </div>`
                    
                });
                $('.js-skills').append(output);
            }
        )
    };



    window.addSkill = function(){
        var name = $('.js-add-new-skill').val();
        $.post('/superadmin/skills',
            {
                name: name
            },
        ).fail(function (data) {
            if (!timeout5) {
                timeout5 =true
                $('.js-add-skill-error').text(data.responseJSON.errors.name).css({"visibility" : "visible","opacity" : 1});
                setTimeout(() => {
                    $('.js-add-skill-error').css({"opacity" : 0, "visibility" : "hidden"});
                    timeout5 = false
                },3000)
            }
        })
            .done(function(data){
                $('.js-skill').val('');
                $('.js-add-new-skill').val("");
                $('.js-add-new-skill').css("border-color", "#d3d4d5");
                $('.js-add-skill-label').css({"opacity" : "0", "visibility" : "hidden"})
                $('.js-skills').empty().append(getSkills);
            })
    };

    // delete skill

    window.deleteSkill = function() {

        let id =  this.getAttribute('data-id')
        $.ajax (
            {
                url: "/superadmin/skills/" + id + "/delete",
                type: 'DELETE',
                data: {
                    id: id
                },
            }).done(function (data) {
            $('.js-skills').empty().append(getSkills);
        })
    };

    // edit skill

    window.editSkill = function(e) {

        let id =  $(this).attr("data-id");
        let name = $(`.js-change-skill-name-${id}`).val();
        $.ajax (
            {
                url: "/superadmin/skills/" + id + "/update",
                type: 'PUT',
                data: {
                    name: name
                },
            }).fail(function (data) {
                console.log(data.responseJSON.errors.name)
            })
            .done(function (data) {
                $('.js-skills').empty().append(getSkills);
            })
    };

    // delete admin

    window.deleteAdmin = function() {

        let id = this.getAttribute("data-id");
        $.ajax (
            {
                url: "/superadmin/users/" + id + "/delete",
                type: 'DELETE',
                data: {
                    id: id
                },
            }).done(function (data) {
            $('.js-all-admins').empty().append(getAdmins);
        })
    };

    $(document).on ('click', '.js-super-show', function(){
        let id = $(this).data('id');
        let field = $('.js-super-hide'+id);
        field.toggle();
        $(this).toggleClass('fa-plus-circle fa-minus-circle')

    });
    $(document).on ('click', '.js-skill-show', function(){
        let id = $(this).data('id');
        let field = $('.js-skill-hide'+id);
        field.toggle();
        $(this).toggleClass('fa-plus-circle fa-minus-circle')
    });



});
