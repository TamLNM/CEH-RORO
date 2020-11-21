<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-09-25 10:50:34 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Conversion failed when converting date and/or time from character string. - Invalid query: INSERT INTO "TRF_STANDARD" ("TRFCode", "TRFDesc", "MethodID", "TransitID", "JobTypeID", "JobModeID", "ClassID", "CargoTypeID", "Price", "ServiceID", "CarTypeID", "RateID", "VAT", "IncludeVAT", "ApplyDate", "ExpireDate", "Remark", "YardID", "ModifiedBy", "UpdateTime", "CreatedBy", "CreateTime") VALUES ('BC_XD', N'B9.1.1', 'XE-TAU', 'KHOBAI-XE', 'LD', 'XGT', '2', 'HC', '21000', 'RUA', 'SEDAN', 'VND', '0.1', '0', '2019-09-01 00:00:00', '*', NULL, 'CEH', 'admin', '2019-09-25 10:50:34', 'admin', '2019-09-25 10:50:34')
ERROR - 2019-09-25 14:48:15 --> Query error:  - Invalid query: SELECT CASE WHEN (@@OPTIONS | 256) = @@OPTIONS THEN 1 ELSE 0 END AS qi
ERROR - 2019-09-25 14:48:47 --> Query error:  - Invalid query: SELECT CASE WHEN (@@OPTIONS | 256) = @@OPTIONS THEN 1 ELSE 0 END AS qi
ERROR - 2019-09-25 14:49:01 --> Query error:  - Invalid query: SELECT CASE WHEN (@@OPTIONS | 256) = @@OPTIONS THEN 1 ELSE 0 END AS qi
ERROR - 2019-09-25 14:58:11 --> Severity: Notice --> Undefined variable: jobQuayList D:\xampp\htdocs\roro\application\views\tally.php 297
ERROR - 2019-09-25 15:00:43 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server]TCP Provider: A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 - Invalid query: SELECT SUM(B.CargoWeightGetIn) as sumCargoInWeight
FROM "DT_STOCK_BULK" "A"
JOIN "DT_STOCKIN_BULK" "B" ON "A"."rowguid" = "B"."StockRef"
WHERE "A"."BillOfLading" =  'BILLOFLOADING01'
 ORDER BY 1 OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
