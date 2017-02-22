<?php
	$con = mysqli_connect('localhost','shubhmsng','shubhmsng', 'id354464_questionnaire');
	
	$ans=mysqli_query($con, "select * from answer");
	
		while($ans1=mysqli_fetch_array($ans, MYSQLI_ASSOC))
		{
			$i=1;
			$ca=0;
			$wa=0;
			$que=mysqli_query($con, "select optcr from question");
			while($que2=mysqli_fetch_array($que, MYSQLI_ASSOC))
			{
				//echo "step ".$i." "."$que2[optcr]"." "."$ans1[$i]"." ";
				if(strcmp($que2['optcr'],$ans1[$i])==0)
				{
					//echo"correct ";
					$ca=$ca+1;
				}
				if(strcmp($que2['optcr'],$ans1[$i])!=0)
				{
					//echo"wrong ";
					$wa=$wa+1;
				}
				$i=$i+1;
				//echo "<br>";
			}
			
			//echo "<br>".$ans1['0']." ".$ca." ".$wa."<br>";
			$tot=$ca-$wa ; //for negative marking
			$sql1="UPDATE ranklist SET correct='$ca',wrong='$wa',total='$tot' WHERE rollno='$ans1[0]' ";
							$sql=mysqli_query($con, $sql1);
							  /*if($sql1)
							  echo "Rank Submited";
							  
								*/
		}
		// ranking calculation 
		//echo "<br> ranking calculation ";
		$que3=mysqli_query($con, "SELECT * FROM ranklist ORDER BY correct DESC");
		$j=0;
		$prev=-1;
		while($row4=mysqli_fetch_array($que3, MYSQLI_ASSOC))
		{
			if($prev!=$row4['correct'])
			$j=$j+1;
			$prev=$row4['correct'];
		//	echo $row4['rollno'];
			$que5=mysqli_query($con, "UPDATE ranklist SET rank=$j where rollno=$row4[rollno] ");
			
		}
?>