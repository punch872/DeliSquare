<?php
/**
 * Created by PhpStorm.
 * User: sangrit
 * Date: 30/10/17
 * Time: 12:45
 */
session_destroy();
echo "
<script>
    console.log('[+]User login');
    alert('Taking you to app');
    window.location.href='index.php';
</script>
";
