$(document).ready(function () {
    var timeout = false;
    window.getJobTitles = function() {
        $.get(
            '/superadmin/job-titles', function (data) {
                let output = [];
                data.jobTitles.forEach(function (job) {
                    if (job.name !== "Admin") {
                        output += 
                        `<div class="job-title-container js-job-title-container" name='${job.name}'>
                            <div class="job-name">${job.name}</div>
                            <input type="text" id="edit-job-${job.id}" data-id="${job.id}" name="job-edit-${job.id}" class="super-admin-input edit-job-name js-input-textarea" placeholder="Change job name"/>
                            <button class="super-admin-button jobs-button js-change-job-name" data-id="${job.id}">
                                <span class="super-jobs-button-large-screen">Change</span><span class="super-jobs-button-small-screen">&#9998;</span>                                    
                            </button>
                            <button data-id="${job.id}" class="super-admin-button jobs-button js-delete-job">
                                <span class="super-jobs-button-large-screen">Delete</span><span class="super-jobs-button-small-screen">&#10006;</span>                                    
                            </button>
                        </div>`
                    }
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
                console.log("data")
                if (!timeout) {
                    timeout =true
                    $('.js-add-job-error').text(data.responseJSON.errors.name).css({"visibility" : "visible","opacity" : 1});
                    setTimeout(() => {
                        $('.js-add-job-error').css({"opacity" : 0, "visibility" : "hidden"});
                        timeout = false
                    },3000)
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
