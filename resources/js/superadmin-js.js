$(document).ready(function () {
    var timeout1 = false;
    var timeout2 = false;
    var timeout3 = false
    var timeout4 = false
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
                                    <button class="super-admin-button super-admin-admins-button js-super-admin-edit-admin" id=${admin.id}>EDIT ADMIN</button>
                                    <button data-id="${admin.id}" class="super-admin-button super-admin-admins-button js-super-admin-delete-admin">DELETE ADMIN</button>
                               </div>`
                });
                $('.js-all-admins').append(output);
                $(".js-super-admin-edit-admin").click(editAdmin);
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

    window.getSkills = function(){
        $.get(
            '/superadmin/skills', function (data) {
                let output = [];
                data.skills.forEach(function (e) {
                    output += '<p class="media-list"><span style="margin:auto 0; margin-right:10px">'+ e.name + '</span>' +
                        '<button data-id="'+ e.id +
                        '" class="delete-skill super-admin-btn" name="delete-skill">DEL</button>'+
                        '<i style="margin:auto 0" class="add fas fa-plus-circle js-skill-show" data-id="'+ e.id +'"></i>'+
                        '<span class="hide js-skill-hide'+ e.id +'"><button data-id="'+ e.id +
                        '"class="edit-skill super-admin-btn" name="edit-skill">Update</button><input data-id="'+ e.id +
                        '"class="js-edit-skill-name'+ e.id +'" placeholder="Update skill name"></span><br><span class="hidden js-edit-skill'+ e.id +'"><br><br></span></p>';
                });
                $('.js-skills').append(output);
            }
        )
    };


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
                $('.js-input-textarea-label').css({"opacity": "0", "visibility" : "hidden"})
                
            })
    };

    window.addSkill = function(){
        var name = $('.js-skill').val();
        $.post('/superadmin/skills',
            {
                name: name
            },
        ).fail(function (data) {
            if (data.responseJSON.errors.name) {
                $('.js-add-skill').slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
        })
            .done(function(data){
                $('.js-skill').val('');
                $('.js-skills').empty().append(getSkills);
            })
    };

    // delete skill

    window.deleteSkill = function(e) {

        let id =  e.target.getAttribute("data-id");
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

        let id =  e.target.getAttribute("data-id");
        let name = $('.js-edit-skill-name'+id).val();
        $.ajax (
            {
                url: "/superadmin/skills/" + id + "/update",
                type: 'PUT',
                data: {
                    name: name
                },
            }).fail(function (data) {
            if (data.responseJSON.errors.name) {
                $('.js-edit-skill' + id).slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
        })
            .done(function (data) {
                $('.js-skills').empty().append(getSkills);
            })
    };

    // delete admin

    window.deleteAdmin = function(e) {

        let id = e.target.getAttribute("data-id");
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


    window.editAdmin = function(){
        $(".edit-modal").show();
    };

    window.closeEdit = function(){
        $('.edit-modal').hide();
    }

});
