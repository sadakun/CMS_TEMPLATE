<?php
if (isset($_POST['checkBoxArray'])) {

    foreach ($_POST['checkBoxArray'] as $commentValueId) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'approved':
                $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id={$commentValueId} ";
                $update_approve_comment_query = mysqli_query($connection, $query);
                confirmQuery($update_approve_comment_query);
                break;

            case 'unapproved':
                $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id={$commentValueId} ";
                $update_approve_comment_query = mysqli_query($connection, $query);
                confirmQuery($update_approve_comment_query);
                break;

            case 'delete':
                $query = "DELETE FROM comments WHERE comment_id={$commentValueId} ";
                $update_delete_comment = mysqli_query($connection, $query);
                confirmQuery($update_delete_comment);
                break;
        }
    }
}
?>

    <form action="" method="post">

        <table class="table table-bordered table-hover">
            <div id="bulkOptionContainer" class="col-xs-2">
                <select class="form-control" name="bulk_options" id="">
                    <option value="">Select Option</option>
                    <option value="approved">Approve</option>
                    <option value="unapproved">Unapprove</option>
                    <option value="delete">Delete</option>
                </select>
            </div>

            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>

            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>In Response to</th>
                    <th>Date</th>
                    <th>Approve</th>
                    <th>Unapprove</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // $query = "SELECT * FROM comments ORDER BY comment_id DESC";
                // $select_comments = mysqli_query($connection, $query);
                // SELECT comments.comment_id, comments.comment_post_id, comments.comment_author, comments.comment_email, posts.post_id 
                // FROM comments JOIN posts ON comments.comment_post_id = posts.post_id WHERE post_user_id = 45
                $users = currentUser();
                if (isAdmin($_SESSION['username'])) {
                    $query = "SELECT comments.comment_id ,comments.comment_post_id , comments.comment_author,  comments.comment_content, ";
                    $query .= "comments.comment_email ,comments.comment_status ,comments.comment_date, posts.post_id, posts.post_title ";
                    $query .= "FROM comments ";
                    $query .= "JOIN posts ON comments.comment_post_id = posts.post_id ORDER BY comment_id DESC ";
                } else {
                    $query = "SELECT comments.comment_id ,comments.comment_post_id , comments.comment_author,  comments.comment_content, ";
                    $query .= "comments.comment_email ,comments.comment_status ,comments.comment_date, posts.post_id, posts.post_title ";
                    $query .= "FROM comments ";
                    $query .= "JOIN posts ON comments.comment_post_id = posts.post_id WHERE post_user_id = $users ORDER BY comment_id DESC ";
                }
                $select_comments = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_comments)) {
                    $comment_id         = $row['comment_id'];
                    $comment_post_id    = $row['comment_post_id'];
                    $comment_author     = $row['comment_author'];
                    $comment_content    = $row['comment_content'];
                    $comment_email      = $row['comment_email'];
                    $comment_status     = $row['comment_status'];
                    $comment_date       = $row['comment_date'];
                    $post_id            = $row['post_id'];
                    $post_title         = $row['post_title'];

                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id ?>'>
                    <?php
                        echo "<td>{$comment_id}</td>";
                        echo "<td>{$comment_author}</td>";
                        echo "<td>{$comment_content}</td>";
                        echo "<td>{$comment_email}</td>";
                        echo "<td>{$comment_status}</td>";

                        echo "<td><a href='../post/$post_id'>$post_title</a></td>";


                        echo "<td>{$comment_date}</td>";

                        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                        echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                        echo "<td><a onClick=\"javascript: return confirm('Are you sure want to delete this comment?'); \" href='comments.php?delete=$comment_id'>Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
            </tbody>
        </table>
    </form>

    <?php
    if (isset($_GET['approve'])) {
        $get_comment_id = escape($_GET['approve']);
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $get_comment_id ";
        $approve_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }

    if (isset($_GET['unapprove'])) {
        $get_comment_id = escape($_GET['unapprove']);
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $get_comment_id ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }

    if (isset($_GET['delete'])) {
        $get_comment_id = escape($_GET['delete']);
        $query = "DELETE FROM comments WHERE comment_id = {$get_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    }
    ?>