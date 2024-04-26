<?php

require_once('Connection.php');
$connection = new Connection();
// Contains the player details.
$result = $connection->showPlayerInfo();

if (isset($_POST['playerSubmit'])) {
  // inserts a new player.
  $res = $connection->insertPlayer($_POST['playerName'], $_POST['runs'], $_POST['balls']);
  if ($res == 0) {
    $msg = "No more player can be inserted";
  }
  else {
    header('location: adminDashboard.php');
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
      <?php include './style.css'; ?>
  </style>
</head>
<body>
  <div class="container">
    <a href="/logout"class="btn btn-primary float-end">Logout</a>
    <div class="player-info-dashboard">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Player Name</th>
            <th scope="col">Runs</th>
            <th scope="col">Balls Played</th>
            <th scope="col">Strike Rate</th>
            <th scope="col">Operations</th>
          </tr>
        </thead>
        <!-- Displays each player info in table format. -->
        <?php foreach ($result as $row) {?>
          <tr>
            <td><?php echo $row['player_name']; ?></td>
            <td><?php echo $row['runs']; ?></td>
            <td><?php echo $row['balls_played']; ?></td>
            <td><?php echo $row['strike_rate']; ?></td>
            <td><a href="/edit">Edit</a> / <a href="/delete">Delete</a></td>
          </tr>
        <?php }?>
      </table>
    </div>
    <div class="add-player">
      <h3>Add player</h3>
      <form action="" method="post">
        <div class="player-name">
          <label for="playerName" class="form-label">Player Name</label>
          <input type="text" name="playerName" placeholder="Enter player name" class="form-control" required>
        </div>
        <div class="player-runs">
          <label for="runs" class="form-label">Runs Scored</label>
          <input type="number" name="runs" placeholder="Enter runs scored" class="form-control" min="0" required>
        </div>
        <div class="balls-played">
          <label for="balls" class="form-label">Balls Played</label>
          <input type="number" name="balls" placeholder="Enter balls played" class="form-control" min="0" required>
        </div>
        <input type="submit" name="playerSubmit" class="btn btn-primary" id="player-submit" value="Submit">
      </form>
    </div>
    <div class="msg"><?php echo $msg?></div>
  </div>
</body>
</html>