<?php include('partials/menu.php'); ?>

   <div class="main-content">
    <div class="wrapper">
       <h1>Add Category</h1>
        
       <br><br>
       <?php 
         
         if(isset($_SESSION['add']))
         {
           echo $_SESSION['add'];
           unset($_SESSION['add']);
         }    

         if(isset($_SESSION['upload']))
         {
           echo $_SESSION['upload'];
           unset($_SESSION['upload']);
         }
       
       ?>

       <br><br>

       <!-- Add Category Form Starts -->
       <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
               <td>Title: </td>
               <td>
                 <input type="text" name="title" placeholder="Category Title">
               </td>
            </tr>
            <tr>
               <td>Select Image: </td>
               <td>
                  <input type="file" name="image">
               </td>

            </tr>
            <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" value="YES"> Yes
                    <input type="radio" name="featured" value="NO"> No

                </td>
            </tr>

            <tr>
                <td>Action: </td>
                <td>
                    <input type="radio" name="active" value="YES"> Yes
                    <input type="radio" name="active" value="NO"> No
                </td>
            </tr>
            <tr>
                 <td colspan='2'>
                 <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                 </td>

            </tr>
        </table>
       </form>
       <!-- Add Category Form Ends -->
       <?php 
       
         //Check Whether the Submit Button is Clicked or Not
         if(isset($_POST['submit']))
         {
          //echo "Clicked";

         //1. Get the Value fom Category Form
         $title = $_POST['title'];

         //For Radio input, We need to Check the Button is Selected or Not
         if(isset($_POST['featured']))
         {
            //Get the Value from form
            $featured = $_POST['featured'];

         }
         else
         {
           //Set the Default Value
           $featured = "No";

         }
           if(isset($_POST['active']))
           {
              $active = $_POST['active'];
           }
           else
           {   
              $active = "No";
           }

           //Check Whether the image is selected or not and set the value for image name accoridingly
         // print_r($_FILES['image']);

        //die();//Break the Code Here
        if(isset($_FILES['image']['name']))
        {
           //Upload the Image
           //Do upload image we need image name, source path and destination path
           $image_name = $_FILES['image']['name'];

           // Upload the Image only If image is selected
           if($image_name != "")
           {      

           //Auto Rename our image
           //Get the Extension of our image (jpg, png, gif, etc) e.g. "specialfood1.jpg"
           $ext = end(explode('.',$image_name));
           
           //Rename the image
           $image_name = "Food_category_".rand(000, 999).'.'.$ext;// e.g. Food_category_834.jpg
           
           $source_path = $_FILES['image']['tmp_name'];

           $destination_path = "../images/category/". $image_name;

           //Finally upload the Image
           $upload = move_uploaded_file($source_path, $destination_path);

           //Check Whether the Image is Uploaded or not
           //And if the image is not uploaded then we will stop the process and redirect with error message
           if($upload==false)
           {
             //Set Message
             $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
             //Redirect to Add Category Page
             header('location:'.SITEURL.'admin/add-category.php');
             //Stop the Process
             die();
           }

           }
        }
        else
        {
          //Don't Upload Image and Set the image_name value as black
          $image_name="";

        }
           //2. Create SQL Query to insert Category into Database
           $sql= "INSERT INTO tbl_category SET
                title='$title',
                image_name= '$image_name',
                featured='$featured',
                active='$active'
                ";
            
            //3. Execute the Query and Save in Database
            $res= mysqli_query($conn,$sql);
            
            //4. Check Whether the Query executed or not and data added or not
            if($res==true)
            {
               //Query Executed and Category Added
               $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
               //Redirect to Manage Category Page
               header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
              //Failed to Add Category
              $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
              //Redirect to Manage Category Page
              header('location:'.SITEURL.'admin/add-category.php');
            }

         }
       
       
       ?>
   </div>
  </div>


<?php include('partials/footer.php'); ?>