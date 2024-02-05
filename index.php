<?php 
  include 'config.php';

  $errors = "";
  if(isset($_POST["submitTicket"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];

    if(!$_POST["title"] || !$_POST["description"] || !$_POST["priority"]) {
      $errors = "Please fill out all the required fields!";
    } else {
      $sql = "INSERT INTO tickets (title, description, priority) VALUES ('$title', '$description', '$priority')";

      if ($conn->query($sql) === TRUE) {
        header("Location: view_ticket.php?id=" . $conn->insert_id);
      } else {
        $errors = "Couldn't create new ticket!";
      }
      $conn->close();
    }
  }

  include "components/header.php";
?>

<form id="ticketForm" action="" method="post">
  <?php echo $errors;?>
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" required>

  <label for="description">Description:</label>
  <textarea id="description" name="description" required></textarea>

  <label for="priority">Priority:</label>
  <select id="priority" name="priority" required>
    <option value="Low">Low</option>
    <option value="Medium">Medium</option>
    <option value="High">High</option>
  </select>

  <button name="submitTicket" class="btn btn-secondary" type="submit">Submit Ticket</button>
</form>

<?php include "components/footer.php"; ?>