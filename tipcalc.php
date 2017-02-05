<?php 
// if(isset($_POST['submit'])){
// 	echo $_POST['answer'] * $_POST['billsub'];
// }
//$error_css = "";
// echo "css".$error_css;
?>
<html>  
<head>
	<title>My Tip Calcultor </title>
</head>
<body>
<h1> TIP CALCULATOR </h1>
 <form method ="post"> 
 <p style="<?php echo $error_css; ?>" > Bill Subtotal : $ <input  name="billsub" value="<?php echo isset($_POST['billsub']) ? $_POST['billsub'] : '0' ;?>" /> </p>

 <p> Tip Percentage : </p>

 <?php
  for ($i = 1; $i <= 3; $i++) {
  	 $j = (10+5*($i-1));
  	// if($i == 2){
  	 $val = ($j)/100;
  		echo '<input type="radio" name="answer" value="'. $val .'" '.((!isset($_POST['answer']) || isset($_POST['answer']) && $_POST[ 'answer'] == $val) ? 'checked = "checked"' :'').'>%';
  	// }else
  	// 	echo '<input type="radio" name="answer" value="'. ($j)/100 .'" >%';
  	echo $j;

}
 ?>
<br>
<br>
<input type="submit" name ="submit" value="Submit">
 </form>

 <?php 
	if(isset($_POST['submit'])){
		$answer =  $_POST['answer'];
		$value =  $_POST['billsub'];
		$tip  = $answer * $value ;
		$total = $tip + $value ;
		//echo $total;

		if(trim($value) == true){	
			if(is_numeric($value) && $value > 0 && $value == round($value, 0)){
				echo '<div style = "border: 3px solid blue" >'; 
				echo '<p style="color:blue"> Tip : '. $tip .'</p>';
				echo '<p style="color:blue"> Total : '. $total . '</p>';
				echo '</div>';
			}else {
				$error_css='background-color:red';
				echo '<p style="color:red">please enter a valid postive number field </p>';
			}
		}else {
				$error_css='background-color:red';
			echo '<p style="color:red">please enter a valid subtotal</p>';
		}
		
	}	
	
 //     $tip =  $_POST['answer'] * $_POST['billsub'];
 //  	$total  = $tip + $_POST['billsub'];
 //  	echo $tip;
?>

 <div style="display: none;">

 </div>
</body>
</html>


