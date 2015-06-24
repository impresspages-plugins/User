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
  PRIMARY KEY (`id`)
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

        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'isDeleted'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `isDeleted` INT(1) NOT NULL DEFAULT 0;";
            ipDb()->execute($sql);
        }

        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'deletedAt'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `deletedAt` timestamp NULL DEFAULT NULL;";
            ipDb()->execute($sql);
        }


        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'isVerified'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `isVerified` INT(1) NOT NULL DEFAULT 0;";
            ipDb()->execute($sql);
        } else {
        	$table_schema = current($result);
        	if(is_array($table_schema) && isset($table_schema['COLUMN_TYPE']) && $table_schema['COLUMN_TYPE'] == 'timestamp'){
        		$sql_alter = "ALTER TABLE $table CHANGE `isVerified` `isVerified` INT(1) NOT NULL DEFAULT 0;";
        		$sql_update = "UPDATE $table SET `isVerified` = 1 WHERE `isVerified` > 0;";
        		
        		try {
        			$resultAffected = ipDb()->execute($sql_alter);
        			$resultUpdated = ipDb()->execute($sql_update);
        			ipLog()->info('Updated table schema for user table column "isVerified" from TIMESTAMP to INT(1)', array('affectedRows' => $resultAffected, 'updatedRows' => $resultUpdated));
        		} catch (\Exception $e) {
        			ipLog()->critical('Table schema for user table column "isVerified" could not be updated to INT(1)', array($e->getCode() => $e->getMessage()));
        		}
        	}
        }

        $result = ipDb()->fetchAll($checkSql, array('database' => ipConfig()->database(), 'table' => ipConfig()->tablePrefix() . 'user', 'column' => 'verifiedAt'));
        if (!$result) {
            $sql = "ALTER TABLE $table ADD `verifiedAt` timestamp NULL DEFAULT NULL;";
            ipDb()->execute($sql);
        }

        try {
            ipDb()->execute("DROP INDEX `username` ON $table ");
        } catch (\Exception $e) {
            //ignore. We don't care if index doesn't exist. We will create it over again
        }

        try {
            ipDb()->execute("DROP INDEX `email` ON $table ");
        } catch (\Exception $e) {
            //ignore. We don't care if index doesn't exist. We will create it over again
        }

        ipDb()->execute("ALTER TABLE $table ADD KEY `username` (`username`) ");
        ipDb()->execute("ALTER TABLE $table ADD KEY `email` (`email`) ");

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
