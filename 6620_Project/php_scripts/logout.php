
<?php
    session_start();

    //if a user clicks on log out it destroys their session
    session_destroy();
    // Redirect to the login page:
    header('Location: ../project_template_page/index.php');
?>