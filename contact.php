<?php include "includes/header.php"; ?>



<?php






if (isset($_POST['submit'])) {

    // use wordwrap() if lines are longer than 70 characters
    $to   = "samueldamarkuncoro@gmail.com";
    $subject   = wordwrap($_POST['subject'], 70);
    $body      = $_POST['body'];
    $header = "From: " . $_POST['email'];

    // send email
    mail($to, $subject, $body, $header);
    $message = "Thank you for your comment";
}
?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="position-relative col-sm-12  col-xs-mobile-fullwidth text-center margin-ten-bottom">
                <div class="wpd-innner-wrapper">
                    <h1>Contact</h1><img class="wow fadeInUp" src="https://goldencupseafood.com/assets/images/separator.png" width="300" height="20">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="wpd-innner-wrapper text-center">
                        <h2 style="margin:16px 0">Sadakun's</h2>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br> City of Kediri. East Java - Indonesia.</p>
                    </div>

                    <div class="wpb_column vc_column_container col-sm-12 col-md-6 col-xs-12 xs-text-center no-padding" style="padding-bottom:20px!important">
                        <div class="vc-column-innner-wrapper">
                            <div class="wpd-innner-wrapper text-center">
                                <!--<img src="https://goldencupseafood.com/assets/images/person.png" style="width:100px;max-width:100%;margin-bottom:20px">
                                            <h6 style="margin-bottom:16px">Indra Wibowo</h6>
                                            <p><a href="mailto:marketing@goldencupseafood.com ">marketing@goldencupseafood.com </a></p>
                                            <p>+628 11 608 7789</p>-->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-wrap">

                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <h5 class="text-center"></h5>

                            <div class="form-group">
                                <label for="fullname">Name</label>
                                <input type="text" name="fullname" id="" class="form-control" placeholder="Enter Your Fullname">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <input type="email" name="subject" id="email" class="form-control" placeholder="Enter Your Subject">
                            </div>

                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" name="body" id="" cols="40" rows="10" placeholder="Write Here..."></textarea>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-md btn-block" value="Send">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>