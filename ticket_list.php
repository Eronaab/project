<?php 
  include 'config.php';

  if(isset($_GET["keyword"]) && $_GET["keyword"]) {
    $sql = $conn->prepare("SELECT * FROM tickets WHERE title = ?");
    $sql->bind_param("s", $_GET['keyword']);
    $sql->execute();
    $result = $sql->get_result();
  } else {
    $sql = "SELECT * FROM tickets"; 
    $result = $conn->query($sql);
  }

  $conn->close();

  include "components/header.php";
?>

<div class="container2">
  <h1>Ticket List</h1>
  <div id="ticketList">
    <?php echo (isset($_GET["error"]) ? "Couldn't find ticket with ID:" . $_GET["error"] : "")?>

    <form method="GET">
      <input type="text" name="keyword" value="<?php echo (isset($_GET["keyword"]) ? $_GET["keyword"]:"")?>" />
      <button type="submit" name="submit" class="btn btn-secondary">Search</button>
    </form>

    <table class="table table-hover">
      <thead>
        <tr> <br>
          <td>#</td> 
          <td>Title</td> 
          <td>Description</td>
          <td>Priority</td>
          <td>Actions</td>
        </tr>
      </thead>

      <tbody>
        <?php
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $row["id"];?></td>
                <td><?php echo $row["title"];?></td>
                <td><?php echo $row["description"];?></td>
                <td><?php echo $row["priority"];?></td>
                <td><a href="view_ticket.php?id=<?php echo $row["id"];?>">View</a></td>
              </tr>
            <?php }
          } else { ?>
          <tr>
            <td colspan="5">No data to display!</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include "components/footer.php"; ?>