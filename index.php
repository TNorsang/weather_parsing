<!DOCTYPE html>
<html>
<head>
	<title>Weather Conditions</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>

    </style>
</head>
<body>
	<div class="container">
		<?php
        session_start();
        $ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_ip'] = $ip;
		// Connect to the database
		$servername = "localhost";
		$username = "root";
		$password = "weather";
		$dbname = "main";

		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}

		// Check if a state is selected
		$state = isset($_GET['state']) ? $_GET['state'] : '';

		// Get the data from the database based on the selected state
		if ($state) {
			$sql = "SELECT * FROM weather WHERE state='$state'";
		} else {
			$sql = "SELECT * FROM weather WHERE state='NY'";
		}
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			echo "<div class='card text-center bg-light'>";
			echo "<h1 class='mt-3 text-primary'> Current Conditions </h1>";
			echo "<h3>" . $row["state"] . ",  " . $row["city"] . "</h3>";
            echo "<h4>" . $row["temperature"] . "</h4>";
            if ($row["hazard"] > 0){
                echo "<h3 class='mt-3 mb-3 text-light bg-danger'> Hazardous Weather Alert! </h3>";
            } 
            echo "<p class='small text-primary'> Your IP is stored to save your state! Only you can see this: " . $ip .  "</p>";
			echo "</div>";
		} else {
			echo "0 results";
		}
        
        

		// Display buttons for each state
		echo "<div class='btn-group d-flex justify-content-center'>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=NY\"'>NY</button>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=CA\"'>CA</button>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=IL\"'>IL</button>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=TX\"'>TX</button>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=AZ\"'>AZ</button>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=PA\"'>PA</button>";
		echo "<button type='button' class='btn btn-primary' onclick='location.href=\"?state=FL\"'>FL</button>";
		echo "</div>";


        echo '<h2 class="text-center mt-5 mb-5 text-primary">Extended Forecaset</h2>';
        mysqli_data_seek($result, 2);
		if (mysqli_num_rows($result) > 0) {
            // Fetch the first row and output the first card
            $row1 = mysqli_fetch_assoc($result);
            echo '<div class="row ">';
            echo '<div class="col-md-2">';
            echo '<div class="card text-center bg-light">';
            echo '<div class="card ">';
            echo '<h5>' . $row1["date"] . " " . $row1["day"] . '</h5>';
            echo '<h4 class="small">' . $row1["short_description"] . '</h4>';
            echo '<h4 class="font-weight-bold">' . $row1["temperature"] . '</h4>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            if (mysqli_num_rows($result) > 1) {
              $row2 = mysqli_fetch_assoc($result);
              echo '<div class="col-md-2">';
              echo '<div class="card text-center bg-light">';
              echo '<div class="card h-100">';
              echo '<h5>' . $row2["date"] . " " . $row2["day"] .  '</h5>';
              echo '<h4 class="small">' . $row2["short_description"] . '</h4>';
              echo '<h4 class="font-weight-bold">' . $row2["temperature"] . '</h4>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
            if (mysqli_num_rows($result) > 2) {
                $row3 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row3["date"] . " " . $row3["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row3["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row3["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
              if (mysqli_num_rows($result) > 3) {
                $row4 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row4["date"] . " " . $row4["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row4["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row4["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }if (mysqli_num_rows($result) > 4) {
                $row5 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row5["date"] . " " . $row5["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row5["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row5["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }if (mysqli_num_rows($result) > 5) {
                $row6 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row6["date"] . " " . $row6["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row6["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row6["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }if (mysqli_num_rows($result) > 6) {
                $row7 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row7["date"] . " " . $row7["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row7["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row7["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }if (mysqli_num_rows($result) > 7) {
                $row8 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row8["date"] . " " . $row8["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row8["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row8["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }if (mysqli_num_rows($result) > 8) {
                $row9 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-2">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card h-100">';
                echo '<h5>' . $row9["date"] . " " . $row9["day"] .  '</h5>';
                echo '<h4 class ="small">' . $row9["short_description"] . '</h4>';
                echo '<h4 class="font-weight-bold">' . $row9["temperature"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
            echo '</div>';
            
          } else {
            echo '0 results';
          }

          echo '<h2 class="text-center mt-5 mb-5 text-primary">Detailed Forecaset </h2>';
          
          mysqli_data_seek($result, 2);
          if (mysqli_num_rows($result) > 0) {
              // Fetch the first row and output the first card
              $row1 = mysqli_fetch_assoc($result);
              echo '<div class="row ">';
              echo '<div class="col-md-12">';
              echo '<div class="card text-center bg-light">';
              echo '<div class="card">';
              echo '<h5 class="mt-3 mb-3">' . $row1["date"] . " " . $row1["day"] . '</h5>';
              echo '<h4 class="small mb-3">' . $row1["long_description"] . '</h4>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              
              if (mysqli_num_rows($result) > 1) {
                $row2 = mysqli_fetch_assoc($result);
                echo '<div class="col-md-12">';
                echo '<div class="card text-center bg-light">';
                echo '<div class="card">';
                echo '<h5 class="mt-3 mb-3">' . $row2["date"] . " " . $row2["day"] . '</h5>';
                echo '<h4 class="small mb-3">' . $row2["long_description"] . '</h4>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
              if (mysqli_num_rows($result) > 2) {
                  $row3 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row3["date"] . " " . $row3["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row3["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }
                if (mysqli_num_rows($result) > 3) {
                  $row4 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row4["date"] . " " . $row4["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row4["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }if (mysqli_num_rows($result) > 4) {
                  $row5 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row5["date"] . " " . $row5["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row5["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }if (mysqli_num_rows($result) > 5) {
                  $row6 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row6["date"] . " " . $row6["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row6["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }if (mysqli_num_rows($result) > 6) {
                  $row7 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row7["date"] . " " . $row7["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row7["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }if (mysqli_num_rows($result) > 7) {
                  $row8 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row8["date"] . " " . $row8["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row8["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }if (mysqli_num_rows($result) > 8) {
                  $row9 = mysqli_fetch_assoc($result);
                  echo '<div class="col-md-12">';
                  echo '<div class="card text-center bg-light">';
                  echo '<div class="card">';
                  echo '<h5 class="mt-3 mb-3">' . $row9["date"] . " " . $row9["day"] . '</h5>';
                  echo '<h4 class="small mb-3">' . $row9["long_description"] . '</h4>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                }if (mysqli_num_rows($result) > 9) {
                    $row10 = mysqli_fetch_assoc($result);
                    echo '<div class="col-md-12">';
                    echo '<div class="card text-center bg-light">';
                    echo '<div class="card">';
                    echo '<h5 class="mt-3 mb-3">' . $row10["date"] . " " . $row10["day"] . '</h5>';
                    echo '<h4 class="small mb-3">' . $row10["long_description"] . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }if (mysqli_num_rows($result) > 10) {
                    $row11 = mysqli_fetch_assoc($result);
                    echo '<div class="col-md-12">';
                    echo '<div class="card text-center bg-light">';
                    echo '<div class="card">';
                    echo '<h5 class="mt-3 mb-3">' . $row11["date"] . " " . $row11["day"] . '</h5>';
                    echo '<h4 class="small mb-3">' . $row11["long_description"] . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }if (mysqli_num_rows($result) > 11) {
                    $row12 = mysqli_fetch_assoc($result);
                    echo '<div class="col-md-12">';
                    echo '<div class="card text-center bg-light">';
                    echo '<div class="card">';
                    echo '<h5 class="mt-3 mb-3">' . $row12["date"] . " " . $row12["day"] . '</h5>';
                    echo '<h4 class="small mb-3">' . $row12["long_description"] . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }if (mysqli_num_rows($result) > 12) {
                    $row13 = mysqli_fetch_assoc($result);
                    echo '<div class="col-md-12">';
                    echo '<div class="card text-center bg-light">';
                    echo '<div class="card">';
                    echo '<h5 class="mt-3 mb-3">' . $row13["date"] . " " . $row13["day"] . '</h5>';
                    echo '<h4 class="small mb-3">' . $row13["long_description"] . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }if (mysqli_num_rows($result) > 13) {
                    $row14 = mysqli_fetch_assoc($result);
                    echo '<div class="col-md-12">';
                    echo '<div class="card text-center bg-light">';
                    echo '<div class="card">';
                    echo '<h5 class="mt-3 mb-3">' . $row14["date"] . " " . $row14["day"] . '</h5>';
                    echo '<h4 class="small mb-3">' . $row14["long_description"] . '</h4>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  }
              
            } else {
              echo '0 results';
            }

        


    

		mysqli_close($conn);
		?>
	</div>
</body>
</html>