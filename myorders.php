<?php
    session_start();
    $email = $_SESSION['email'];
    include_once 'includes/dbh.inc.php';
    $count = "SELECT * from users where email = '$email'";
    $result = mysqli_query($conn,$count);
    $x = mysqli_num_rows($result);
    if($x!=1){
        header("Location: index.php?login=false");
        exit();
    }
    $row = mysqli_fetch_array($result);
    $star = $row['star'];
    $pname = $row['pname'];
    $uid = $row['uid'];
    $finalprice = 0;
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
        float: left;
        margin: 1%;
        margin-top: 1%;
    }
</style>
<script type="text/javascript">

        $(document).ready(function(){
            
            $("#logout").click(function(){
                window.location.href="includes/logout.php";
            });


            $(".deleteitem").click(function(){
                var oid = $(this).attr('oid');
                var price = $(this).attr('price');
                var pageRef = 0;
                $.ajax({
                url: "includes/deleteitem.php",
                type: 'post',
                data:{oid:oid,pageRef:pageRef},
                success: function( data ) {
                   window.location.href="myorders.php";
                }

            });
            });

    });
</script>
<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="navbar-nav">
        <li class="nav-item">
              <a class="nav-link" href="userpage.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="mycart.php">My Cart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="myorders.php"><b>My Orders</b></a>
            </li>
            <?php if($star==0){?><li class="nav-item">
              <a class="nav-link" href="star.php">Star Membership</a>
            </li><?php } ?>

            <li class="nav-item">
              <a class="nav-link" id="logout" style="cursor:pointer">Logout</a>
            </li>
        </ul>
    </nav>
    <h5 style="text-align:right;margin-right:2em"><?php echo $pname ?></h5> 
    
    <center><h4>Pending Orders</h4></center><hr>
    <?php
            $sql = "SELECT * from orders WHERE cid='$uid' AND stage='1'";
            $result1 = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result1)>0){
                ?>
                    
                    <table class="table" style="margin-right:2em">
    <thead>
      <tr>  
        <th>Order ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Deliverer</th>
        <th>Mobile</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
                <?php
                while($row = mysqli_fetch_array($result1)){
                    $finalprice=$finalprice+$row['price'];
?>
        <tr>
            <td><?php echo $row['oid']?></td>
            <td><?php echo $row['pname']?></td>
            <td><?php echo $row['quantity']?></td>
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['dname']?></td>
            <td><?php echo $row['dmobile']?></td>
            <td><button class="btn btn-negative deleteitem" oid="<?php echo $row['oid']?>"  price="<?php echo $row['price']?>" style="margin:0em">Delete</button></td>
        
        </tr>
                            
<?php                   
                
            }
            ?>
            </tbody>
            </table>
            <h4 style="margin-top:2em;margin-left:10em;">Sum: Rs. <?php echo $finalprice ?><?php if($star==0){
                $finalprice=$finalprice+50;
                ?> 
                Rs 50(Delivery) <br>Total : Rs.
                <?php echo $finalprice; }else{ ?>
                   + Free(Delivery) <br>Total : Rs.
                    <?php echo $finalprice; } ?>
                </h4>
            <?php
        }else{
            ?>
                <center><h4>No pending orders. <br><a href="userpage.php">Click here</a> to add items to your cart.</h4></center>
            <?php
        }
    ?>
    
    <center><h4 style="margin-top:2em">Order History</h4></center><hr>
    
    <?php
            $sql = "SELECT * from orders WHERE cid='$uid' AND stage='2'";
            $result1 = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result1)>0){
                ?>
                    
                    <table class="table" style="margin-right:2em">
    <thead>
      <tr>  
        <th>Order ID</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Transaction Date</th>
      </tr>
    </thead>
    <tbody>
                <?php
                while($row = mysqli_fetch_array($result1)){
                    $finalprice=$finalprice+$row['price'];
?>
        <tr>
            <td><?php echo $row['oid']?></td>
            <td><?php echo $row['pname']?></td>
            <td><?php echo $row['quantity']?></td>
            <td><?php echo $row['price']?></td>
            <td><?php echo $row['tdate']?></td>
            
        </tr>
                            
<?php                   
                
            }
            ?>
            </tbody>
            </table>
            <?php
        }else{
            ?>
                <center><h4>No order history.</center>
            <?php
        }
    ?>

</body>
</html>