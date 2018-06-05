<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
header("Cache-Control: ", false);
header("Expires: ", gmdate('r', 0));
header("X-Accel-Expires: ", gmdate('r', 0));
header("Last-Modified: ", gmdate('r'));
header("Pragma: no-cache");
phpinfo();

