<?php
    include_once("header.php");
    if(!isset($_SESSION['user_id'])){
        header("Location: login");
    }
?>
    <div class="page-accounts clearfix">
        <?php include_once("user-sidebar.php"); ?>
        <div class="acc-content">
            <h1>Newsletter Preferences</h1>
            <div class="inner-wrap">
                <form action="#" class="newsletter-form">
                    <div class="input-wrap">
                        <input type="checkbox" id="marketing" name="mail_marketing"><label for="marketing">Marketing Emails</label>
                    </div>
                    <div class="input-wrap">
                        <input type="checkbox" id="important" name="mail_important"><label for="important">Important Emails</label>
                    </div> <hr><br>
                    <div class="input-wrap clearfix">
                        <input type="submit" value="Save" class="btn-submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include_once("footer.php"); ?>