<?php
/**
 * @package   ImpressPages
 */



namespace Plugin\User\Setup;


class Worker
{

    public function activate()
    {
        $table = ipTable('user');
        $sql = "

CREATE TABLE IF NOT EXISTS $table (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NULL,
  `hash` text NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `resetSecret` varchar(32) DEFAULT NULL,
  `resetTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
      ";
        ipDb()->execute($sql);


        //add title column if not exist
        $checkSql = "
        SELECT
          *
        FROM
          information_schema.COLUMNS
        WHERE
            TABLE_SCHEMA = :database
            AND TABLE_NAME = :table
            AND COLUMN_NAME = :column
        ";


        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'createdAt'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;";
            ipDb()->execute($sql);
        }


        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'lastActiveAt'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `lastActiveAt` timestamp NULL DEFAULT NULL;";
            ipDb()->execute($sql);
        }

        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'deleted'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `deleted` INT(1) NOT NULL DEFAULT 0;";
            ipDb()->execute($sql);
        }

        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'deletedAt'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `deletedAt` timestamp NULL DEFAULT NULL;";
            ipDb()->execute($sql);
        }


        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'deletedAt'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `deletedAt` timestamp NULL DEFAULT NULL;";
            ipDb()->execute($sql);
        }




    }

    public function deactivate()
    {
        //do nothing
    }

    public function remove()
    {
        //users plugin is very important one. We decided not to remove the database even when you remove the plugin. Just in case.
        //If you want, you can remove user table manually.
    }
}
