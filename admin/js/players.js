
$('#player_edit_modal').on('show.bs.modal', function (event) {
    var modal = $(this);
    var button = $(event.relatedTarget) // Button that triggered the modal    
    var id = button.data('id');    
    $.ajax({
        url: "ajax/player_info.php?player_id="+id,
        success: function(data){
            var obj = JSON.parse(data);
            // console.log(obj);
            modal.find('.modal-body #player-jersey').val(obj.player_jerseynumber__blazeweb);
            modal.find('.modal-body #player-fname').val(obj.player_firstname__blazeweb);
            modal.find('.modal-body #player-lname').val(obj.player_lastname__blazeweb);
            modal.find('.modal-body #player-position').val(obj.player_positions__blazeweb);
            modal.find('.modal-body #player-height').val(obj.player_height__blazeweb);
            modal.find('.modal-body #player-weight').val(obj.player_weight__blazeweb);
            modal.find('.modal-body #player-sypnosis').val(obj.player_sypnosis__blazeweb);
            modal.find('.modal-body #player-id').val(obj.player_id__blazeweb);
            modal.find('.modal-body #player-image').attr("src","../img/players/"+obj.player_image__blazeweb+obj.player_imagetype__blazeweb);
            modal.find();
        },
        error: function(err){
            console.log(error);
        }
        
    })
    
    // var jersey = button.data('jersey') // Extract info from data-* attributes
    // var fname = button.data('fname')
    // var lname = button.data('lname')
    // var position = button.data('position')
    // var height = button.data('height')
    // var weight = button.data('weight')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    
    
    
  })