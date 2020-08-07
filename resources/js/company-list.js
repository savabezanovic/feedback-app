$(document).ready(function(){
    var timeout5 = false
    //GET ALL COMPANY
    window.getCompany = function(){
        $.get(
            '/superadmin/companies', function (data) {
                let output = [];
                data.companies.forEach(company => {
                    output += `<div class="super-admin-company-container js-super-company-container" name="${company.name}">
                                    <div class="super-admin-company-name js-current-company-name-${company.id}">${company.name}</div>
                                    <div class="super-admin-company-activity">${company.active === 1 ? "&#10004;" : "&#10006;"}</div>
                                    <input type="checkbox" id="active-${company.id}" ${company.active === 1 ? "checked" : ""} class="super-admin-company-checkbox"/>
                                    <label for="active-${company.id}" class="super-admin-toggle-outer">
                                            <span class="super-admin-toggle-inner"></span>
                                    </label>
                                    <input type="text" placeholder="Change name" class="js-change-company-name-input-${company.id} super-admin-input super-admin-company-input js-input-textarea" />
                                    <button data-id=${company.id} class="super-admin-button super-admin-company-button js-change-company-name">
                                        <span class="super-admin-company-button-large-screen">Change</span><span class="super-admin-company-button-small-screen">&#9998;</span>                                    
                                    </button>
                                    <button data-id="${company.id}" class="super-admin-button super-admin-company-button js-delete-company">
                                        <span class="super-admin-company-button-large-screen">Delete</span><span class="super-admin-company-button-small-screen">&#10006;</span>
                                    </button>
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
        ).fail(function () {
                if (!timeout5) {
                    timeout5 = true
                    $('.js-add-company-error').text("You must input company name").css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-add-company-error').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout5= false
                    },3000)
                }
            
        })
            .done(function(data){
                $('.js-companies').empty().append(getCompany);
                $('#company-id').append('<option value="'+ data.company.id +'">'+ name +'</option>');
                $('.js-company-name').val("");
                $('.js-company-name').css("border-color", "#d3d4d5");
                $('.add-a-company-label').css({"opacity":"0","visibility":"hidden"})
            })
    };
    //DELETE COMPANY

    window.deleteCompany = function() {

        let id =  this.getAttribute("data-id");
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
            setTimeout(() => {
                $('.js-all-admins').empty().append(getAdmins);
            },100)
        })
    };

    //UPDATE COMPANY

    window.editCompany = function(e) {
        let  id =  this.getAttribute("data-id");
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
        })
            .done(function (data) {
                $('.js-companies').empty().append(getCompany);
                $("#company-id option[value='"+id+"']").remove();
                $('#company-id').append('<option value="'+ id +'">'+ name +'</option>')
                setTimeout(() => {
                    $('.js-all-admins').empty().append(getAdmins);
                },100)
    
            });
    }
});
