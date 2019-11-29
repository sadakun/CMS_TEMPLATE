<?php include "includes/header.php"; ?>
<?php
if (isset($_POST['submit'])) {
    // use wordwrap() if lines are longer than 70 characters
    $to   = "sm123kuncoro@gmail.com";
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
            <div class="position-relative col-sm-12  col-xs-mobile-fullwidth margin-ten-bottom">
                <div class="text-center">
                    <h1>About</h1>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">

                    <div class="wpd-innner-wrapper text-center">
                        <h2 style="margin:50px 0"></h2>
                        <p>It is a long established fact that a reader will be distracted by the readable content of a page
                            <br> .<br> . <br> . <br>
                            <br> as opposed to using 'Content here, content here', making it look like readable English. <br> . <br>.<br> .<br> City of Kediri. East Java - Indonesia.</p>
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


            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>