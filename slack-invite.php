<?php
require_once('partials/head.php');
require_once('partials/nav.php');

include "constants.php";

$slackUrl = 'https://'.SUBDOMAIN.'.slack.com/api/rtm.start?simple_latest=true&no_unreads=true&token='.TOKEN;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $slackUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$reply = json_decode(curl_exec($ch), true);
curl_close($ch);

// Set defaults
$active = 0;
$total  = 0;
$name   = SUBDOMAIN;
$img    = "";

// Get team data from slack
if($reply['ok']) {
    $img  = $reply['team']['icon']['image_68'];
    $name = $reply['team']['name'];

    foreach($reply['users'] as $val) {
        $total = $total + 1;

        if('active' == $val['presence']) {
            $active = $active + 1;
        }
    }
}
?>
<div class="container">
    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">
                <hr>
                <h2 class="intro-text text-center">Join <strong>PHP Essex on Slack</strong></h2>
                <hr>
                <div class="clearfix text-center col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                    <h1>
                        <img src="img/slack-team.png" alt="Slack team image" id="slack-team" style="width: 70px; top: -2px; position: relative; margin-right: 5px;">

                        <div style="display: inline-block;">Get Your Invite</div>
                    </h1>

                    <form id="slack-invite-form" method="POST">
                        <div class="form-group form-group-lg">
                            <input type="email" class="form-control" placeholder="Enter your email address" autofocus="autofocus" name="email" />
                        </div>

                        <div class="form-group">
                            <div style="margin: 10px auto; width: 305px;" class="g-recaptcha" data-sitekey="<?php echo SITEKEY; ?>"></div>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-success btn-lg" id="inviteBtn" type="submit">Invite Me!</button>
                        </div>
                        <br />
                        <p>Already part of the PHP Essex Slack group? <a href="https://phpessex.slack.com">Sign in here<a>.</p>
                    </form>
                </div>
                <br class="clearfix" />
            </div>
        </div>
    </div>
</div>
<!-- /.container -->

<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    $(document).ready(function() {
        $('#slack-invite-form').submit(function (e) {
            e.preventDefault();
            var button = document.getElementById('inviteBtn');
            button.style.background = "#D6D6D6";
            button.innerHTML = "Please Wait...";
            $this = $(this);
            $.ajax({
                type: "POST",
                url: "/slack-invite-backend.php",
                data: $this.serialize()
            }).done(function (response) {
                response = JSON.parse(response);
                if (response.ok) {
                    button.style.background = "#68C200";
                }
                button.innerHTML = response.message;
            }).fail(function (jqXHR, textStatus) {
                button.style.background = "#f4514d";
                button.innerHTML = "Backend Failure"
            });
        });
    });
</script>
<?php
require_once('partials/footer.php');