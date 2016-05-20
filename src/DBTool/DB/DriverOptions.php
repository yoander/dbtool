<?php

namespace DBTool\DB;

class DriverOptions 
{
	const MYSQLDRV = 'mysql';

    const SQLITEDRV = 'sqlite';

    const ERRMODE = \PDO::ATTR_ERRMODE;

    const ERRMODE_EXCEPTION = \PDO::ERRMODE_EXCEPTION;

    const ERRMODE_WARNING = \PDO::ERRMODE_WARNING;

    const ERRMODE_SILENT = \PDO::ERRMODE_SILENT;
}
