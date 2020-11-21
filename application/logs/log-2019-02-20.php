<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-02-20 04:58:50 --> 404 Page Not Found: 
ERROR - 2019-02-20 04:58:53 --> 404 Page Not Found: 
ERROR - 2019-02-20 04:59:14 --> 404 Page Not Found: 
ERROR - 2019-02-20 05:08:42 --> 404 Page Not Found: 
ERROR - 2019-02-20 05:09:02 --> 404 Page Not Found: 
ERROR - 2019-02-20 05:09:04 --> 404 Page Not Found: 
ERROR - 2019-02-20 05:09:26 --> 404 Page Not Found: 
ERROR - 2019-02-20 05:09:51 --> 404 Page Not Found: 
ERROR - 2019-02-20 05:47:23 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server]TCP Provider: A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 - Invalid query: SELECT CASE WHEN (@@OPTIONS | 256) = @@OPTIONS THEN 1 ELSE 0 END AS qi
ERROR - 2019-02-20 07:19:52 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'JobModeID'. - Invalid query: SELECT "JobModeID"
FROM "BS_PORT"
WHERE "JobModeID" =  '1'
AND "YardID" =  'CEH'
 ORDER BY 1 OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
ERROR - 2019-02-20 07:20:24 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'CustomJobType'. - Invalid query: INSERT INTO "BS_JOB_MODE" ("ClassID", "TransitID", "InOut", "JobModeID", "JobModeName", "CustomJobType", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('Nhập', '1', 'Ra', '1', N'1', '1', NULL, 'CEH', 'admin', '2019-02-20 07:20:23', '2019-02-20 07:20:23', 'admin')
ERROR - 2019-02-20 07:21:52 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Conversion failed when converting the varchar value 'Xuât' to data type tinyint. - Invalid query: INSERT INTO "BS_JOB_MODE" ("ClassID", "TransitID", "InOut", "JobModeID", "JobModeName", "CustomsJobType", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('Xuât', '1', 'Ra', '1', N'1', '1', N'1', 'CEH', 'admin', '2019-02-20 07:21:52', '2019-02-20 07:21:52', 'admin')
ERROR - 2019-02-20 07:32:07 --> Severity: error --> Exception: syntax error, unexpected end of file D:\xampp\htdocs\roro\application\views\common\job_modes.php 264
ERROR - 2019-02-20 07:34:46 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'CustomJobType'. - Invalid query: SELECT "ClassID", "TransitID", "InOut", "JobModeID", "JobModeName", "CustomJobType", "Remark"
FROM "BS_JOB_MODE"
ORDER BY "JobModeID" ASC
ERROR - 2019-02-20 07:35:01 --> Severity: error --> Exception: syntax error, unexpected end of file D:\xampp\htdocs\roro\application\views\common\job_modes.php 264
ERROR - 2019-02-20 07:46:55 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'PortID'. - Invalid query: DELETE FROM "BS_JOB_MODE"
WHERE "PortID" =  '1'
ERROR - 2019-02-20 08:04:04 --> 404 Page Not Found: 
ERROR - 2019-02-20 08:05:04 --> Severity: error --> Exception: syntax error, unexpected 'vụ' (T_STRING) D:\xampp\htdocs\roro\application\controllers\Common.php 233
ERROR - 2019-02-20 08:06:20 --> Severity: error --> Exception: syntax error, unexpected 'vụ' (T_STRING) D:\xampp\htdocs\roro\application\controllers\Common.php 233
ERROR - 2019-02-20 08:06:21 --> Severity: error --> Exception: syntax error, unexpected 'vụ' (T_STRING) D:\xampp\htdocs\roro\application\controllers\Common.php 233
ERROR - 2019-02-20 08:33:43 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ServiceID'. - Invalid query: UPDATE "BS_JOB_MODE" SET "ServiceID" = '1', "ServiceName" = 'Dịch vu 1', "JobModeID" = '2', "IsQuayJob" = '0', "IsYardJob" = '0', "IsGateJob" = '0', "YardID" = 'CEH', "ModifiedBy" = 'admin', "UpdateTime" = '2019-02-20 08:33:43', "CreateTime" = '2019-02-20 08:33:43'
WHERE "JobModeID" =  '2'
ERROR - 2019-02-20 08:36:38 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ServiceID'. - Invalid query: UPDATE "BS_JOB_MODE" SET "ServiceID" = '11', "ServiceName" = '11', "JobModeID" = '2', "IsQuayJob" = '0', "IsYardJob" = '0', "IsGateJob" = '0', "YardID" = 'CEH', "ModifiedBy" = 'admin', "UpdateTime" = '2019-02-20 08:36:38', "CreateTime" = '2019-02-20 08:36:38'
WHERE "JobModeID" =  '2'
ERROR - 2019-02-20 08:36:52 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ServiceID'. - Invalid query: UPDATE "BS_JOB_MODE" SET "ServiceID" = '11', "ServiceName" = '11', "JobModeID" = '2', "IsQuayJob" = '0', "IsYardJob" = '0', "IsGateJob" = '0', "YardID" = 'CEH', "ModifiedBy" = 'admin', "UpdateTime" = '2019-02-20 08:36:52', "CreateTime" = '2019-02-20 08:36:52'
WHERE "JobModeID" =  '2'
ERROR - 2019-02-20 08:59:14 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server]Session Provider: Physical connection is not usable [xFFFFFFFF].  - Invalid query: SELECT *
FROM "SYS_MENUS"
ERROR - 2019-02-20 09:19:20 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ServiceID'. - Invalid query: SELECT "ServiceID", "ServiceName", "A"."JobModeID", "IsQuayJob", "IsYardJob", "IsGateJob"
FROM "BS_JOB_MODE" "A"
JOIN "BS_JOB_MODE" "B" ON "A"."JobModeID" = "B"."JobModeID"
WHERE "A"."YardID" =  'CEH'
ORDER BY "JobModeID" ASC
ERROR - 2019-02-20 09:21:03 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ServiceID'. - Invalid query: SELECT "ServiceID", "ServiceName", "A"."JobModeID", "IsQuayJob", "IsYardJob", "IsGateJob"
FROM "BS_JOB_MODE" "A"
JOIN "BS_JOB_MODE" "B" ON "A"."JobModeID" = "B"."JobModeID"
WHERE "A"."YardID" =  'CEH'
ORDER BY "ServiceID" ASC
ERROR - 2019-02-20 09:23:51 --> Severity: Notice --> Undefined index: JobModeName D:\xampp\htdocs\roro\application\views\common\services.php 75
ERROR - 2019-02-20 09:23:51 --> Severity: Notice --> Undefined index: JobModeName D:\xampp\htdocs\roro\application\views\common\services.php 75
ERROR - 2019-02-20 09:23:51 --> Severity: Notice --> Undefined index: JobModeName D:\xampp\htdocs\roro\application\views\common\services.php 75
ERROR - 2019-02-20 09:23:51 --> Severity: Notice --> Undefined index: JobModeName D:\xampp\htdocs\roro\application\views\common\services.php 75
ERROR - 2019-02-20 09:23:51 --> Severity: Notice --> Undefined index: JobModeName D:\xampp\htdocs\roro\application\views\common\services.php 75
ERROR - 2019-02-20 10:00:09 --> 404 Page Not Found: 
ERROR - 2019-02-20 10:03:44 --> Severity: Notice --> Undefined variable: servicesList D:\xampp\htdocs\roro\application\views\common\services.php 67
ERROR - 2019-02-20 10:06:17 --> Severity: Notice --> Undefined variable: servicesList D:\xampp\htdocs\roro\application\views\common\services.php 67
ERROR - 2019-02-20 10:06:41 --> Severity: Notice --> Undefined variable: servicesList D:\xampp\htdocs\roro\application\views\common\services.php 67
ERROR - 2019-02-20 10:29:13 --> Severity: Notice --> Undefined index: ServiceID D:\xampp\htdocs\roro\application\models\Common_model.php 653
ERROR - 2019-02-20 10:29:13 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'JobTypeID'. - Invalid query: INSERT INTO "BS_SERVICE" ("JobTypeID", "JobTypeName", "MoveType", "IsQuayJob", "IsYardJob", "IsGateJob", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('1', '1', '0', '1', '0', '1', 'CEH', 'admin', '2019-02-20 10:29:13', '2019-02-20 10:29:13', 'admin')
ERROR - 2019-02-20 10:30:20 --> Severity: Notice --> Undefined index: ServiceID D:\xampp\htdocs\roro\application\models\Common_model.php 653
ERROR - 2019-02-20 10:30:20 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'JobTypeID'. - Invalid query: INSERT INTO "BS_SERVICE" ("JobTypeID", "JobTypeName", "MoveType", "IsQuayJob", "IsYardJob", "IsGateJob", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('1', '1', '0', '1', '0', '1', 'CEH', 'admin', '2019-02-20 10:30:20', '2019-02-20 10:30:20', 'admin')
ERROR - 2019-02-20 10:39:34 --> Severity: Notice --> Undefined index: ClassID D:\xampp\htdocs\roro\application\views\common\job_types.php 65
ERROR - 2019-02-20 10:39:34 --> Severity: Notice --> Undefined index: ClassID D:\xampp\htdocs\roro\application\views\common\job_types.php 69
ERROR - 2019-02-20 11:06:19 --> 404 Page Not Found: 
ERROR - 2019-02-20 11:37:07 --> 404 Page Not Found: 
