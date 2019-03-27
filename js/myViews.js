//Borra la user_view con id=view_id
function deleteView(view_id)
{
     //AJAX
     var request = new XMLHttpRequest();

     // Open connection
     request.open('POST', 'includes/deleteViewAjax.php', true);
     // Set up handler for when request finishes
     request.onload = function () {
         if (request.status === 200 && request.response == "ok") {
            var element = document.getElementById(view_id);
            element.parentNode.removeChild(element);
            Snackbar.show({text: 'View deleted successfully.'});
            
         } else {
            Snackbar.show({text: request.response, backgroundColor: '#7C0A02', actionTextColor: '#FFFFFF'});
         }
     };
     request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
     var params = "view_id=" + view_id;
     request.send(params);
}