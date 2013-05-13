<?php

$this_db = new IntirnetDb();

$donors_action = new Prepare();

$donors_action->prepareData($this_db->allDB());

?>
