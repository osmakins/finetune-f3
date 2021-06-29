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
        output +=        '<button type="button" class="btn-close closeWhite" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        output += "</div>";
        output += '<div class="modal-body" style="text-align: left;">';
        output += html ? html : "&nbsp;";
        output += "</div>";
        output +=        '<div class="modal-footer">' +        (bottomDesc ? bottomDesc : "&nbsp;") +        '<button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-hidden="true"><span class="fa fa-times"></span> &nbsp; close </button></div>';
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

    $('.open-project').on('click',function(){
        let id = $(this).data('id');
        $.post('/routeproject', {'id':id, read: 'read', modal: true}, function(data){
          // data = $.parseJSON(data);
          openModalWindow(data, 'Project Details', null);
        })
    })

    $('.edit-project').on('click',function(){
        let id = $(this).data('id');
        $.post('/routeproject', {'id':id, update:'update', modal: true}, function(data){
          openModalWindow(data, 'Update Project', null)
        })
    })

    $('.add-project').on('click',function(){
        $.post('/routeproject', {create: 'create', modal: true}, function(data){
          openModalWindow(data, 'Add Project', null)
        })
    })

    $('.del-project').on('click',function(){
        let id = $(this).data('id');
        $.post('/routeproject', {'id':id, delete:'delete', modal: true}, function(data){
          openModalWindow(data, 'Delete Project?', null);
        })
    })
});