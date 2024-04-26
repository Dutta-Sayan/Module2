<?php

require_once('Connection.php');
$connection = new Connection();
// Contains all the player info.
$result = $connection->showPlayerInfo();
// Stores the man of the match record.
$manOfTheMatch = $connection->manOFTheMatch();

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
</head>
<body>
  <div class="container">
    <div class="player-info-dashboard">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Player Name</th>
              <th scope="col">Runs</th>
              <th scope="col">Balls Played</th>
              <th scope="col">Strike Rate</th>
            </tr>
          </thead>
          <!-- Displays each player info in table format. -->
          <?php foreach ($result as $row) {?>
            <tr>
              <td><?php echo $row['player_name']; ?></td>
              <td><?php echo $row['runs']; ?></td>
              <td><?php echo $row['balls_played']; ?></td>
              <td><?php echo $row['strike_rate']; ?></td>
            </tr>
          <?php }?>
        </table>
        <button class="manOfTheMatch btn btn-primary">Man Of The Match</button>
        <div class="man-of-the-match">
          <h4>Man of the match</h4>
          Name : 
          <!-- Displays the name of the Man of The Match player. -->
          <?php foreach ($manOfTheMatch as $row) {?>
            <span><?php echo $row['player_name']; ?></span>
          <?php break; }?>
        </div>
        
      </div>
  </div>
  <a href="/login" class="btn btn-primary float-end">Admin Login</a>       
  <script>
    $(document).ready(function(){
      $('.man-of-the-match').hide();
      $('.manOfTheMatch').click(function(){
        $('.man-of-the-match').toggle();
      });
    });
  </script>
</body>
</html>