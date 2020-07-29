$(document).ready(function(){
    //GET ALL COMPANY
    window.getCompany = function(){
        $.get(
            '/superadmin/companies', function (data) {
                let output = [];
                data.companies.forEach(company => {
                    output += `<div class="super-admin-company-container js-super-company-container">
                                    <div class="super-admin-company-name js-current-company-name-${company.id}">${company.name}</div>
                                    <div class="super-admin-company-activity">${company.active === 1 ? "&#10004;" : "&#10006;"}</div>
                                    <input type="checkbox" id="active-${company.id}" ${company.active === 1 ? "checked" : ""} class="super-admin-company-checkbox"/>
                                    <label for="active-${company.id}" class="super-admin-toggle-outer">
                                            <span class="super-admin-toggle-inner"></span>
                                    </label>
                                    <input type="text" placeholder="Change company name" class="js-change-company-name-input-${company.id} super-admin-input " />
                                    <button data-id=${company.id} class="super-admin-button super-admin-company-button js-change-company-name">CHANGE</button>
                                    <button data-id="${company.id}" class="super-admin-button super-admin-company-button js-delete-company">DELETE</button>
                               </div>`;
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

    //UPDATE COMPANY

    window.editCompany = function(e) {
        let  id =  e.target.getAttribute("data-id");
        let active = $(`#active-${id}`).is(":checked") ? 1 : 0;
        let name =  !$(`.js-change-company-name-input-${id}`).val() ? $(`.js-current-company-name-${id}`).html() : $(`.js-change-company-name-input-${id}`).val();
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
