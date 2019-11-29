<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category </label>

        <?php
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];


            $query = "SELECT categories.cat_id, categories.cat_title, categories.cat_user_id, users.user_id, users.username FROM categories JOIN users ON categories.cat_user_id = users.user_id WHERE cat_id = $cat_id ";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                $cat_user_id = $row['cat_user_id'];
                ?>
                <input value="<?php if (isset($cat_title)) {
                                            echo $cat_title;
                                        } ?>" class="form-control" type="text" name="cat_title">
        <?php
            }
        }
        ?>
        <?php
        //--------------------------------Update Query-----------------------------//
        if (isset($_POST['update_category'])) {
            $get_cat_title = escape($_POST['cat_title']);
            if (categoryExist($get_cat_title)) {
                echo "Category already exist";
            } else {
                $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
                mysqli_stmt_bind_param($stmt, 'si', $get_cat_title, $cat_id,  $cat_user_id);
                mysqli_stmt_execute($stmt);

                confirmQuery($stmt);
                mysqli_stmt_close($stmt);

                redirect("categories.php");
            }
        }
        ?>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>