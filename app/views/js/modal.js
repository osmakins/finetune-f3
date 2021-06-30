$(document).ready(function(){
  function openModalWindow(html, title, bottomDesc) {
    //container    
    var modalEl = "modalContent";
    //luodaan tarvittava html    
        var output =        '<div id="' +        modalEl +        '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalContentLabel" aria-hidden="true">';
        output += '<div class="modal-dialog modal-lg" role="document">';
        output += '<div class="modal-content">';
        output += '<div class="modal-header top-card-header">';
        output +=        '<h5 class="modal-title" id="gal_descLabel">' +        (title ? title : "") +        "</h5>";
        output +=        '<button type="button" class="btn-close closeWhite" data-bs-dismiss="modal" aria-label="Close"/>';
        output += "</div>";
        output += '<div class="modal-body" style="text-align: left;">';
        output += html ? html : "&nbsp;";
        output += "</div>";
        output +=        '<div class="modal-footer">' +        (bottomDesc ? bottomDesc : "&nbsp;") +        '<button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-hidden="true"><span class="fa fa-times"></span> &nbsp; dismiss </button></div>';
        output += "</div>";
        output += "</div>";
        output += "</div>";
        //korvataan vanha html    
        var checker = $("#" + modalEl)
            .children(".modal-header")
            .html();
        if (checker == undefined || checker == null || checker == "") {
            $("#" + modalEl).replaceWith(output);
            //ikkuna auki        
            setTimeout(function () {
                $("#" + modalEl).modal("show");
            }, 250);
        } else {
            $("#" + modalEl).modal("hide");
            $("#" + modalEl).replaceWith(output);
            $("#" + modalEl).modal("show");
        }
        $("#" + modalEl).on("hide.bs.modal", function () {
            $("#" + modalEl).html("");
        });
    }

    function route(url, method, data, success){
        $.ajax({
            url:'/'+url,
            method: method.toUpperCase(),
            data: data,
            success: success
        })
    }
    
    $('.project-modal').on('click', function(){
        let config = $(this).data('config');
        config.action = $(this).data('action');
        config.modal = true;

        route('modal', 'get', config, function(data){
            console.log(data)
            openModalWindow(data, 'Project Details', null);
        })
    })
});