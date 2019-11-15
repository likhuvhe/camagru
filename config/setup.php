<?php

include("database.php");

$conn->exec("CREATE TABLE `comments` (
    `num` int(11) NOT NULL,
    `userid` int(11) NOT NULL,
    `useridown` int(11) NOT NULL,
    `comment` varchar(10000) NOT NULL,
    `timess` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `imagenu` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
  CREATE TABLE `likes` (
  `num` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `useridown` int(11) NOT NULL,
  `timess` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `imagenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tempsave` (
  `images` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `userimage` (
  `num` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `images` longblob NOT NULL,
  `timess` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `userid` int(10) NOT NULL,
  `username` varchar(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `passwd` varchar(150) NOT NULL,
  `vkey` varchar(50) DEFAULT NULL,
  `verify` int(1) DEFAULT (0),
  `pref` tinyint(1) DEFAULT (1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `comments`
  ADD PRIMARY KEY (`num`);
  
ALTER TABLE `likes`
  ADD PRIMARY KEY (`num`);
  
ALTER TABLE `userimage`
  ADD PRIMARY KEY (`num`);
  
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);
  
ALTER TABLE `comments`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
    
ALTER TABLE `likes`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

ALTER TABLE `userimage`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
  
ALTER TABLE `users`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;");
?>