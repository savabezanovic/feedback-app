$(document).ready(function(){
    //GET ALL COMPANY
    window.getCompany = function(){
        $.get(
            '/superadmin/companies', function (data) {
                let output = [];
                data.companies.forEach(function (e) {
                    output += '<p><span style="margin:auto 0; margin-right:10px">'+ e.name + '</span>' +
                        (e.active === 1 ? '<span title="active company"class="dot"></span>' : '<span title="Inactive company" class="dot-red"></span>') + '<button data-id="'+ e.id +
                        '" class="delete-company super-admin-btn" name="delete-company">DEL</button>'+
                        '<i style="margin:auto 0" class="add fas fa-plus-circle js-super-show" data-id="'+ e.id +'"></i>'+
                        '<span class="hide js-super-hide'+ e.id +'"><button data-id="'+ e.id +
                        '"class="edit-company super-admin-btn" name="edit-company">Update</button><input data-id="'+ e.id +
                        '"class="js-edit-input-company-name'+ e.id +'" value="'+ e.name +'">'+
                        '<input class="js-edit-company-name'+ e.id +'name="active" id="active-'+ e.id +'" type="checkbox"' +
                        (e.active === 1 ? "checked" : "")
                        + ">"+'</span><br><span class="hidden js-error-edit-company-name'+ e.id +'"><br><br></span></p>';
                });
                $('.js-companies').append(output);

            }
        )
    };

    //ADD COMPANY

    window.addCompany = function(){
        var name = $('.js-company-name').val();
        $.post('/superadmin/companies',
            {
                name: name
            },
        ).fail(function (data) {
            if (data.responseJSON.errors.name) {
                $('.js-admin-company-name').slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            }
        })
            .done(function(data){
                $('.js-companies').empty().append(getCompany);
                $('#company-id').append('<option value="'+ data.company.id +'">'+ name +'</option>');
                $('.js-company').val("");
            })
    };
    //DELETE COMPANY

    window.deleteCompany = function(e) {

        let id =  e.target.getAttribute("data-id");
        $.ajax (
            {
                url: "/superadmin/companies/" + id + "/delete",
                type: 'DELETE',
                data: {
                    id: id
                },
            }).done(function (data) {
            $('.js-companies').empty().append(getCompany);
            $("#company-id option[value='"+id+"']").remove();
        })
    };

    $(document).on ('click', '.delete-company', function () {

    });

    //UPDATE COMPANY

    window.editCompany = function(e) {
        let  id =  e.target.getAttribute("data-id");
        let active = '';
        let name = $('.js-edit-input-company-name'+id).val();
        if (document.getElementById('active-' + id).checked) {
            active = 1;
        }
        else {
            active = 0;
        }
        $.ajax (
            {
                url: "/superadmin/companies/" + id + "/update",
                type: 'PUT',
                data: {
                    name: name,
                    active: active
                }
            }).fail(function (data) {
            // if (data.responseJSON.errors.name) {
            //     $('.js-error-edit-company-name' + id).slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
            // }
            console.log(data.responseJSON)
        })
            .done(function (data) {
                $('.js-companies').empty().append(getCompany);
                $("#company-id option[value='"+id+"']").remove();
                $('#company-id').append('<option value="'+ id +'">'+ name +'</option>')
            });
    }
});
