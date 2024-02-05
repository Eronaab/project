<?php
    include 'config.php';
    if(!isset($_GET['id']) || !$_GET['id'] || !is_numeric($_GET['id'])) {
        header("Location: ticket_list.php?error=" . $_GET['id']);   
    }

    $error = "";
    if(isset($_POST["update"])) {
        $sql = $conn->prepare("UPDATE tickets SET priority = ? WHERE id = ?");
        $sql->bind_param("si", $_POST["priority"], $_GET['id']);
        if(!$sql->execute()){
            $error = "Couln't update priority level.";
        } else $error = "Ticket priority updated successfully.";
    }

    $sql = $conn->prepare("SELECT title, description, priority FROM tickets WHERE id = ?");
    $sql->bind_param("i", $_GET['id']);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows <= 0) {
        header("Location: ticket_list.php?error=" . $_GET['id']);
    }
    $row = $result->fetch_assoc();
    $conn->close();
    
    include "components/header.php";
?>

<div class="container3">
    <h1>Ticket List</h1>
    <div id="ticketList">
        <?php echo $error;?>
        <form method="POST">
            <div><strong>Title:</strong><?php echo $row["title"]?></div>
            <div><strong>Description:</strong><?php echo $row["description"]?></div>
            <div>
                <strong>Priority:</strong>
                <select id="priority" name="priority" required>
                    <option value="Low" <?php echo $row["priority"]==="Low"?"selected":""?>>Low</option>
                    <option value="Medium" <?php echo $row["priority"]==="Medium"?"selected":""?>>Medium</option>
                    <option value="High" <?php echo $row["priority"]==="High"?"selected":""?>>High</option>
                </select>
                <button name="update" type="submit" class="btn btn-secondary">Update</button>
            </div>
        </form>
    </div>
</div>

<?php include "components/footer.php"; ?>