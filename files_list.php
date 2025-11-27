<?php
// lists files in this folder
foreach (scandir(__DIR__) as $f) echo htmlspecialchars($f) . "<br>";