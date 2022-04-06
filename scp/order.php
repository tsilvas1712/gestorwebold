<?php
/*********************************************************************
    mdo.php

    Jonas Schen
    Copyright (c)  2016

**********************************************************************/
require('staff.inc.php');

require_once INCLUDE_DIR.'class.note.php';

$page = 'order.inc.php';

$nav->setTabActive('order');
require(STAFFINC_DIR.'header.inc.php');
require(STAFFINC_DIR.$page);
include(STAFFINC_DIR.'footer.inc.php');
?>
