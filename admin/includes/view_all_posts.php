<?php include "delete_modal.php"; ?>
<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = escape($_POST['bulk_options']);

        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id={$postValueId} ";
                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id={$postValueId} ";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id={$postValueId} ";
                $update_delete_post = mysqli_query($connection, $query);
                confirmQuery($update_delete_post);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id= '{$postValueId}' ";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_user_id       = $row['post_user_id'];
                    $post_title         = $row['post_title'];
                    $post_category_id   = $row['post_category_id'];
                    $post_date          = $row['post_date'];

                    $post_status        = $row['post_status'];
                    $post_image         = $row['post_image'];
                    $post_tag           = $row['post_tag'];
                    $post_content       = escape($row['post_content']);
                }
                $query = "INSERT INTO posts(post_category_id, post_user_id, post_title, post_date, post_image, post_content, post_tag, post_status )";
                $query .= "VALUES({$post_category_id}, '{$post_user_id}','{$post_title}', now(), '{$post_image}', '{$post_content}', '{$post_tag}', '{$post_status}' ) ";
                $copy_query = mysqli_query($connection, $query);
                confirmQuery($copy_query);
                break;
        }
    }
}
?>

    <form action="" method="post">

        <table class="table table-bordered table-hover">
            <div id="bulkOptionContainer" class="col-xs-4">
                <select class="form-control" name="bulk_options" id="">
                    <option value="">Select Option</option>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                    <option value="clone">Clone</option>
                </select>
            </div>

            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                <a class="btn btn-primary" href="posts.php?source=add_post">Add new</a>
            </div>

            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Posts</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Views</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $users = currentUser();
                if (isAdmin($_SESSION['username'])) {
                    $query  = "SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tag, ";
                    $query .= "posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title, users.user_id, users.username ";
                    $query .= "FROM posts JOIN categories ON posts.post_category_id = categories.cat_id JOIN users ON posts.post_user_id = users.user_id ORDER BY post_id DESC ";
                    confirmQuery($query);
                    $select_posts = mysqli_query($connection, $query);

                    // SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tag, 
                } else {
                    $query  = "SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tag, ";
                    $query .= " posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title, users.user_id, users.username ";
                    $query .= " FROM posts JOIN categories ON posts.post_category_id = categories.cat_id JOIN users ON posts.post_user_id = users.user_id ";
                    $query .= " WHERE post_user_id = $users ORDER BY post_id DESC ";
                    confirmQuery($query);
                    $select_posts = mysqli_query($connection, $query);
                }
                // $users = currentUser();
                // $query = "SELECT posts.post_id, posts.post_user_id, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tag, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title, users.user_id, users.username FROM posts JOIN categories ON posts.post_category_id = categories.cat_id JOIN users ON posts.post_user_id = users.user_id WHERE user_id = $users ORDER BY post_id DESC";
                // $query .= "posts.post_tag, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title, users.user_id, users.username ";
                // $query .= "FROM posts ";
                // $query .= "FROM posts JOIN categories ON posts.post_category_id = categories.cat_id JOIN users ON posts.post_user_id = users.user_id WHERE user_id = $users ORDER BY post_id DESC ";

                $select_posts = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id            = $row['post_id'];

                    $post_user_id       = $row['post_user_id'];
                    $post_title         = $row['post_title'];
                    $post_category_id   = $row['post_category_id'];
                    $post_status        = $row['post_status'];
                    $post_image         = $row['post_image'];
                    $post_tag           = $row['post_tag'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date          = $row['post_date'];
                    $post_view_count    = $row['post_view_count'];
                    $category_title     = $row['cat_title'];
                    $category_id        = $row['cat_id'];
                    $user_id            = $row['user_id'];
                    $username           = $row['username'];

                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
                <?php
                    echo "<td>{$post_id}</td>";

                    if (!empty($username)) {
                        echo "<td>{$username}</td>";
                    }

                    echo "<td>{$post_title}</td>";

                    echo "<td>$category_title</td>";


                    echo "<td>$post_status</td>";
                    echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                    echo "<td>$post_tag</td>";

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $send_comment_query = mysqli_query($connection, $query);

                    $row = mysqli_fetch_array($send_comment_query);
                    $comment_id = $row['comment_id'];
                    $count_comments = mysqli_num_rows($send_comment_query);

                    echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";
                    echo "<td>$post_date</td>";
                    echo "<td> <a href='../post/$post_id'><i class='fa fa-clipboard'>view</i></a></td>";

                    echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'><i class='fa fa-edit'>edit</i></a></td>";

                    // <form method="post">
                    // <input type="hidden" name="post_id" value="<?php echo post_id; ">
                    // echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>';
                    // </form>

                    echo "<td><a rel='$post_id' href='javascript:void(0)' data-toggle='modal' class='delete_link'><i class='fa fa-trash'>delete</i></a></td>";
                    echo "<td><a href='posts.php?reset=$post_id'>$post_view_count</a></td>";
                    echo "</tr>";
                }
                // echo "<td><a onClick=\"javascript: return confirm('Are you sure want to delete this post?'); \" href='posts.php?delete=$post_id'>Delete</a></td>";
                ?>


            </tbody>
        </table>
    </form>

    <?php
    if (isset($_GET['delete'])) {
        $get_post_id = escape($_GET['delete']);
        $query = "DELETE FROM posts WHERE post_id = {$get_post_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
    ?>

    <?php
    if (isset($_GET['reset'])) {
        $get_post_id = escape($_GET['reset']);
        $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
        $reset_query = mysqli_query($connection, $query);
        header("Location: posts.php");
    }
    ?>

    <script>
        $(document).ready(function() {
            $(".delete_link").on('click', function() {
                // $(".delete_link").on('click', function() {
                var id = $(this).attr("rel");
                var delete_url = "posts.php?delete=" + id + " ";
                // alert(delete_url);

                $(".modal_delete_link").attr("href", delete_url);
                $("#myModal").modal('show');
            });

        });
    </script>