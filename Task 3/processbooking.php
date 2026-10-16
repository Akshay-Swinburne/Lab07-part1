<!DOCTYPE html>
<html lang="en">
<head>
	<title>Booking Confirmation</title>
	<meta charset="utf-8">
	<meta name="description" content="Rohirrim Booking Form" >
	<meta name="keywords"    content="MiddleEarth, Tours, Rohan" >
	<meta name="author"      content="Grima Wormtongue" />
    <!-- Place the general style sheet before specific CSS so the specific overides the general formatting-->
</head>

<body>

<header><h1>Rohirrim Tour Booking Confirmation</h1></header>

	<?php
        function sanitise_input ($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }

    if(isset($_POST["firstname"])) {
        $err_msg="";
        $first_name = $_POST["firstname"];
        $last_name = $_POST["lastname"];
        $age = $_POST["age"];
		$species_map = [
    					'M' => 'Human',
   						'D' => 'Dwarf',
    					'E' => 'Elf',
    					'H' => 'Hobbit'
						];
		$tour_names = [
    					'accom' => 'Accommodation',
    					'4day'  => '4 Day Tour',
    					'10day' => '10 Day Tour'
					];
		$preferences = $_POST["food"];
		$bookday = $_POST["bookday"];
		$partysize = $_POST["partysize"];


	if (trim($first_name)=="")
            $err_msg .= "<p>Please enter first name. </p>";
        else {
            $first_name=sanitise_input($first_name);
            if(!preg_match("/^[a-zA-Z]{2,20}$/", $first_name)) {
                $err_msg .= "<p>Only letters are allowed in first name. </p>";
            }
        }

    if (trim($last_name)=="")
        $err_msg .= "<p>Please enter last name. </p>";
    else {
        $last_name=sanitise_input($last_name);
        if(!preg_match("/^[a-zA-Z]{2,20}$/", $last_name)) {
            $err_msg .= "<p>Only letters are allowed in last name. </p>";
        }
    }

	if (trim($age)=="")
        $err_msg .= "<p>Please enter age. </p>";
    else {
        $age=sanitise_input($age);
        if(!preg_match('/^([0-9]*)$/', $age)) {
            $err_msg .= "<p>Only numbers are allowed in age. </p>";
        }
    }

	$species = $_POST["species"] ?? "M";
	$species_label = $species_map[$species] ?? "Unknown";
	
	$oneTicked = false;
	foreach (array_keys($tour_names) as $checkbox) {
    	if (!empty($_POST[$checkbox])) { $oneTicked = true; break; }
	}
	if (!$oneTicked) {
    	$err_msg .= "<p>Please select at least one checkbox.</p>";
	}

	$selected = [];
	foreach ($tour_names as $key => $label) {
    	if (!empty($_POST[$key])) {
        	$selected[] = $label;
    	}
	}

	$last = array_pop($selected);
	if ($selected) {
    	$tour_list = implode(', ', $selected) . ' and ' . $last;
	} else {
    	$tour_list = $last;
	}

	if (isset($_POST["bookday"]) && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $_POST["bookday"], $m)) {
    $month = (int) $m[1];
    $day   = (int) $m[2];
    $year  = (int) $m[3];

    if (checkdate($day, $month, $year)) {
        $bookday = str_pad($day, 2, '0', STR_PAD_LEFT) . '/' . str_pad($month, 2, '0', STR_PAD_LEFT) . '/' . $year;
    	} else {
        	$err_msg .= "<p>Only real calendar dates allowed. </p>"; 
    	}
	} else {
    	$err_msg .= "<p>Fill in the date and ensure the format is correct. </p>";
	}

	if (trim($partysize)=="")
        $err_msg .= "<p>Please enter partysize. </p>";
    else {
        $partysize=sanitise_input($partysize);
        if(!preg_match('/^([0-9]*)$/', $partysize)) {
            $err_msg .= "<p>Only numbers are allowed in partysize. </p>";
        }
    }

     if ($err_msg!="")
            echo $err_msg;
        else
            echo "<p>Welcome $first_name $last_name !<br>
		             You are now booked on the $tour_list<br>
					 Species: $species_label<br>
					 Age: $age<br>
					 Meal Preference: $preferences<br>
					 Number of travellers: $partysize</p>";
	}

    ?>
</body>
</html>