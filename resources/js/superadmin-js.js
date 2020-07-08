$(document).ready(function () {
    window.getAdmins = function(){
        $.get(
            '/superadmin/admins', function (data) {
                let output = [];
                data.admins.forEach(function (e) {
                    output += '<p>' + e.first_name + ' ' + e.last_name + ' <button data-id="'+ e.id +
                        '" class="delete-admin super-admin-btn" name="delete-admin">DEL</button>'+
                        '<button name="edit-admin" id="'+ e.id +'" class="super-admin-btn js-edit-modal">EDIT</button></p>';
                });
                $('.js-admins').append(output);
                $(".js-edit-modal").click(editAdmin);
                function editAdmin(){
                    id = $(this).attr('id');
                    $.get('/superadmin/admins/'+id+'/update', function(data){
                            $('#first_name').val(data.admin.first_name);
                            $('#last_name').val(data.admin.last_name);
                            $('#admin-email').val(data.admin.email);
                        }
                    );
                    $('#hidden_id').val(id);
                    $(".edit-modal").show();
                }
            }
        )
    };

    window.updateAdmin = function(){
        id = $('#hidden_id').val();
        first_name = $('#first_name').val();
        last_name = $('#last_name').val();
        email = $('#admin-email').val();
        $.ajax (
            {
                url: "/superadmin/admins/" + id + "/update",
                type: 'PUT',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    email: email
                }
            }).fail(function (data) {
            if (data.responseJSON.errors.first_name) {
                $('.js-error-admin-edit-first-name').slideDown().text(data.responseJSON.errors.first_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
            if (data.responseJSON.errors.last_name) {
                $('.js-error-admin-edit-last-name').slideDown().text(data.responseJSON.errors.last_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
            if (data.responseJSON.errors.email) {
                $('.js-error-admin-edit-email').slideDown().text(data.responseJSON.errors.email[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
        })
            .done(function(data){
                $(".js-admins").empty().append(getAdmins);
                $(".edit-modal").hide()
            })
    };

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
                $('.js-error-admin-first-name').slideDown().text(data.responseJSON.errors.first_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
            if (data.responseJSON.errors.last_name) {
                $('.js-error-admin-last-name').slideDown().text(data.responseJSON.errors.last_name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
            if (data.responseJSON.errors.email) {
                $('.js-error-admin-email').slideDown().text(data.responseJSON.errors.email[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
            if (data.responseJSON.errors.password) {
                $('.js-error-admin-password').slideDown().text(data.responseJSON.errors.password[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
        })
            .done(function(data){
                $('.js-admins').empty().append(getAdmins);
                $(".superadmin-modal").toggleClass("modal");
                $(".js-superadmin-modal-btn").text(function(i, text){
                    return text === "Close" ? "Add new admin" : "Close";
                })
                $(".superadmin-modal > input").val("")
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
            $('.js-admins').empty().append(getAdmins);
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

    $('#tabs ul li a').click(function(){
        $('#tabs ul li a').removeClass('current-tab');
        $(this).addClass('current-tab');
    });
    //Search company
    $(document).ready(function(){
        $(".search-company").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".js-companies p").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });


    window.getModal = function(){
        $(".superadmin-modal").toggleClass("modal");
        $(this).text(function(i, text){
            return text === "Close" ? "Add new admin" : "Close";
        })
    };

    window.editAdmin = function(){
        $(".edit-modal").show();
    };

    window.closeEdit = function(){
        $('.edit-modal').hide();
    }

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
                $('.js-error-admin-edit-password').slideDown().text(data.responseJSON.errors.password[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
        })
            .done(
                alert('updated'),
                $('#password').val(''),
                $('#password-confirm').val('')
            );
    }
});
