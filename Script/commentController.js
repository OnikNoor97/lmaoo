$(document).ready(function() 
{
  loadComments();

  $('.createComment').summernote
  ({
      height: 150,
      toolbar: 
      [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough' ]],
        ['para', ['ul', 'ol',]],
      ]
  });

  $('.editComment').summernote
  ({
      height: 150,
      toolbar: 
      [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough' ]],
        ['para', ['ul', 'ol',]],
      ]
  });
});

function loadComments()
{
  // variable userId is available for User Id logged in
  // variable ticketId is available for Ticket Id
  var data = new FormData();
  data.append('function', "loadComments");
  data.append('ticketId', ticketId);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'ticketController.php', true);
  xhr.onreadystatechange = function() 
  {
    if (this.readyState == 4 && this.status == 200)
      {
        var ticketJSON = JSON.parse(this.responseText);
                document.getElementById("commentList").innerHTML = 
                `
                ${ticketJSON.map(function(comment)
                    {
                        return `
                        <div id="comments">
                            <img class="CommentImages" src="../Images/paperclip.png"></img>
                            <img class="CommentImages" value=${comment.commentId} src="../Images/delete.png" data-toggle="modal" data-target="#CommentModal" onclick="deleteComment()" role="button"></img>
                            <img class="CommentImages" value=${comment.commentId} src="../Images/edit.png" data-toggle="modal" data-target="#CommentModal" onclick="editComment()" role="button"></img>
                            <p>Comment by ${comment.forename + " " + comment.surname}</p>
                            <p>${comment.commentContent}</p>
                        </div>
                        `;
                    }).join('')}
                `;
      }
      
  }
  xhr.send(data);
}

function saveComment()
{
  var commentContent = $('.createComment').summernote('code');
  if ($('.createComment').summernote("isEmpty"))
  {
		document.getElementById("notenoughchars").removeAttribute("hidden");
		document.getElementById("manychars").setAttribute("hidden");
		
  }		
  else if (commentContent.length > 255)
  {
		document.getElementById("manychars").removeAttribute("hidden");
		document.getElementById("notenoughchars").setAttribute("hidden");
  }
  else 
  {
    // variable userId is available for User Id logged in
    // variable ticketId is available for Ticket Id

    var data = new FormData();
    data.append('function', "createComment");
    data.append('commentContent', commentContent);
    data.append('ticketId', ticketId);
    data.append('userId', userId);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ticketController.php', true);
    xhr.onreadystatechange = function() 
    {
      if (this.readyState == 4 && this.status == 200)
        {
          console.log(this.responseText);
          $('.createComment').summernote('code', ""); // Empties the Comments once it is submitted
          loadComments(); // Loads comments once you submit it
        }
    }
    xhr.send(data);
  }
}


function editComment()
{
  document.getElementById("Modal-head").innerHTML = "Edit Comment";
  document.getElementById("prompt").style.display = "none"
  document.getElementById("summernoteDiv").style.display = "block"
	document.getElementById("Modal-footer").innerHTML = 
	`
	<div class="modal-footer">
		<input class="btn btn-primary" type="submit" value="Update Changes">
    </div>
	`;
}

function deleteComment()
{
  document.getElementById("Modal-head").innerHTML = "Delete Comment";
  document.getElementById("summernoteDiv").style.display = "none"
  document.getElementById("prompt").style.display = "block"
  document.getElementById("prompt").innerHTML = "Are you sure you want to delete this comment?";
	document.getElementById("Modal-footer").innerHTML = `
	<div class="modal-footer">
		<input class="btn btn-primary" type="submit" value="Delete Comment">
    </div>
	`;
}