<?php
                $query = "SELECT * FROM categories LIMIT 3";
                $all_categories = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($all_categories)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];

                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $login_class = '';

                    $page_name = basename($_SERVER['PHP_SELF']);
                    $registration = 'registration.php';
                    $contact = 'contact.php';
                    $login = 'login.php';

                    if (isset($_GET['category']) &&  $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } else if ($page_name == $registration) {
                        $registration_class = 'active';
                    } else if ($page_name == $contact) {
                        $contact_class = 'active';
                    } else if ($page_name == $login) {
                        $login_class = 'active';
                    }
                    echo "<li class='nav-item $category_class'><a href='/cms/category/{$cat_id}' class='nav-link'>{$cat_title}</a></li>";
                }
