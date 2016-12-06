<?php
require_once('partials/head.php');
require_once('partials/nav.php');

if (isset($_POST['save']) && 'contact' == $_POST['save']) {
    // Receive and sanitize input
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $message = $_POST['message'];

    // set up email
    $msg = "New contact form submission!\nName: " . $name . "\nEmail: " . $email . "\nPhone: " . $phone . "\nEmail: " . $email;
    $msg = wordwrap($msg, 70);
    $sent = mail("contact@phpessex.com", "PHP Essex Website Enquiry", $msg);

    if ($sent) {
        $alert = '<div class="col-lg-12"><div class="alert alert-success text-center" role="alert"><strong>Thank you!</strong> We appreciate '
               . 'you taking the time to contact us.</div></div>';
    } else {
        $alert = '<div class="col-lg-12"><div class="alert alert-danger text-center" role="alert"><strong>Error!</strong> We are sorry but we '
               . 'could not pass on your message at this time.</div></div>';
    }
}
?>
    <div class="container">

        <div class="row">
            <div class="box">
                <div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center">Contact <strong>PHP Essex</strong></h2>
                    <hr>
                </div>

                <?php if (isset($alert)) { echo $alert; } ?>

                <div class="col-lg-12">
                    <p>We would love to hear from you. Whether it's your thoughts on the site, feedback from a meetup or
                        if you'd just like to say Hi! Below are our contact links or if you would prefer, you can use
                        the form below to send us an email.</p>
                </div>

                <div class="col-md-3">
                    <!-- TODO -->
                </div>
                <div class="col-md-6">
                    <div class="contactLinks">
                        <a href="mailto:contact@phpessex.com" class="btn-social btn-outline"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i></a>
                        <a href="https://phpessex.slack.com/" class="btn-social btn-outline"><i class="fa fa-fw fa-slack" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/phpessex" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter" aria-hidden="true"></i></a>
                        <a href="https://github.com/phpessex" class="btn-social btn-outline"><i class="fa fa-fw fa-github" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- TODO -->
                </div>
                <div class="clearfix"></div>

                <div class="col-lg-12">
                    <form role="form" method="post">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Name</label>
                                <input type="text" class="form-control" required="required" />
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Email Address</label>
                                <input type="email" class="form-control" required="required" />
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" required="required" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-12">
                                <label>Message</label>
                                <textarea class="form-control" rows="6" required="required"></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="hidden" name="save" value="contact">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--<div class="row">-->
        <!--    <div class="box">-->
        <!--        <div class="col-lg-12">-->
        <!--            <hr>-->
        <!--            <h2 class="intro-text text-center">Contact <strong>PHP Essex</strong></h2>-->
        <!--            <hr>-->
        <!--        </div>-->
        <!--        <div class="col-md-8">-->
        <!--            <!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! -->-->
        <!--            <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed"></iframe>-->
        <!--        </div>-->
        <!--        <div class="col-md-4">-->
        <!--            <p>Phone: <strong>123.456.7890</strong></p>-->
        <!--            <p>Email: <strong><a href="mailto:contact@phpessex.com">contact@phpessex.com</a></strong></p>-->
        <!--            <p>Address: <strong>3481 Melrose Place <br>Beverly Hills, CA 90210</strong></p>-->
        <!--        </div>-->
        <!--        <div class="clearfix"></div>-->
        <!--    </div>-->
        <!--</div>-->

    </div>
    <!-- /.container -->
<?php
require_once('partials/footer.php');