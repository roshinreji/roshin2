<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) 
{
    require "../config.php";
    require "../common.php";
		$fname ="";
		$lname ="";
		$email ="";
		$age ="";
		$loc ="";
	
		$fname_e ="";
		$lname_e ="";
		$email_e ="";
		$age_e ="";
		$loc_e ="";
	
	
		if (empty($_POST["firstname"])) 
		{
			$fname_e="First name is required";		
		}
		else 
		{
			$fname = $_POST["firstname"];
		}
		if (empty($_POST["lastname"])) 
		{
			?> <script> alert("Last Name is required"); </script> <?php
		}
		else 
		{
			$lname = $_POST["lastname"];
		}
		if (empty($_POST["email"])) 
		{
			?> <script> alert("email is required"); </script> <?php
		}
		else 
		{
			$email = $_POST["email"];
			if (!preg_match("/([w-]+@[w-]+.[w-]+)/",$email)) 
			{
				$email_e = "Invalid email format";
			}
		}
		if (empty($_POST["age"])) 
		{
			?> <script> alert("age is required"); </script> <?php
			
		}
		else 
		{
			$age =$_POST["age"];
		}
		if (empty($_POST["location"])) 
		{
			?> <script> alert("location is required"); </script> <?php
		}
		else 
		{
			$loc = $_POST["location"];
		}
	
	

	if(($fname!="") and ($lname!="") and ($email!="") and ($age!="") and ($loc!="") )
	{

    try  
	{
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) 
	{
        echo $sql . "<br>" . $error->getMessage();
    }
	
	
	}
}
?>

<?php require "templates/header.php"; ?>	
<script>
  function check()
  {
	  var fname=document.forms["form"]["firstname"].value;
	  var lname=document.forms["form"]["lastname"].value;
	  var mail=document.forms["form"]["email"].value;
	  var ag=document.forms["form"]["age"].value;
	  var loc=document.forms["form"]["location"].value;
	  
	  if(fname=="")
	  {
		  alert("please enter first name");
		  document.forms["form"]["firstname"].focus();
		  return false;
	  }
	 else if(lname=="")
	  {
		  alert("please enter last name");
		  document.forms["form"]["lastname"].focus();
		  return false;
	  }
	  else if(mail=="")
	  {
		  alert("please enter email");
		  document.forms["form"]["email"].focus();
		  return false;
	  }
	   else if(ag=="")
	  {
		  alert("please enter age");
		  document.forms["form"]["age"].focus();
		  return false;
	  }
	  else if(loc=="")
	  {
		  alert("please enter location");
		  document.forms["form"]["location"].focus();
		  return false;
	  }
	  
	  
  }
</script>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<form name="form" onsubmit="return check()" method="post">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
