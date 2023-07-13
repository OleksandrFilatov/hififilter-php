<?php 
	session_start();
	require ("dbcon.php"); 
    if (!isset($_SESSION['frontenduser']))
    header("Location: index.php");
		if (isset($_POST['submit']) && isset($_SESSION['frontenduser']))
		{
			$comment = isset($_POST['comment']) ? $_POST['comment'] : "";
			if ($_POST['product_type'] == '1') {

				$sql = "INSERT INTO reqproduct (rq_user, rq_first_name, rq_last_name, rq_email, rq_telefon, rq_comment, rq_article_num, rq_date, rq_type, rq_state) 
				
				VALUES
				
				('".$_SESSION['frontenduser']['userid']."', 
				'".$_POST['first_name']."', 
				'".$_POST['last_name']."',
				'".$_POST['email_address']."', 
				'".$_POST['phone_num']."', 
				'".$comment."', 
				'".$_POST['art_num']."', 
				'".date('Y.m.d H:i:s')."', 1, 0)";
				
				//  echo $sql;
				
				mysqli_query($con, $sql);
			} else {
				$countfiles = count($_FILES['images']['name']);
				$allfilename = "";
				
				for($i=0;$i<$countfiles;$i++){
					$filename = $_FILES['images']['name'][$i];
					$allfilename .= $filename;
					if ($i < $countfiles - 1) $allfilename .= ", ";
					move_uploaded_file($_FILES['images']['tmp_name'][$i],'admin/upload/'.$filename);
				}

				$sql = "INSERT INTO reqproduct (rq_user, rq_first_name, rq_last_name, rq_email, rq_telefon, rq_comment, rq_images, rq_date, rq_type, rq_state) 
				
				VALUES
				
				('".$_SESSION['frontenduser']['userid']."', 
				'".$_POST['first_name']."', 
				'".$_POST['last_name']."',
				'".$_POST['email_address']."', 
				'".$_POST['phone_num']."', 
				'".$comment."',
				'".$allfilename."', 
				'".date('Y.m.d H:i:s')."', 2, 0)";
				
				//  echo $sql;
				
				mysqli_query($con, $sql);
			}
		}
    header("Location: req-thankyou.php");
?>