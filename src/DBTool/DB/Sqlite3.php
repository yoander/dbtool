<?php
$db = '/home/yoander/Projects/php-util/db/config/sqlite-enc.db';
$conn = new SQLite3($db, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, 'DV$%&*wer1038625NMDMNASDQ@$');
$result = $conn->query('CREATE TABLE IF NOT EXISTS device_img(id INTEGER PRIMARY KEY AUTOINCREMENT,
                            device_id VARCHAR(128),
                                                        img_path VARCHAR(255),
                                                                                    target TINYINT)');


$result = $conn->query('INSERT INTO device_img(device_id, img_path, target)
                        VALUES("garbage", "garbage_img", 0)');

$result = $conn->query('SELECT * FROM device_img');
while ($row = $result->fetchArray()) {
    print_r($row);
}
