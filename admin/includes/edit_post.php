<?php
if (isset($_GET['p_id'])) {
    $get_post_id = escape($_GET['p_id']);
}

$query = "SELECT * FROM posts WHERE post_id = $get_post_id ";
$select_posts_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id            = $row['post_id'];
    $post_user_id          = $row['post_user_id'];
    $post_title         = $row['post_title'];
    $post_category_id   = $row['post_category_id'];
    $post_status        = $row['post_status'];
    $post_image         = $row['post_image'];
    $post_content       = $row['post_content'];
    $post_tag           = $row['post_tag'];
    $post_comment_count = $row['post_comment_count'];
    $post_date          = $row['post_date'];
}
if (isset($_POST['update_post'])) {

    $post_user_id          = escape($_POST['post_user_id']);
    $post_title         = escape($_POST['post_title']);
    $post_category_id   = escape($_POST['post_category']);
    $post_status        = escape($_POST['post_status']);
    $post_image         = $_FILES['image']['name'];
    $post_image_temp    = $_FILES['image']['tmp_name'];
    $post_content       = escape($_POST['post_content']);
    $post_tag           = escape($_POST['post_tag']);

    // move_uploaded_file($post_image_temp, "../images/$post_image");
    move_uploaded_file($post_image_temp, "../images/" . $post_image);



    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $get_post_id ";
        $select_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query  = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_user_id = '{$post_user_id}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tag = '{$post_tag}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$get_post_id} ";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);

    echo "<p class = 'bg-success'>Post Updated. <a href='/cms/post/$get_post_id'>View Post </a> or <a href='posts.php'> Edit More Post</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input value="<?php echo htmlspecialchars(stripslashes($post_title)); ?>" type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="category">Categories</label><br>
        <select name="post_category" id="post_category">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                if ($cat_id == $post_category_id) {
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Author</label><br>
        <select <?php if (!isAdmin()) { ?>disabled<?php } ?> name="post_user_id" id="mySelect">

            <?php
            $user_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $user_query);
            confirmQuery($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                if ($user_id == $post_user_id) {
                    echo "<option selected value='{$user_id}'>{$username}</option>";
                } else {
                    echo "<option value='{$user_id}'>{$username}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="status">Post Status</label>
        <select name="post_status" id="post_status">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php
            if ($post_status == 'published') {
                echo "<option value='draft'>Draft</option>";
            } else {
                echo "<option value='published'>Publish</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tag">Post Tags</label>
        <input value="<?php echo $post_tag; ?>" type="text" class="form-control" name="post_tag">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
</form>