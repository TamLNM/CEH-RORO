<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-08 05:08:01 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'CarTypeEngine'. - Invalid query: INSERT INTO "DT_MANIFEST" ("VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "CarTypeEngine", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "POD", "FPOD", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', 'alert(1)', 'H1', 'SUV', 'Xăng', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2', '3', NULL, 'CEH', 'admin', '2019-03-08 05:08:00', '2019-03-08 05:08:00', 'admin')
ERROR - 2019-03-08 05:08:07 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'CarTypeEngine'. - Invalid query: INSERT INTO "DT_MANIFEST" ("VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "CarTypeEngine", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "POD", "FPOD", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('1201922716031', '1', '1', '1', '1', '1', '1', '1', 'alert(1)', 'H1', 'SUV', 'Xăng', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2', '3', NULL, 'CEH', 'admin', '2019-03-08 05:08:06', '2019-03-08 05:08:06', 'admin')
ERROR - 2019-03-08 05:13:26 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: INSERT INTO "DT_MANIFEST" ("VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "POD", "FPOD", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('2201932162917', '1', '1', 'x', 'x', 'x', 'x', '1', 'alert(1)', 'H1', 'SEDAN', 'Điện', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', '1', '2', '3', NULL, 'CEH', 'admin', '2019-03-08 05:13:26', '2019-03-08 05:13:26', 'admin')
ERROR - 2019-03-08 05:14:15 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: INSERT INTO "DT_MANIFEST" ("VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "POD", "FPOD", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('2201932162917', '1', '1', '1111', '1111', 'x', '1111', '1', 'alert(1)', 'H1', 'SEDAN', 'Điện', '1111', '1111', '1111', 'x', 'x', '1111', '1111', '1111', '1111', 'x', '1', '2', '3', NULL, 'CEH', 'admin', '2019-03-08 05:14:15', '2019-03-08 05:14:15', 'admin')
ERROR - 2019-03-08 05:14:37 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'Sequence', table 'RORO_CEH.dbo.DT_MANIFEST'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "DT_MANIFEST" ("VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "POD", "FPOD", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES ('2201932162917', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'CEH', 'admin', '2019-03-08 05:14:36', '2019-03-08 05:14:36', 'admin')
ERROR - 2019-03-08 05:27:10 --> Severity: error --> Exception: syntax error, unexpected 'if' (T_IF) D:\xampp\htdocs\roro\application\models\Data_model.php 136
ERROR - 2019-03-08 05:27:34 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'STT'. - Invalid query: SELECT "STT", "VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "B"."PortName" as "POLName", "POD", "C"."PortName" as "PODName", "FPOD", "D"."PortName" as "FPODName", "Remark"
FROM "DT_STOCK" "A"
JOIN "BS_PORT" "B" ON "A"."POL" = "B"."PortID"
JOIN "BS_PORT" "C" ON "A"."POD" = "C"."PortID"
JOIN "BS_PORT" "D" ON "A"."FPOD" = "D"."PortID"
WHERE "IsLocalForeign" =  '1'
AND "ClassID" =  '1'
AND "VoyageKey" =  '1201922716031'
ORDER BY "VINNo" ASC
ERROR - 2019-03-08 05:27:40 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'STT'. - Invalid query: SELECT "STT", "VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "B"."PortName" as "POLName", "POD", "C"."PortName" as "PODName", "FPOD", "D"."PortName" as "FPODName", "Remark"
FROM "DT_STOCK" "A"
JOIN "BS_PORT" "B" ON "A"."POL" = "B"."PortID"
JOIN "BS_PORT" "C" ON "A"."POD" = "C"."PortID"
JOIN "BS_PORT" "D" ON "A"."FPOD" = "D"."PortID"
WHERE "IsLocalForeign" =  '1'
AND "ClassID" =  '1'
AND "VoyageKey" =  '2201932162917'
ORDER BY "VINNo" ASC
ERROR - 2019-03-08 05:27:42 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'STT'. - Invalid query: SELECT "STT", "VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "B"."PortName" as "POLName", "POD", "C"."PortName" as "PODName", "FPOD", "D"."PortName" as "FPODName", "Remark"
FROM "DT_STOCK" "A"
JOIN "BS_PORT" "B" ON "A"."POL" = "B"."PortID"
JOIN "BS_PORT" "C" ON "A"."POD" = "C"."PortID"
JOIN "BS_PORT" "D" ON "A"."FPOD" = "D"."PortID"
WHERE "IsLocalForeign" =  '1'
AND "ClassID" =  '1'
AND "VoyageKey" =  '2201932162917'
ORDER BY "VINNo" ASC
ERROR - 2019-03-08 05:28:07 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'JobModeID'. - Invalid query: SELECT "VoyageKey", "ClassID", "IsLocalForeign", "BillOfLading", "BookingNo", "Sequence", "VINNo", "JobModeID", "MethodID", "BrandID", "CarTypeID", "EngineType", "CaseNo", "ModelName", "ChassisNumber", "EngineSerial", "BodyColor", "Interier", "Option", "VonNo", "CarWeight", "KeyNo", "POL", "B"."PortName" as "POLName", "POD", "C"."PortName" as "PODName", "FPOD", "D"."PortName" as "FPODName", "Remark"
FROM "DT_STOCK" "A"
JOIN "BS_PORT" "B" ON "A"."POL" = "B"."PortID"
JOIN "BS_PORT" "C" ON "A"."POD" = "C"."PortID"
JOIN "BS_PORT" "D" ON "A"."FPOD" = "D"."PortID"
WHERE "IsLocalForeign" =  '1'
AND "ClassID" =  '1'
AND "VoyageKey" =  '2201932162917'
ORDER BY "VINNo" ASC
ERROR - 2019-03-08 07:59:19 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php:178) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-08 07:59:19 --> Severity: Error --> Maximum execution time of 30 seconds exceeded D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-03-08 07:59:19 --> Severity: Warning --> Unknown: Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2019-03-08 07:59:19 --> Severity: Warning --> Unknown: Failed to write session data using user defined save handler. (session.save_path: D:\xampp\tmp) Unknown 0
ERROR - 2019-03-08 07:59:19 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php:178) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-08 07:59:19 --> Severity: Error --> Maximum execution time of 30 seconds exceeded D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-03-08 07:59:19 --> Severity: Warning --> Unknown: Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2019-03-08 07:59:19 --> Severity: Warning --> Unknown: Failed to write session data using user defined save handler. (session.save_path: D:\xampp\tmp) Unknown 0
ERROR - 2019-03-08 08:27:27 --> Severity: Notice --> Undefined variable: VINNo D:\xampp\htdocs\roro\application\controllers\Data.php 123
ERROR - 2019-03-08 08:27:27 --> Severity: Notice --> Undefined variable: BillOfLadingORBookingNo D:\xampp\htdocs\roro\application\controllers\Data.php 123
ERROR - 2019-03-08 09:45:01 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: UPDATE "DT_MANIFEST" SET "VoyageKey" = '2201932162917', "ClassID" = '1', "IsLocalForeign" = '2', "BillOfLading" = '123', "BookingNo" = '123', "Sequence" = 'x', "VINNo" = '123', "JobModeID" = '2', "MethodID" = '1', "BrandID" = 'H1', "CarTypeID" = 'SEDAN', "EngineType" = 'Ði?n', "CaseNo" = '123', "ModelName" = '123', "ChassisNumber" = '123', "EngineSerial" = '123', "BodyColor" = '123', "Interier" = '123', "Option" = '123', "VonNo" = '123', "CarWeight" = '123.00', "KeyNo" = '123', "POL" = '1', "POD" = '2', "FPOD" = '3', "Remark" = NULL, "YardID" = 'CEH', "ModifiedBy" = 'admin', "UpdateTime" = '2019-03-08 09:45:01', "CreateTime" = '2019-03-08 09:45:01'
WHERE "VoyageKey" =  '2201932162917'
AND "BillOfLading" =  '123'
AND "BookingNo" =  '123'
AND "VINNo" =  '123'
AND "YardID" =  'CEH'
ERROR - 2019-03-08 09:46:18 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Error converting data type varchar to bigint. - Invalid query: UPDATE "DT_MANIFEST" SET "VoyageKey" = '2201932162917', "ClassID" = '1', "IsLocalForeign" = '2', "BillOfLading" = '3', "BookingNo" = '3', "Sequence" = 'y', "VINNo" = '3', "JobModeID" = '1', "MethodID" = 'alert(1)', "BrandID" = 'H1', "CarTypeID" = 'SUV', "EngineType" = 'Xang', "CaseNo" = '3', "ModelName" = '3', "ChassisNumber" = '3', "EngineSerial" = '3', "BodyColor" = '3', "Interier" = '3', "Option" = '3', "VonNo" = '3', "CarWeight" = '3.00', "KeyNo" = '3', "POL" = '3', "POD" = '3', "FPOD" = '3', "Remark" = NULL, "YardID" = 'CEH', "ModifiedBy" = 'admin', "UpdateTime" = '2019-03-08 09:46:18', "CreateTime" = '2019-03-08 09:46:18'
WHERE "VoyageKey" =  '2201932162917'
AND "BillOfLading" =  '3'
AND "BookingNo" =  '3'
AND "VINNo" =  '3'
AND "YardID" =  'CEH'
ERROR - 2019-03-08 10:32:02 --> Severity: Notice --> Undefined variable: checkitem D:\xampp\htdocs\roro\application\models\Data_model.php 260
ERROR - 2019-03-08 10:32:02 --> Severity: Warning --> Illegal string offset 'BillOfLading' D:\xampp\htdocs\roro\application\models\Data_model.php 261
ERROR - 2019-03-08 10:32:02 --> Severity: Warning --> Illegal string offset 'BookingNo' D:\xampp\htdocs\roro\application\models\Data_model.php 262
ERROR - 2019-03-08 10:32:02 --> Severity: Warning --> Illegal string offset 'VINNo' D:\xampp\htdocs\roro\application\models\Data_model.php 263
ERROR - 2019-03-08 10:32:02 --> Severity: Warning --> Illegal string offset 'YardID' D:\xampp\htdocs\roro\application\models\Data_model.php 264
ERROR - 2019-03-08 10:32:02 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VoyageKey'. - Invalid query: DELETE FROM "DT_VESSEL"
WHERE "VoyageKey" IS NULL
AND "BillOfLading" =  '1'
AND "BookingNo" =  '1'
AND "VINNo" =  '1'
AND "YardID" =  '1'
ERROR - 2019-03-08 10:32:02 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\core\Exceptions.php:271) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-08 10:32:41 --> Severity: Notice --> Undefined variable: checkitem D:\xampp\htdocs\roro\application\models\Data_model.php 260
ERROR - 2019-03-08 10:32:41 --> Severity: Warning --> Illegal string offset 'BillOfLading' D:\xampp\htdocs\roro\application\models\Data_model.php 261
ERROR - 2019-03-08 10:32:41 --> Severity: Warning --> Illegal string offset 'BookingNo' D:\xampp\htdocs\roro\application\models\Data_model.php 262
ERROR - 2019-03-08 10:32:41 --> Severity: Warning --> Illegal string offset 'VINNo' D:\xampp\htdocs\roro\application\models\Data_model.php 263
ERROR - 2019-03-08 10:32:41 --> Severity: Warning --> Illegal string offset 'YardID' D:\xampp\htdocs\roro\application\models\Data_model.php 264
ERROR - 2019-03-08 10:34:00 --> Severity: Warning --> Illegal string offset 'VoyageKey' D:\xampp\htdocs\roro\application\models\Data_model.php 260
ERROR - 2019-03-08 10:34:00 --> Severity: Warning --> Illegal string offset 'BillOfLading' D:\xampp\htdocs\roro\application\models\Data_model.php 261
ERROR - 2019-03-08 10:34:00 --> Severity: Warning --> Illegal string offset 'BookingNo' D:\xampp\htdocs\roro\application\models\Data_model.php 262
ERROR - 2019-03-08 10:34:00 --> Severity: Warning --> Illegal string offset 'VINNo' D:\xampp\htdocs\roro\application\models\Data_model.php 263
ERROR - 2019-03-08 10:34:00 --> Severity: Warning --> Illegal string offset 'YardID' D:\xampp\htdocs\roro\application\models\Data_model.php 264
ERROR - 2019-03-08 11:13:00 --> Severity: Notice --> Array to string conversion D:\xampp\htdocs\roro\application\models\Data_model.php 266
ERROR - 2019-03-08 11:49:45 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 271
