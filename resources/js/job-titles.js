$(document).ready(function () {
    window.getJobTitles = function() {
        $.get(
            '/superadmin/job-titles', function (data) {
                let output = [];
                data.positions.data.forEach(function (job) {
                    output += `<div class="job-title-container js-job-title-container" name="${job.name}">
                                    <div class="job-name">${job.name}</div>
                                    <input type="text" id="edit-job-${job.id}" data-id="${job.id}" name="job-edit-${job.id}" class="super-admin-input edit-job-name js-input-textarea" placeholder="Change job name"/>
                                    <button class="super-admin-button js-change-job-name" data-id="${job.id}">Change</button>
                                    <button data-id="${job.id}" class="super-admin-button job-delete-button js-delete-job">Delete</button>
                                </div>`
                    
                    
                });

                $('.js-jobs-container').append(output);
            }
        )
    };

    // Add job

    window.addJobTitle = function() {
        $.post(
            '/superadmin/job-titles',
            {
                name: $('.js-add-job').val()
            })
            .fail(function (data) {
                if (data.responseJSON.errors.name) {
                    $('.js-admin-job-title-name').slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
            .done(function(){
                $('.js-jobs-container').empty().append(getJobTitles)
                $('.js-add-job').val("");
                $('.js-add-job').css("border-color", "#d3d4d5");
                $('.js-add-job-label').css({"opacity" : "0", "visibility" : "hidden"})
            })
    };

    // Update job title

    window.editJobTitle = function() {

        let id = $(this).attr("data-id");
        let name = $(`#edit-job-${id}`).val();
        console.log(name)
        $.ajax (
            {
                url: "/superadmin/job-titles/" + id,
                type: 'PUT',
                data: {
                    name: name,
                }
            })
            .fail(function (data) {
                if (data.responseJSON.errors.name) {
                    console.log(data.responseJSON.errors.name) 
                    //$('.js-edit-job-title-name' + id).slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
            .done(function () {
                $('.js-jobs-container').empty().append(getJobTitles)
                
            });
    };

    // Delete job title

    window.deleteJobTitle = function() {

        let id = $(this).attr("data-id");
        $.ajax (
            {
                url: "/superadmin/job-titles/" + id,
                type: 'DELETE',
                data: {
                    id: id
                },
            }).done(function (data) {
            $('.js-jobs-container').empty().append(getJobTitles)
        })
    };
});
