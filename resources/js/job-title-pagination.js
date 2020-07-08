$(document).ready(function(){


    window.getPage = function(e){
        e.preventDefault();
        console.log('proba');
        var page = e.target.getAttribute('href').split('page=')[1];
        fetch_data(page);
    }

    window.fetch_data = function(page){
        $.ajax({
            url:"/superadmin/job-titles/paginated?page="+page,
            success:function(data)
            {
                let output = [];
                let outputs = [];
                console.log(data.jobTitles.data);
                data.jobTitles.data.forEach(function (e) {
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

                $('.js-positions').html(output);
                $('.js-pagination').html(outputs);

            }
        });
    }

});