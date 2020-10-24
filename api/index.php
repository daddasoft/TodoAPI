<?php
$todo = new TodoController;
exit(json_encode($todo->Show()));