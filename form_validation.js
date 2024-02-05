document.getElementById('ticketForm').addEventListener('submit', function(event) {

  var title = document.getElementById('title').value;
  if (title.trim() === '') {
    alert('Title is required!');
    event.preventDefault(); 
  }
});
  