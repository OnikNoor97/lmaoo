$(document).ready(function() 
{
  loadComments();
  loadSummerNote(".createComment");
});

$(".createComment").on('summernote.keydown', (we, e) =>
{
  if (e.shiftKey && e.keyCode == 13) saveComment(".createComment");
});

function loadSummerNote(summerNoteId)
{
  $(summerNoteId).summernote({
    placeholder: "Enter your comment here, Shift + Enter to save",
    followingToolbar: false,
    height: 125,
    toolbar: 
    [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough' ]],
      ['para', ['ul', 'ol']],
    ],
    popover: 
    {
      image: [],
      link: [],
      air: [],
    }
    });
    $('.note-statusbar').hide();
}

function commentValidation(summerNoteId)
{
  var newComment = $(summerNoteId).summernote('code');
  var newCommentStripped = newComment.replace(/<[^>]*>?/gm, "");

  if ($(summerNoteId).summernote("isEmpty") || newCommentStripped.trim().length == 0)
  {
    overHang("error", "Comment too small!");
    return false;
  }
  else if (newComment.length > 255)
  {
    overHang("error", "Comment too large!");
    return false
  }
  else
  {
    return true;
  }
}

function loadComments()
{
  var ticketId = new URL(window.location.href).searchParams.get("ticketId");

  loadCommentsFromServer(ticketId)
  .then(response =>
    {
      document.getElementById("commentList").innerHTML = ""; // Empties for edit/delete comments
      var json = response.data;
      for (i = 0; i < json.length; i++)
      {
        if (userId == json[i].userId || userLevel == 4)
        {
          document.getElementById("commentList").innerHTML +=
          `
          <div id="comments">
            <img class="CommentImages" src="../Images/paperclip.png"></img>
            <img class="CommentImages" src="../Images/delete.png" data-toggle="modal" data-target="#CommentModal" onclick="deletePrompt(${json[i].commentId})" role="button"></img>
            <img class="CommentImages" src="../Images/edit.png" onclick=editComment(${json[i].commentId}) role="button"></img>   
            <p>Comment by ${json[i].forename + " " + json[i].surname} at <label>${json[i].commentCreated}</label></p>
            <div class="comment${json[i].commentId}">${json[i].commentContent}</div>
          </div>
          `
        }
        else 
        {
          document.getElementById("commentList").innerHTML +=
          `
          <div id="comments">
            <img class="CommentImages" src="../Images/paperclip.png"></img> 
            <p>Comment by ${json[i].forename + " " + json[i].surname}</p>
            <div class="comment${json[i].commentId}">${json[i].commentContent}</div>
          </div>
          `
        }
      }
    })
}

function editComment(commentId)
{
  loadSummerNote('.comment'+commentId);

  $('.comment'+commentId).on('summernote.keydown', (we, e) => 
  {
      if(e.shiftKey && e.keyCode == 13) // Shift + Enter
      {
        if (commentValidation('.comment'+commentId))
        {
          saveComment('.comment'+commentId, commentId);
          $('.comment'+commentId).summernote('destroy');  
        }
      }
  });
}

function saveComment(summernoteId, commentId)
{
  var ticketId = new URL(window.location.href).searchParams.get("ticketId");

  var data = new FormData();
  data.append('commentContent', $(summernoteId).summernote('code'));
  data.append('ticketId', ticketId);
  data.append('userId', userId);
  commentId == null ? data.append('function', "createComment") : data.append('function', "updateComment");
  if (commentId != null) data.append("commentId", commentId);

  if (commentValidation(summernoteId))
  {
    axios.post("../Ticket/ticketController.php", data)
    .then(() =>
    {
      if (commentId == null) $('.createComment').summernote('code', "");
      commentId == null ? overHang("success", "New comment added successfully!") : overHang("success", "Comment successfully edited!"); 
      loadComments(); // Loads comments once you submit it
    })
  }
}

function deletePrompt(commentId)
{
  document.getElementById("Modal-head").innerHTML = "Delete Comment";
  document.getElementById("prompt").style.display = "block"
  document.getElementById("prompt").innerHTML = "Are you sure you want to delete this comment?";
	document.getElementById("Modal-footer").innerHTML = `
	<div class="modal-footer">
		<input class="btn btn-primary" type="submit" value="Delete Comment" onclick="deleteComment(${commentId})">
  </div>
	`;
}

function deleteComment(commentId)
{
    var data = new FormData();
    data.append('function', "deleteComment");
    data.append('commentId', commentId);

    axios.post("../Ticket/ticketController.php", data)
    .then(() =>
    {
      $('#CommentModal').modal('hide'); 
      overHang("success", "Comment deleted successfully!");
      loadComments();
    })
 }