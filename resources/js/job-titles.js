$(document).ready(function () {
    window.getJobTitles = function() {
        $.get(
            '/superadmin/job-titles', function (data) {
                let output = [];
                let outputs =[];
                console.log(data.positions.data);
                data.positions.data.forEach(function (e) {
                    output += '<p class="media-list">' + e.name +
                        '<button data-id="'+ e.id +
                        '" class="delete-position super-admin-btn" name="delete-position">DEL</button>'+
                        '<i style="margin:auto 0" class="add fas fa-plus-circle js-job-show" data-id="'+ e.id +'"></i>'+
                        '<span class="js-job-hide'+ e.id +' hide"><button data-id="'+ e.id +
                        '"class="edit-position super-admin-btn" id="edit-position">Update</button>' +
                        '<input type="text" name="edit-position'+ e.id +'" id="edit-position'+ e.id +'" data-id="'+ e.id +
                        '"class="js-edit-input'+ e.id +'" placeholder="Update job title">' +
                        '</span><br><span class="hidden js-edit-job-title-name'+ e.id +'"><br><br></span></p>';
                });

                outputs += data.links;

                $('.js-positions').append(output);
                $('.js-pagination').append(outputs);
            }
        )
    };

    // Add job

    window.addJobTitle = function() {
        $.post(
            '/superadmin/job-titles',
            {
                name: $('[name="position-name"]').val()
            })
            .fail(function (data) {
                if (data.responseJSON.errors.name) {
                    $('.js-admin-job-title-name').slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
            .done(function(data){
                $('.js-positions').empty().append(getJobTitles);
                $('.js-position').val("");
            })
    };

    // Update job title

    window.editJobTitle = function(e) {

        let id = e.target.getAttribute("data-id");
        let name = $('#edit-position'+id).val();
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
                    $('.js-edit-job-title-name' + id).slideDown().text(data.responseJSON.errors.name[0]).fadeIn(3000).delay(3000).fadeOut("slow");
                }
            })
            .done(function (data) {
                $('.js-positions').empty().append(getJobTitles);
            });
    };

    // Delete job title

    window.deleteJobTitle = function(e) {

        let id = e.target.getAttribute("data-id");
        $.ajax (
            {
                url: "/superadmin/job-titles/" + id,
                type: 'DELETE',
                data: {
                    id: id
                },
            }).done(function (data) {
            $('.js-positions').empty().append(getJobTitles);
        })
    };

    //Search positions
    $(".search-position").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".js-positions p").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //Update job
    $(document).on ('click', '.js-job-show', function(){
        let id = $(this).data('id');
        let field = $('.js-job-hide'+id);
        field.toggle();
        $(this).toggleClass('fa-plus-circle fa-minus-circle')
    });
});
