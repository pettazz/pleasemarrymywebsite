-- Create syntax for TABLE 'Action'
CREATE TABLE `Action` (
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `description` varchar(256) DEFAULT '',
  `value` int(2) NOT NULL,
  `tag` enum('ACTION','CONVERSATION','FUCKERY','NEGATIVE','HOMETOWNS','FANTASY_SUITE','FINALE') NOT NULL DEFAULT 'ACTION',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'Contestant'
CREATE TABLE `Contestant` (
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(127) NOT NULL DEFAULT '',
  `alive` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'Episode'
CREATE TABLE `Episode` (
  `id` int(2) NOT NULL,
  `startTime` int(10) unsigned NOT NULL,
  `teamSize` int(2) unsigned NOT NULL,
  `isPlayoffs` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'Ownership'
CREATE TABLE `Ownership` (
  `Team` varchar(64) NOT NULL DEFAULT '',
  `Contestant` varchar(64) NOT NULL DEFAULT '',
  `episode` int(2) unsigned NOT NULL,
  PRIMARY KEY (`Team`,`Contestant`,`episode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'Score'
CREATE TABLE `Score` (
  `Contestant` varchar(64) NOT NULL DEFAULT '',
  `Action` varchar(64) NOT NULL DEFAULT '',
  `episode` int(2) unsigned NOT NULL,
  `Scorer` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'Team'
CREATE TABLE `Team` (
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `Owner` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;