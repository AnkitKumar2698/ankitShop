<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}
include 'db/conn.php'; 

$productID=$_GET['id'];
$email=$_SESSION['email'];
if($productID >=0)
{
   $query= "select email from product where id='$productID'";
   $result1=mysqli_query($conn,$query);
   $res1=mysqli_fetch_array($result1);
   if($res1['email']!== $email)
   {
       header("location : form.php");
       exit;
   }
 else{
    $query= "select name,description,price,promo,weight,productlimit,email from product where id='$productID'";
    $result1=mysqli_query($conn,$query);
    $res1=mysqli_fetch_array($result1);
    $previous_product_name=$res1['name'];
    $previous_product_discription=$res1['description'];
    $previous_price=$res1['price'];
    $previous_promo=$res1['promo'];
    $previous_limit=$res1['productlimit'];
    $previous_weight=$res1['weight'];
    if(isset($_POST['product_save']))
    {
     $product_name=$_POST['product_name'];
    $product_discription=$_POST['product_description'];
    $price=$_POST['product_price'];
    $promo=$_POST['product_promo'];
    $limit=$_POST['product_limit'];
    $weight=$_POST['product_weight'];
    $product_img_dir1="uploads/".($_FILES['productImg1']['name']);
    $product_img_dir2="uploads/".($_FILES['productImg2']['name']);
    $query="UPDATE `product` SET `name`='$product_name',`description`='$product_discription',`price`='$price',`promo`='$promo',`weight`='$weight',`productlimit`='$limit',`img1`='$product_img_dir1',`img2`='$product_img_dir2' WHERE id='$productID'";
    $result=mysqli_query($conn,$query);
    if($result)
    {
        move_uploaded_file($_FILES['productImg1']['tmp_name'],$product_img_dir1);
        move_uploaded_file($_FILES['productImg2']['tmp_name'],$product_img_dir2); 
    }
    else{
       echo "Data not get saved";
    }
    header("location: form.php");
    exit;
    }
   }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


    <title>Edit Product</title>
</head>

<body>
    <?php 
    include('includes/header.php');
    include('includes/topbar.php');
    include('includes/sidebar.php');
    ?>
    <div class="container-fluid mt-5">
        <div class="row">
        <div class="col-sm-6 col-md-8 ml-auto">
                
                <form method="POST" action="/vr1/admin/editProduct.php?id=<?php echo $productID ?>"  enctype="multipart/form-data">
                        <h3>Edit Product </h3>
                        <hr>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" aria-describedby="emailHelp"
                             value="<?php echo $previous_product_name?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Product Image1</label>
                            <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg, image/svg" required class="form-control-file" name="productImg1" id="productImg1">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Product Image2</label>
                            <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg, image/svg" class="form-control-file" name="productImg2" id="productImg2">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Product Description</label>
                            <textarea class="form-control" id="product_description" name="product_description" rows="3" ><?php echo  $previous_product_discription ?></textarea>
                        </div>
                        <hr>
                        <h2>Price and Quantity</h2>
                        <div class="container-fluid mx-auto">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlEmail1">Price</label>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="text" name="product_price" id="product_price" class="form-control col-sm-5"
                                            value="<?php echo $previous_price?>" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlEmail1">Promo</label>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text">RM</span>
                                            </div>
                                            <input type="text" name="product_promo" id="product_promo"class="form-control col-sm-5"
                                            value="<?php echo  $previous_promo?>" aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlEmail1">Limit</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="product_limit" id="product_limit" class="form-control col-sm-7"
                                            value="<?php echo $previous_limit?>"    aria-label="Amount (to the nearest dollar)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlEmail1">Weight</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="product_weight" id="product_weight"  class="form-control col-sm-5"
                                            value="<?php echo $previous_weight?>"  aria-label="Amount (to the nearest dollar)">
                                            <div class="input-group-append">
                                                <span class="input-group-text">Kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-6">
                                    <button type="submit" name="product_save" class="btn btn-primary mb-3">Submit</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
<?php include('includes/footer.php') ?>;