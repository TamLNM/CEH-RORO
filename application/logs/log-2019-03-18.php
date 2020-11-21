<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-18 03:19:57 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\database\drivers\pdo\pdo_driver.php:138) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-18 03:19:57 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\database\drivers\pdo\pdo_driver.php:138) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-18 03:19:57 --> Severity: Error --> Maximum execution time of 30 seconds exceeded D:\xampp\htdocs\roro\system\database\drivers\pdo\pdo_driver.php 138
ERROR - 2019-03-18 03:19:57 --> Severity: Error --> Maximum execution time of 30 seconds exceeded D:\xampp\htdocs\roro\system\database\drivers\pdo\pdo_driver.php 138
ERROR - 2019-03-18 03:32:45 --> Severity: Notice --> Undefined variable: paymentFormList D:\xampp\htdocs\roro\application\views\common\payment_form.php 60
ERROR - 2019-03-18 03:33:06 --> Severity: Notice --> Undefined variable: paymentFormList D:\xampp\htdocs\roro\application\views\common\payment_form.php 60
ERROR - 2019-03-18 03:34:02 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 03:34:24 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\vessel.php 327
ERROR - 2019-03-18 03:37:15 --> Severity: Notice --> Undefined variable: paymentFormList D:\xampp\htdocs\roro\application\views\common\payment_form.php 60
ERROR - 2019-03-18 03:38:16 --> Severity: Notice --> Undefined variable: paymentFormList D:\xampp\htdocs\roro\application\views\common\payment_form.php 60
ERROR - 2019-03-18 03:39:05 --> Severity: Notice --> Undefined variable: paymentFormList D:\xampp\htdocs\roro\application\views\common\payment_form.php 60
ERROR - 2019-03-18 03:41:44 --> Severity: Notice --> Undefined variable: paymentFormList D:\xampp\htdocs\roro\application\views\common\payment_form.php 60
ERROR - 2019-03-18 03:49:57 --> 404 Page Not Found: 
ERROR - 2019-03-18 03:53:59 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 03:54:32 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 03:54:54 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 03:54:57 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 03:56:08 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\vessel.php 327
ERROR - 2019-03-18 03:56:29 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 03:56:47 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 03:56:57 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\vessel.php 327
ERROR - 2019-03-18 03:59:37 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:07:13 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:17:47 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'BrandID'. - Invalid query: SELECT "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "CarTypeID", "EngineType", "POL", "POD", "FPOD", "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "B"."BrandID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 04:19:31 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'BrandID'. - Invalid query: SELECT "VesselID", "VesselName", "B"."BrandID" as "BrandID", "BrandName", "CarTypeID", "EngineType", "POL", "POD", "FPOD", "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "B"."BrandID" = "B"."BrandID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 04:19:57 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'Rem'. - Invalid query: SELECT "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "CarTypeID", "EngineType", "POL", "POD", "FPOD", "Rem"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 04:20:04 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'Remark'. - Invalid query: SELECT "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "CarTypeID", "EngineType", "POL", "POD", "FPOD", "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 04:20:17 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:22:44 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:31:09 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:31:55 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:37:08 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:38:20 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:38:33 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:38:44 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:38:49 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:39:44 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:39:50 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\vessel.php 327
ERROR - 2019-03-18 04:40:14 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\vessel.php 327
ERROR - 2019-03-18 04:40:25 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 04:42:38 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:43:20 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:43:55 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:44:12 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:44:32 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:44:45 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:44:58 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:45:07 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:45:26 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:45:33 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:45:47 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:46:00 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:46:30 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:46:43 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:47:02 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:47:52 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:49:28 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:49:44 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:49:45 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:51:13 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:52:17 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:55:52 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:56:26 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:56:52 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:57:56 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:58:56 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 04:59:41 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:05:49 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:06:36 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:07:30 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:07:46 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:08:01 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:08:41 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:09:17 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:11:08 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:12:28 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:13:02 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:13:44 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:14:09 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:18:22 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:18:58 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:19:41 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:20:15 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:22:41 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:22:55 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:23:09 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:26:50 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'EngineType'. - Invalid query: SELECT "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "D"."PortName" as "POLName", "POD", "E"."PortName" as "PODName", "FPOD", "E"."PortName" as "FPODName", "A"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 05:28:09 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'EngineType'. - Invalid query: SELECT "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "D"."PortName" as "POLName", "POD", "E"."PortName" as "PODName", "FPOD", "E"."PortName" as "FPODName", "A"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 05:28:12 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'EngineType'. - Invalid query: SELECT "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "D"."PortName" as "POLName", "POD", "E"."PortName" as "PODName", "FPOD", "E"."PortName" as "FPODName", "A"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 05:28:53 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:30:33 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:30:45 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:32:21 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:34:43 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:35:39 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:36:33 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:39:17 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:39:19 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:39:33 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:39:46 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:40:01 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:41:10 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:41:47 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:45:37 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 05:55:43 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 76
ERROR - 2019-03-18 05:55:54 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 76
ERROR - 2019-03-18 05:56:21 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 76
ERROR - 2019-03-18 05:57:33 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 76
ERROR - 2019-03-18 07:02:46 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 76
ERROR - 2019-03-18 07:02:47 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 76
ERROR - 2019-03-18 07:05:25 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 07:09:14 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 07:11:25 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 07:11:38 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'BackgroundColor'. - Invalid query: INSERT INTO "BS_YP_COLOR" ("VesselID", "BrandID", "CarTypeID", "EngineType", "POL", "POD", "FPOD", "BackgroundColor", "ForeColor", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreatedBy", "CreateTime") VALUES ('1', 'H1', 'SEDAN', 'Ði?n', '2', '1', '1', 'RED', 'BLACK', NULL, 'CEH', 'admin', '2019-03-18 07:11:38', 'admin', '2019-03-18 07:11:38')
ERROR - 2019-03-18 07:12:52 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 07:13:17 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'Remark', table 'RORO_CEH.dbo.BS_YP_COLOR'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "BS_YP_COLOR" ("VesselID", "BrandID", "CarTypeID", "EngineType", "POL", "POD", "FPOD", "BackColor", "ForeColor", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreatedBy", "CreateTime") VALUES ('1', 'H1', 'SEDAN', 'Ði?n', '3', '2', '1', 'White', 'Black', NULL, 'CEH', 'admin', '2019-03-18 07:13:17', 'admin', '2019-03-18 07:13:17')
ERROR - 2019-03-18 07:14:15 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 72
ERROR - 2019-03-18 07:22:22 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid object name 'BS_COLOR'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "A"."VesselID" ASC
ERROR - 2019-03-18 07:22:38 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "A"."VesselID" ASC
ERROR - 2019-03-18 07:23:32 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "H"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "A"."VesselID" ASC
ERROR - 2019-03-18 07:23:48 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "H"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "A"."VesselID" ASC
ERROR - 2019-03-18 07:25:23 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 07:25:50 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 07:25:53 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 07:25:57 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ERROR - 2019-03-18 07:26:05 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "VesselID" ASC
ERROR - 2019-03-18 07:26:34 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ERROR - 2019-03-18 07:27:21 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VesselID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "A"."POL" as "POL", "D"."PortName" as "POLName", "A"."POD" as "POD", "E"."PortName" as "PODName", "A"."FPOD" as "FPOD", "E"."PortName" as "FPODName", "BackColor", "ForeColor", "H"."Remark" as "Remark"
FROM "DT_MANIFEST" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VoyageKey" = "B"."VoyageKey"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_PORT" "D" ON "POL" = "D"."PortID"
JOIN "BS_PORT" "E" ON "POD" = "E"."PortID"
JOIN "BS_PORT" "F" ON "FPOD" = "F"."PortID"
JOIN "BS_CAR_TYPE" "G" ON "A"."CarTypeID" = "G"."CarTypeID"
JOIN "BS_YP_COLOR" "H" ON "A"."VesselID" = "H"."VesselID"
ORDER BY "A"."VesselID" ASC
ERROR - 2019-03-18 07:29:11 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 71
ERROR - 2019-03-18 07:29:25 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 73
ERROR - 2019-03-18 07:29:25 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\color.php 73
ERROR - 2019-03-18 07:29:44 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 73
ERROR - 2019-03-18 07:29:44 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\color.php 73
ERROR - 2019-03-18 07:29:50 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\color.php 73
ERROR - 2019-03-18 07:29:50 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\color.php 73
ERROR - 2019-03-18 07:37:18 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'CarTypeID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "E"."PortName" as "POLName", "POD", "F"."PortName" as "PODName", "FPOD", "G"."PortName" as "FPODName", "BackColor", "ForeColor", "Remark"
FROM "BS_YP_COLOR" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VesselID" = "B"."VesselID"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_CAR_TYPE" "D" ON "A"."CarTypeID" = "C"."CarTypeID"
JOIN "PORT" "E" ON "POL" = "E"."PortID"
JOIN "PORT" "F" ON "POD" = "F"."PortID"
JOIN "PORT" "G" ON "FPOD" = "G"."PortID"
ERROR - 2019-03-18 07:37:25 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'CarTypeID'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "E"."PortName" as "POLName", "POD", "F"."PortName" as "PODName", "FPOD", "G"."PortName" as "FPODName", "BackColor", "ForeColor", "Remark"
FROM "BS_YP_COLOR" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VesselID" = "B"."VesselID"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_CAR_TYPE" "D" ON "A"."CarTypeID" = "C"."CarTypeID"
JOIN "PORT" "E" ON "POL" = "E"."PortID"
JOIN "PORT" "F" ON "POD" = "F"."PortID"
JOIN "PORT" "G" ON "FPOD" = "G"."PortID"
ERROR - 2019-03-18 07:38:01 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid object name 'PORT'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "E"."PortName" as "POLName", "POD", "F"."PortName" as "PODName", "FPOD", "G"."PortName" as "FPODName", "BackColor", "ForeColor", "Remark"
FROM "BS_YP_COLOR" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VesselID" = "B"."VesselID"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_CAR_TYPE" "D" ON "A"."CarTypeID" = "D"."CarTypeID"
JOIN "PORT" "E" ON "POL" = "E"."PortID"
JOIN "PORT" "F" ON "POD" = "F"."PortID"
JOIN "PORT" "G" ON "FPOD" = "G"."PortID"
ERROR - 2019-03-18 07:38:16 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'EngineType'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "EngineType", "POL", "E"."PortName" as "POLName", "POD", "F"."PortName" as "PODName", "FPOD", "G"."PortName" as "FPODName", "BackColor", "ForeColor", "Remark"
FROM "BS_YP_COLOR" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VesselID" = "B"."VesselID"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_CAR_TYPE" "D" ON "A"."CarTypeID" = "D"."CarTypeID"
JOIN "BS_PORT" "E" ON "POL" = "E"."PortID"
JOIN "BS_PORT" "F" ON "POD" = "F"."PortID"
JOIN "BS_PORT" "G" ON "FPOD" = "G"."PortID"
ERROR - 2019-03-18 07:38:27 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'Remark'. - Invalid query: SELECT "A"."VesselID" as "VesselID", "VesselName", "A"."BrandID" as "BrandID", "BrandName", "A"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."EngineType" as "EngineType", "POL", "E"."PortName" as "POLName", "POD", "F"."PortName" as "PODName", "FPOD", "G"."PortName" as "FPODName", "BackColor", "ForeColor", "Remark"
FROM "BS_YP_COLOR" "A"
JOIN "DT_VESSEL_VISIT" "B" ON "A"."VesselID" = "B"."VesselID"
JOIN "BS_CAR_BRAND" "C" ON "A"."BrandID" = "C"."BrandID"
JOIN "BS_CAR_TYPE" "D" ON "A"."CarTypeID" = "D"."CarTypeID"
JOIN "BS_PORT" "E" ON "POL" = "E"."PortID"
JOIN "BS_PORT" "F" ON "POD" = "F"."PortID"
JOIN "BS_PORT" "G" ON "FPOD" = "G"."PortID"
ERROR - 2019-03-18 07:44:30 --> 404 Page Not Found: 
ERROR - 2019-03-18 08:45:04 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ClasName'. - Invalid query: SELECT "ClassID", "ClasName"
FROM "BS_CLASS" "A"
ORDER BY "ClasID" ASC
ERROR - 2019-03-18 08:45:12 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ClasID'. - Invalid query: SELECT "ClassID", "ClassName"
FROM "BS_CLASS" "A"
ORDER BY "ClasID" ASC
ERROR - 2019-03-18 09:10:08 --> Severity: error --> Exception: Call to undefined method common_model::loadAllColYard() D:\xampp\htdocs\roro\application\controllers\Common.php 1751
ERROR - 2019-03-18 09:14:54 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 54
ERROR - 2019-03-18 09:15:20 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 54
ERROR - 2019-03-18 09:15:58 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 54
ERROR - 2019-03-18 09:21:05 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:21:15 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:26:15 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:27:22 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:27:34 --> Severity: Notice --> Undefined index: YardID D:\xampp\htdocs\roro\application\models\Common_model.php 2508
ERROR - 2019-03-18 09:27:34 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'ClassID'. - Invalid query: INSERT INTO "BS_YARD" ("ClassID", "ClassName", "ClasName", "ModifiedBy", "UpdateTime", "CreatedBy", "CreateTime") VALUES ('Y1', '1', '1', 'admin', '2019-03-18 09:27:34', 'admin', '2019-03-18 09:27:34')
ERROR - 2019-03-18 09:29:34 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:31:23 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:33:27 --> Severity: Notice --> Undefined variable: classList D:\xampp\htdocs\roro\application\views\common\yard.php 59
ERROR - 2019-03-18 09:57:16 --> Severity: Notice --> Undefined variable: yardList D:\xampp\htdocs\roro\application\views\common\yard.php 58
ERROR - 2019-03-18 10:01:47 --> Severity: Notice --> Undefined variable: carBrandList D:\xampp\htdocs\roro\application\views\common\block.php 63
ERROR - 2019-03-18 10:11:20 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 10:15:59 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 10:17:16 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 60
ERROR - 2019-03-18 10:17:16 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 61
ERROR - 2019-03-18 10:17:16 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 61
ERROR - 2019-03-18 10:17:56 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 61
ERROR - 2019-03-18 10:17:56 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 62
ERROR - 2019-03-18 10:17:56 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 62
ERROR - 2019-03-18 10:18:29 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 61
ERROR - 2019-03-18 10:18:29 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 62
ERROR - 2019-03-18 10:18:29 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 62
ERROR - 2019-03-18 10:19:04 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 62
ERROR - 2019-03-18 10:19:04 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 63
ERROR - 2019-03-18 10:19:04 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 63
ERROR - 2019-03-18 10:19:31 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 62
ERROR - 2019-03-18 10:19:31 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 63
ERROR - 2019-03-18 10:19:31 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 63
ERROR - 2019-03-18 10:21:20 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 10:21:21 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 64
ERROR - 2019-03-18 10:21:21 --> Severity: Notice --> Undefined variable: vesselList D:\xampp\htdocs\roro\application\views\common\block.php 65
ERROR - 2019-03-18 10:21:21 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 65
ERROR - 2019-03-18 10:41:58 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 11:23:22 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 11:33:14 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 11:37:39 --> Severity: Notice --> Undefined variable: vesselVisitList D:\xampp\htdocs\roro\application\views\common\vessel_visit.php 249
ERROR - 2019-03-18 14:04:48 --> Severity: Notice --> Undefined index: Tier D:\xampp\htdocs\roro\application\models\Common_model.php 2568
ERROR - 2019-03-18 14:04:48 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'Tier', table 'RORO_CEH.dbo.BS_YP_BLOCK'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "BS_YP_BLOCK" ("YardID", "Block", "Bay", "Row", "Capacity", "ModifiedBy", "UpdateTime", "CreatedBy", "CreateTime") VALUES ('DN1', '1', '1', '1', '1', 'admin', '2019-03-18 14:04:47', 'admin', '2019-03-18 14:04:47')
ERROR - 2019-03-18 14:12:24 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:19:16 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php:178) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-18 14:19:16 --> Severity: Error --> Maximum execution time of 30 seconds exceeded D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-03-18 14:19:16 --> Severity: Warning --> Unknown: Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2019-03-18 14:19:16 --> Severity: Warning --> Unknown: Failed to write session data using user defined save handler. (session.save_path: D:\xampp\tmp) Unknown 0
ERROR - 2019-03-18 14:19:16 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php:178) D:\xampp\htdocs\roro\system\core\Common.php 570
ERROR - 2019-03-18 14:19:16 --> Severity: Error --> Maximum execution time of 30 seconds exceeded D:\xampp\htdocs\roro\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-03-18 14:19:16 --> Severity: Warning --> Unknown: Cannot call session save handler in a recursive manner Unknown 0
ERROR - 2019-03-18 14:19:16 --> Severity: Warning --> Unknown: Failed to write session data using user defined save handler. (session.save_path: D:\xampp\tmp) Unknown 0
ERROR - 2019-03-18 14:20:20 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:21:44 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:23:16 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:23:33 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:24:55 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:25:16 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:27:06 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:27:56 --> 404 Page Not Found: 
ERROR - 2019-03-18 14:28:36 --> Severity: Notice --> Undefined variable: yardList D:\xampp\htdocs\roro\application\views\common\block.php 63
ERROR - 2019-03-18 14:28:36 --> Severity: Notice --> Undefined variable: yardList D:\xampp\htdocs\roro\application\views\common\block.php 64
ERROR - 2019-03-18 14:28:36 --> Severity: Warning --> Invalid argument supplied for foreach() D:\xampp\htdocs\roro\application\views\common\block.php 64
ERROR - 2019-03-18 14:33:09 --> Severity: Notice --> Use of undefined constant YardID - assumed 'YardID' D:\xampp\htdocs\roro\application\models\Common_model.php 2820
