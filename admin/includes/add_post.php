<?php
if (isset($_POST['create_post'])) {
    $post_title         = escape($_POST['post_title']);
    $post_user          = escape($_POST['post_user']);
    $post_category_id   = escape($_POST['post_category']);
    $post_status        = escape($_POST['post_status']);
    $post_image         = $_FILES['image']['name'];
    $post_image_temp    = $_FILES['image']['tmp_name'];
    $post_tag           = escape($_POST['post_tag']);
    $post_content       = escape($_POST['post_content']);
    $post_date          = escape(date('d-m-y'));

    // move_uploaded_file($post_image_temp, "../images/$post_image");
    move_uploaded_file($post_image_temp, "../images/" . $post_image);

    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tag, post_status)";
    $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tag}', '{$post_status}' ) ";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);

    $get_post_id = mysqli_insert_id($connection);
    echo "<p class = 'bg-success'>Post Created. <a href='../post.php?p_id={$get_post_id}'>View Post </a> or <a href='posts.php'> View All Post</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="category">Categories:</label>
        <select name="post_category" id="post_category">
            <?php
            $category_query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $category_query);
            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users:</label>
        <select name="post_user" id="">
            <?php
            $user_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $user_query);
            confirmQuery($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];

                echo "<option value='$username'>{$username}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="status">Post Status:</label>
        <select name="post_status" id="">
            <option value='draft'>Choose Status</option>
            <option value='draft'>Draft</option>
            <option value='published'>Published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tag">Post Tags</label>
        <input type="text" class="form-control" name="post_tag">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10">
    </textarea>
    </div>

    <div class="form-group">
        <a href="posts.php" class="btn btn-warning">Back</a>
        <input type="submit" class="btn btn-success" name="create_post" value="Publish Post">
    </div>

</form>