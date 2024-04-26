<?php

require_once realpath(__DIR__ . "/vendor/autoload.php");


use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Class for database connections and manipulating database.
 */
class Connection
{

  /**
   * Stores the connection PDO.
   *
   * @var object
   */
  public $conn;

  /**
   * Creates the database connection.
   */
  public function __construct()
  {
    // Stores the servername from .env file.
    $servername = $_ENV['SERVERNAME'];
    // Stores the username from .env file.
    $username = $_ENV['USERNAME'];
    // Stores the password from .env file.
    $password = $_ENV['PASSWORD'];
    // Stores the dataabse name from .env file.
    $db = $_ENV['DATABASE'];

    try {
      // Making the database connection.
      $this->conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  /**
   * Checks if the user exists in database.
   *
   * @param string $email
   *  Contains the email to be checked for.
   *
   * @return array
   *  Returns the array of the row containing the email.
   */
  public function checkUser(string $email): array {
    $sql = "SELECT * from Admin where email='$email';";
    // Preparing the query for execution.
    $stmt = $this->conn->prepare($sql);
    // Executing the query.
    $stmt->execute();
    // Converting and storing the result as array.
    $result = $stmt->fetchAll();
    return $result;
  }

  /**
   * Inserting a new user in database.
   * 
   * @param string $username
   *  Contains the user name.
   * 
   * @param string $password
   *  Contains the password.
   * 
   * @param string $email
   *  Contains the email.
   */
  public function insertUser(string $username, string $password, string $email)
  {
    // Storing the password as a hash value in the database.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT into Admin(name, email, password) values ('$username', '$email', '$password');";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
  }

  /**
   * Returns all the player details.
   * 
   * @return array
   *  Returns the array containing player records.
   */
  public function showPlayerInfo() : array
  {
    $sql = "SELECT * from Players;";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  
  /**
   * Stores the player info in the database.
   *
   * @param string $playername
   *  Contains the name of player.
   *
   * @param int $runs
   *  Contains the rusn scored.
   *
   * @param int $balls
   *  Contains the balls played.
   * 
   * @return bool
   *  Returns 0 if player count exceeds 11 else 1.
   */
  public function insertPlayer(string $playername, int $runs, int $balls) : bool
  {
    $sql = "SELECT * from Players;";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $count = ($stmt->fetchAll());
    // Checks if player count reached 11 or not.
    if ($count == 11) {
      return 0;
    }
    // Stores the strike rate.
    $strikeRate = ($runs/$balls)*100;
    // Query to insert player info.
    $sql = "INSERT into Players(player_name, runs, balls_played, strike_rate) values ('$playername', '$runs', '$balls', '$strikeRate');";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return 1;
  }

  /**
   * Function to get the player with highest strike rate.
   *
   * @return array
   *  Returns the array containing player info with highest strike rate.
   */
  public function manOFTheMatch() : array
  {
    $sql = "SELECT * from Players order by strike_rate DESC;";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

}