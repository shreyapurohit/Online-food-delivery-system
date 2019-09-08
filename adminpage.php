<?php
	session_start();
	$email = $_SESSION['email'];
    include_once 'includes/dbh.inc.php';
	$count = "SELECT * from admin where email = '$email'";
	$result = mysqli_query($conn,$count);
    $x = mysqli_num_rows($result);
    if($x!=1){
        header("Location: adminlogin.php?login=false");
        exit();
    }
    $msg="";
	@$msg = $_GET['Upload'];
?>
<html>
<head>
	<title>Grofers</title>
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<style type="text/css">
	*{
		margin:0px;
		padding: 0px;
	}
	.heading{
		background-color: #eed;
		height: 60px;
	}
	.heading span {
		color : black;
		font-size: 30px;
		font-style: italic;
		font-family: 'Pacifico';
		margin-left: 50px;
		margin-top: 25px;
	}
	.heading img{
		margin-right:10px;
		margin-bottom: 10px;
	}
	.menu {
		float: right;
		margin-right: 20px;
		margin-top: 10px;
	}
	.search{
		margin-left: 350px;
	}

	.card{
		width: 310px;
		float: left;
		margin: 1%;
		margin-top: 1%;
	}
    .upload{
		margin: auto;
		margin-top: 80px;
		margin-right: 150px;
		float: right;
		width: 400px;
	}
	.upload input{
		margin-top: 10px;
		margin-bottom: 10px;
	}
    .msg{
		color: green;
	}
</style>
<script type="text/javascript">

		$(document).ready(function(){
            
            $("#logout").click(function(){
			    window.location.href="includes/logout.php";
		    });
	});
</script>
<body>
	<nav class="navbar navbar-expand-sm bg-light navbar-light">
		<ul class="navbar-nav">
		<li class="nav-item">
		      <a class="nav-link" href="adminpage.php"><b>Add Product</b></a>
		    </li>
				<li class="nav-item">
		      <a class="nav-link" href="productlist.php">Product List</a>
		    </li>
            <li class="nav-item">
		      <a class="nav-link" href="userlist.php">User List</a>
		    </li>
			<li class="nav-item">
		      <a class="nav-link" id="logout" style="cursor:pointer">Logout</a>
		    </li>
		</ul>	
	</nav>

	
	<?php
			$sql = "SELECT * from admin where email = '$email'";
            $result = mysqli_query($conn,$sql); 
            $row = mysqli_fetch_array($result)?>
            <span><h4 style="margin-right:50px;text-align:right">Admin : <?php echo $row['pname'];?></h4></span>
			
            <image src="plate.jpg" style="float:left;width:600px;height:400px;margin-left:150px;margin-top:40px; border-radius: 40px;"/>
            <div class="upload">
            <?php  if($msg!=""){
					echo "<span class='msg'>Product Uploaded</span>";
			}?>
		<form method="post" action="includes/upload.inc.php" enctype="multipart/form-data">
			<div class="input-group"> 
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="image">
                <label class="custom-file-label" for="inputGroupFile01">Image</label>
              </div>
            </div>
			<input type="text" name="proname" class="form-control" placeholder="Name">
            <input type="text" name="price" class="form-control" placeholder="Price">
			<button name="upload" class="btn btn-success">Upload</button>
		</form>
	</div>

</body>
</html>