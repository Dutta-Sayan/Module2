<?php

/**
 * Class to handle the different routes.
 */
class Route
{
  /**
   * Handles the route for anonymous users.
   * 
   * @return
   *  Returns the anonymous users dashboard page.
   */
  public function anonymousDashboard()
  {
    require_once('anonymousDashboard.php');
  }

  /**
   * Handles the route for admin registration.
   * 
   * @return
   *  Returns the admin registration page.
   */
  public function register()
  {
    if (isset($_POST['submit'])) {
      require_once('Connection.php');
      // Object of Connection class.
      $connection = new Connection();
      // Contains the admin name.
      $name = $_POST['name'];
      // Validates the name.
      $pattern = "/^[a-zA-Z ]{1,25}$/";
      // Shows error if name is not valid.
      if (!preg_match($pattern, $name)) {
        require_once("error.php");
      }
      else {

        // For valid name, checks if the user exists in database.
        $res = $connection->checkUser($_POST['email']);
        if (!$res) {
          // If user not present in database, then inserts user.
          $connection->insertUser($_POST['name'], $_POST['password'], $_POST['email']);
          require_once('registrationSuccess.php');
        }
        else {
          // Page if user xists.
          require_once('userExists.php');
        }
      }

    }
    require_once('register.php');
  }

  /**
   * Handles the route for admin login.
   * 
   * @return
   *  Returns the admin login page.
   */
  public function login()
  {
    if (isset($_POST['submit'])) {
      require_once('Connection.php');
      $connection = new Connection();
      $res = $connection->checkUser($_POST['email']);
      if ($res) {
        // Starts session on successful login.
        session_start();
        require_once('adminDashboard.php');
      }
      // Login failed page.
      else {
        require_once('loginFailure.php');
      }
    }
    elseif (isset($_POST['playerSubmit'])) {
      require_once('adminDashboard.php');
    }
    else {
      require_once('login.php');
    }
  }

  /**
   * Renders the admin dashboard page.
   */
  public function adminDashboard()
  {
    require_once('adminDashboard.php');
  }

  /**
   * Function for logout.
   */
  public function logout()
  {
    // Destroys session and redirects to login page.
    session_destroy();
    require_once('login.php');
  }

  /**
   * Function to render a not found page.
   */
  public function pageNotFound()
  {
    require_once('pageNotFund.php');
  }
}