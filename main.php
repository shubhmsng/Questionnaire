<?php
session_start();
  if(!isset($_SESSION['user']))
    header("location: index.php?status=2");
$con = mysqli_connect('localhost','shubhmsng','shubhmsng','id354464_questionnaire') or die("Unable to connect to MySQL");
$result1=mysqli_query($con, "select * from question");

?>
<?php
if(isset($_POST['submit']))
{
error_reporting(E_ALL ^ E_DEPRECATED);

if (!$con)
  {
    die('Could not connect: ');
  }
  $option=$_POST['optionsRadios'];
  $ques="q"."$_GET[data]";

  
  $roll=$_SESSION['user'];
  //$roll=$_GET['roll'];
  
							
							$sql1="UPDATE answer SET $ques='$option' WHERE rollno='$roll' ";
							$sql=mysqli_query($con,$sql1);
							  
						  
				$rown=$_GET['data'];
				$rown2=$rown+1;
				$queryn="main.php?data="."$rown2";

				header("location:$queryn");

    
}
  include "connectdb.php";
  date_default_timezone_set("Asia/Kolkata");
  $rollno=$_SESSION['user'];
  $query="select user from feedback where user=$rollno";
  //echo $query;
  $result = mysqli_query($con,$query);
  $rows=mysqli_num_rows($result);
  //echo $rows;
  if ($rows == 0) {
      
      $query="insert into feedback(user,start) values($rollno,'finish')";
      $result = mysqli_query($con,$query);
    }
    if(!isset($_SESSION['start']))
        header("location: start.php"); 

    $query = "select start_time from timer where rollno=$rollno";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    if(! $row) {
       date_default_timezone_set("Asia/Kolkata");
      $p = date("Y-m-d H:i:s");
      $t = $p;     
      $start_time = $t;
      $t = strtotime($t);
      $t = $t + 30*(60);
      $end_time = date('Y-m-d H:i:s', $t);
      
      $query1 = "INSERT INTO timer VALUES ($rollno,'$start_time', '$end_time')";
      $result = mysqli_query($con, $query1) or die ("error");
      
      $query1 = "SELECT end_time FROM timer where rollno=$rollno";
      $result = mysqli_query($con, $query1) or die ("error");
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      
      $ts1 = new DateTime($row['end_time']);
      $ts2 = new DateTime($p);
      
      $diff = $ts2->diff($ts1);
      $_SESSION['time'] = $diff->i.":".$diff->s;

      
    }
    else {
      $query1 = "SELECT end_time FROM timer where rollno=$rollno";
      $result = mysqli_query($con, $query1) or die ("error");
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      
      $p = date("Y-m-d H:i:s");
      $ts1 = new DateTime($row['end_time']);
      $ts2 = new DateTime($p);
      //echo "<br>current time: ".$p;
      $diff = $ts2->diff($ts1);
      if(strtotime($row['end_time'])<strtotime($p))
      {
        $_SESSION['time'] = "00:00";
      }
      else
        $_SESSION['time'] = $diff->i.":".$diff->s;
    }
    
?>


<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/navbar/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="image/photo.jpg">

    <title>Questionnaire</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--link href="css/navbar.css" rel="stylesheet"-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--script src="js/ie-emulation-modes-warning.js"></script><style type="text/css"></style-->
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#myModal").on('show.bs.modal', function(event){
				var button = $(event.relatedTarget);  // Button that triggered the modal
				var titleData = button.data('title'); // Extract value from data-* attributes
				$(this).find('.modal-title').text(titleData);
			});

      

      var myVar = setInterval(myTimer ,1000);
      var data = "<?php echo $_SESSION['time']; ?>";
      var data = data.split(":");
      var p = data[0];
      var q = data[1];
      var minutes = parseInt(p);
      var seconds = parseInt(q);
      
      function myTimer() {
        
        
        if(seconds==0 && minutes!=0)
        {
          
          var data = minutes.toString()+":0"+seconds.toString();
          document.getElementById("timmer").innerHTML = "Time Left "+data
          
          minutes -= 1;
          seconds = 59;
          
        }
        else{
          if(seconds<10 && minutes>10)
          {
            var data = minutes.toString()+":0"+seconds.toString();
          }
          else if(seconds>10 && minutes<10){
                var data = "0"+minutes.toString()+":"+seconds.toString();
          }
          else if(seconds<10 && minutes < 10){
            var data = "0"+minutes.toString()+":0"+seconds.toString();
          }
          else if(seconds==10 && minutes < 10){
            var data = "0"+minutes.toString()+":"+seconds.toString();
          }
          else if(seconds<10 && minutes == 10){
            var data = minutes.toString()+":0"+seconds.toString();
          }
          else{
            var data = minutes.toString()+":"+seconds.toString();
          }

          document.getElementById("timmer").innerHTML = "Time Left "+data;
        }
        $("#timmer").show();
        if(seconds==0 && minutes==0)
        {
           
           var data = "0"+minutes.toString()+":0"+seconds.toString();
           document.getElementById("timmer").innerHTML = "Time Left "+data;
           alert("timeout");
           clearTimeout(myVar);
           window.location="final.php";
        }
        seconds--;
      } 
		});

  </script>
	



  <style type="text/css">
		.bs-example{
			margin: 20px;
		}
    #timmer{
      
      font-family: 'Trirong', sans-serif;
      font-size: 18px;
      border: 1px solid #abc;
      border-radius: 50px;
      padding: 10px;
      box-shadow:0px 5px 5px #888;
      background-color: white;
      color: #337ab7;
    }
    @media only screen and (max-width: 720px) {

      #timmer{
          border: 1px solid #abc;
          border-radius: 50px;
          padding-top: 8px;
          padding-bottom: 8px;
          padding-left: 3px;
          padding-right: 3px;
          font-family: 'Trirong', sans-serif;
          font-size: 12px;
        }
        #index li{
          width: 1%;
          padding-right: 10%;
        }
        #index li a{

        display: block;
        color: white;
        text-align: center;
        padding: 4px 6px;
        text-decoration: none;
        }
        
    }
    #index{
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      /*background-color: #4CAF50;  */
    }
    #index li{
      float: left;
      width: 5%;
      padding: 5px;
    }
    #index li a{
    border: 1px solid #e0e0e0;
    border-radius: 100%;
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    }
    #index li a:hover{
        color: black;
        background-color: #e0e0e0;
    }
	</style>

  
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home.php">Questionnaire</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

              <li><a href="home.php">Home <span class="glyphicon glyphicon-home"></a></li>
              <li ><a href="#" data-toggle="modal" data-target="#about"  data-title="About">About <span class="glyphicon glyphicon-info-icon"></span></a></li>

              <li><a href="#" data-toggle="modal" data-target="#myModal"  data-title="Contact Us">Contact <span class="glyphicon glyphicon-earphone"></span></a></li>
            </ul>
           
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="#">Questions <span class="glyphicon glyphicon-dashboard"><span class="sr-only">(current)</span></a></li>
              <li><a href="ranklist.php?id=1">Ranklist <span class="glyphicon glyphicon-list-alt"></span></a></li>

              <?php 
                if(isset($_SESSION['user'])){
              ?>
              <li><a href="user.php">User<span class="glyphicon glyphicon-user"></span></a></li>
              <li><a href="logout.php">Log Out&nbsp;<b><?php echo "(".$_SESSION['user'].")";?></b> <span class="glyphicon glyphicon-off"></span></a></li>
              <?php 
                }
                else{
              ?>
                <li><a href="index.php">Login <span class="glyphicon glyphicon-log-in"></span></a></li>
                <li><a href="registration.php">Sign up <span class="glyphicon glyphicon-user"></span></a></li>
              <?php
                }
              ?>

             
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
     
      <nav>


      
      <div align="center">
            <ul id="index">
          			<?php
            			$result1=mysqli_query($con,"select * from question");
            			
                  while($row=mysqli_fetch_array($result1, MYSQLI_ASSOC))
            			{
            				$query="main.php?data="."$row[id]";
            				 echo " <li class=\"active\"><a href=\"$query\">";
                     if($_GET['data']==$row['id'])
                        echo "<b>".$row['id']."</b>";
                      else
                        echo $row['id'];
                     echo "</a></li>";
            			}

          			?>
              
            </ul>
        </div>  
      </nav>
	  
			<?php
			$data=$_GET['data'];  
			$data1=$data+1;
			$result3=mysqli_query($con,"select * from answer WHERE rollno=$_SESSION[user]");
			$row4=mysqli_fetch_array($result3,MYSQLI_ASSOC);
			$value=$row4[$data];
			
			$result2=mysqli_query($con,"select * from question where id='$data'");
			while($row=mysqli_fetch_array($result2, MYSQLI_ASSOC))
			{
				$rown=$row['id'];
				$rown1=$rown-1;
				$rown2=$rown+1;
				$queryp="main.php?data="."$rown1";
				$queryn="main.php?data="."$rown2";
				
			echo "
    
      <!-- Main component for a primary marketing message or call to action -->
      <nav>
        <ul class=\"pager\" >
          <li class=\"previous\"><a href=\"$queryp\"><span aria-hidden=\"true\">&larr;</span> Previous</a></li>
          <span id='timmer' style='display:none'> </span>
          <li class=\"next\"><a href=\"$queryn\">Next <span aria-hidden=\"true\">&rarr;</span></a></li>
        </ul>
      </nav>
      <div class=\"jumbotron\">
	   
		  
        <h2>Question No.".$row['id']."</h2>
        <p>".$row['question']."</p>
		<form name=\"form1\" method=\"post\" action=\"\">
        <div class=\"radio\">
          <label>
            <input type=\"radio\" name=\"optionsRadios\"  id=\"optionsRadios2\" value=\"opt1\" "; if($value=="opt1")echo " checked"; echo ">
            ".$row['opt1']."
          </label>
        </div>
        <div class=\"radio\">
          <label>
            <input type=\"radio\" name=\"optionsRadios\" id=\"optionsRadios2\" value=\"opt2\" "; if($value=="opt2")echo " checked"; echo ">
            ".$row['opt2']."
          </label>
        </div>
        <div class=\"radio\">
          <label>
            <input type=\"radio\" name=\"optionsRadios\" id=\"optionsRadios2\" value=\"opt3\" "; if($value=="opt3")echo " checked"; echo ">
            ".$row['opt3']."
          </label>
        </div>
        <div class=\"radio\">
          <label>
            <input type=\"radio\" name=\"optionsRadios\" id=\"optionsRadios2\" value=\"opt4\" "; if($value=="opt1")echo " checked"; echo ">
            ".$row['opt4']."
          </label>
        </div>
        
      </div>
      <p>
	  
          <input type=\"submit\" class=\"submit btn btn-primary\"  name=\"submit\" value=\"submit\"></input><br/>  
        </p>
		</form>
			";
			}
		?>
    </span></a></li></ul></span></a></li></ul></div></div></nav>
    <div class="rows">
      <div class="col-lg-9"></div>
      <div class="col-lg-3">
        <a href="final.php" class="btn btn-success">Finish Test</a>
      </div>
    </div>
    
    </div> <!-- /container -->
<div id="about" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">About</h4>
                </div>
                <div class="modal-body">
                 <p style="color:#dd6f00; font-size:18px">Questionnaire is a CMS(Content Management System) which is developed by Btech(CSE) 3<sup>rd</sup> year students of IERT Allahabad. <br>
					Questionnaire provides you a platform where you can give or you can organize<br>MCQ based online test.<br>
					</p>  
				
                </div>
                
            </div>
        </div>
    </div>
	
		 <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Contact Us</h4>
                </div>
                <div class="modal-body">
					
					<p style="color:#dd6f00; font-size:18px">
						For any kind of information regarding Questionnaire you can contact us at
						questionnairecms@gmail.com
						<br><br>
						<span class="glyphicon glyphicon-earphone"></span> 
						+917783984676, +919984201321, +917054910780<br><br>
						<span class="glyphicon glyphicon-map-marker"> 
						 Institute of Engineering & Rural Technology<br>
						 &nbsp;&nbsp;26 Chaitham Lines<br>
						 &nbsp;&nbsp;Near Prayag Railway Station<br>
						 &nbsp;&nbsp;Allahabad 211002<br>
						
					</p>
				   
                </div>
                
            </div>
        </div>
    </div>
	
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <!--script src="js/bootstrap.min.js" ></script -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--script src="js/ie10-viewport-bug-workaround.js"--></script>
  

</body></html>