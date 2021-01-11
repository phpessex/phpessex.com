<?php
require_once('partials/head.php');
require_once('partials/nav.php');
include "constants.php";

if (isset($_POST['save']) && 'contact' === $_POST['save']) {
    require __DIR__ . '/vendor/autoload.php';

    $recaptcha = new \ReCaptcha\ReCaptcha(SECRET, new \ReCaptcha\RequestMethod\CurlPost());

    $gRecaptchaResponse = @$_POST['g-recaptcha-response'];
    $remoteIp           = @$_SERVER['REMOTE_ADDR'];

    $resp = $recaptcha->verify($gRecaptchaResponse, $remoteIp);
    $captchaSuccess = $resp->isSuccess();

    if (!$captchaSuccess) {
        $alert = '<div class="col-lg-12"><div class="alert alert-danger text-center" role="alert"><strong>Error!</strong> ReCapture verification ' .
            'failed, please try again.</div></div>';
    } else {
        // Receive and sanitize input
        $name    = $_POST['name'];
        $email   = $_POST['email'];
        $phone   = $_POST['phone'];
        $message = $_POST['message'];
        $headers = 'From: contact@phpessex.com' . "\r\n" . 'Reply-To: contact@phpessex.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // set up email
        $msg = "New message from PHPEssex.com!\n\nName: " . $name . "\nEmail: " . $email . "\nPhone: " . $phone . "\n\nMessage:\n\n" . $message;
        $msg = wordwrap($msg, 70);
        $sent = mail('contact@phpessex.com', 'PHP Essex Website Enquiry', $msg, $headers, '-fcontact@phpessex.com');

        if ($sent) {
            $alert = '<div class="col-lg-12"><div class="alert alert-success text-center" role="alert"><strong>Thank you!</strong> We appreciate '
                   . 'you taking the time to contact us.</div></div>';
        } else {
            $alert = '<div class="col-lg-12"><div class="alert alert-danger text-center" role="alert"><strong>Error!</strong> We are sorry but we '
                   . 'could not pass on your message at this time.</div></div>';
        }
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
                        <a href="https://www.meetup.com/PHP-Essex" class="btn-social btn-outline"><i class="fa fa-fw fa-meetup" aria-hidden="true"></i></a>
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
                                <label for="name">Name</label>
                                <input name="name" id="name" type="text" class="form-control" required="required" />
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="email">Email Address</label>
                                <input name="email" id="email" type="email" class="form-control" required="required" />
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="phone">Phone Number</label>
                                <input name="phone" id="phone" type="tel" class="form-control" required="required" />
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-lg-12">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" class="form-control" rows="6" required="required"></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <div style="margin: 10px 0; width: 305px;" class="g-recaptcha" data-sitekey="<?php echo SITEKEY; ?>"></div>
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="hidden" name="save" value="contact">
                                <input type="submit" class="btn btn-default" value="Submit" />
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

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
require_once('partials/footer.php');
