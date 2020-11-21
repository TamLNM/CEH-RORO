<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-06-22 07:02:42 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server]TCP Provider: A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 - Invalid query: SELECT DISTINCT "PayFormID", "PayFormName"
FROM "BS_INV_PAY_FORM"
WHERE "PaymentTypeID" =  'TSAU'
ERROR - 2019-06-22 09:50:04 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'FinishDate'. - Invalid query: UPDATE "DT_STOCK" SET "FinishDate" = '2019-06-22 14:50:03'
WHERE "EirNo" =  '19062200001'
ERROR - 2019-06-22 09:51:25 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'FinishDate'. - Invalid query: UPDATE "DT_STOCK" SET "FinishDate" = '2019-06-22 14:51:22'
WHERE "EirNo" =  '19062200001'
ERROR - 2019-06-22 09:58:45 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'rowguid', table 'RORO_DEMO.dbo.BS_GATE'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "BS_GATE" ("rowguid", "GateID", "GateName", "InOut", "ClassID", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES (NULL, 'OUT1', N'Cổng ra 1', '2', '2', 'CEH', 'admin', '2019-06-22 09:58:45', '2019-06-22 09:58:45', 'admin')
ERROR - 2019-06-22 10:03:21 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'rowguid', table 'RORO_DEMO.dbo.BS_GATE'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "BS_GATE" ("rowguid", "GateID", "GateName", "InOut", "ClassID", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES (NULL, 'OUT1', N'Cổng ra 1', '2', '2', 'CEH', 'admin', '2019-06-22 10:03:21', '2019-06-22 10:03:21', 'admin')
ERROR - 2019-06-22 10:04:17 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'rowguid', table 'RORO_DEMO.dbo.BS_GATE'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "BS_GATE" ("rowguid", "GateID", "GateName", "InOut", "ClassID", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES (NULL, 'OUT1', N'Cổng ra 1', '2', '2', 'CEH', 'admin', '2019-06-22 10:04:17', '2019-06-22 10:04:17', 'admin')
ERROR - 2019-06-22 10:06:20 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'rowguid', table 'RORO_DEMO.dbo.BS_GATE'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "BS_GATE" ("rowguid", "GateID", "GateName", "InOut", "ClassID", "YardID", "ModifiedBy", "UpdateTime", "CreateTime", "CreatedBy") VALUES (NULL, 'OUT1', N'CR1', '2', '2', 'CEH', 'admin', '2019-06-22 10:06:20', '2019-06-22 10:06:20', 'admin')
ERROR - 2019-06-22 10:11:34 --> Severity: error --> Exception: syntax error, unexpected '}', expecting end of file D:\xampp\htdocs\roro\application\views\gate.php 507
ERROR - 2019-06-22 10:38:32 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'O'. - Invalid query: SELECT *
FROM "JOB_GATE" "A"
JOIN "DT_STOCK" "B" ON "A"."StockRef" = "B"."rowguid" and "B"."VMStatus" = "O"
ORDER BY "A"."VINNo"
ERROR - 2019-06-22 10:55:01 --> Severity: error --> Exception: syntax error, unexpected ')' D:\xampp\htdocs\roro\application\models\Order_model.php 309
ERROR - 2019-06-22 11:37:36 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'StockRef'. - Invalid query: UPDATE "DT_STOCK" SET "VMStatus" = 'O'
WHERE "StockRef" =  '44B18B88-ADDC-466D-BDEC-D26ABB60C1D6'
ERROR - 2019-06-22 11:37:49 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'StockRef'. - Invalid query: UPDATE "DT_STOCK" SET "VMStatus" = 'O'
WHERE "StockRef" =  '44B18B88-ADDC-466D-BDEC-D26ABB60C1D6'
ERROR - 2019-06-22 12:19:59 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'Block'. - Invalid query: SELECT "B"."rowguid" as "rowguid", "A"."VoyageKey" as "VoyageKey", "A"."EirNo" as "EirNo", "A"."PinCode" as "PinCode", "A"."ClassID" as "ClassID", "A"."BillOfLading" as "BillOfLading", "A"."BookingNo" as "BookingNo", "IssueDate", "ExpDate", "A"."CarWeight" as "CarWeight", "A"."Remark" as "Remark", "B"."IsLocalForeign" as "IsLocalForeign", "A"."VINNo" as "VINNo", "Block", "Bay", "Row", "Tier", "Area", "C"."BrandID" as "BrandID", "BrandName", "C"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."JobModeID" as "JobModeID", "A"."MethodID" as "MethodID", "ETB", "ETD", "C"."POD" as "POD", "C"."FPOD" as "FPOD", "B"."TransitID" as "TransitID", "ShipperName", "F"."InboundVoyage" as "InboundVoyage", "F"."OutboundVoyage" as "OutboundVoyage", "F"."VesselName" as "VesselName", "A"."CusTypeID" as "CusTypeID", "A"."CusID" as "CusID", "A"."PaymentTypeID" as "PaymentTypeID", "A"."InvNo" as "InvNo", "A"."InvDraftNo" as "InvDraftNo", "C"."KeyNo" as "KeyNo", "C"."Sequence" as "Sequence"
FROM "ORD_EIR" "A"
JOIN "DT_STOCK" "B" ON "A"."VoyageKey" = "B"."VoyageKey" and "A"."VINNo" = "B"."VINNo"
JOIN "DT_MANIFEST" "C" ON "B"."VoyageKey" = "C"."VoyageKey" and "B"."VINNo" = "C"."VINNo" and ("B"."BillOfLading" = "C"."BillOfLading" or "B"."BookingNo" = C.BookingNo)
LEFT JOIN "BS_CAR_BRAND" "D" ON "C"."BrandID" = "D"."BrandID"
LEFT JOIN "BS_CAR_TYPE" "E" ON "C"."CarTypeID" = "E"."CarTypeID"
JOIN "DT_VESSEL_VISIT" "F" ON "A"."VoyageKey" = "F"."VoyageKey"
LEFT JOIN "JOB_GATE" "G" ON "A"."VINNo" = "G"."VINNo"
WHERE "A"."VINNo" =  'VINNO02'
ORDER BY "A"."EirNo"
ERROR - 2019-06-22 12:21:16 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Ambiguous column name 'Block'. - Invalid query: SELECT "B"."rowguid" as "rowguid", "A"."VoyageKey" as "VoyageKey", "A"."EirNo" as "EirNo", "A"."PinCode" as "PinCode", "A"."ClassID" as "ClassID", "A"."BillOfLading" as "BillOfLading", "A"."BookingNo" as "BookingNo", "IssueDate", "ExpDate", "A"."CarWeight" as "CarWeight", "A"."Remark" as "Remark", "B"."IsLocalForeign" as "IsLocalForeign", "A"."VINNo" as "VINNo", "Block", "Bay", "Row", "Tier", "Area", "C"."BrandID" as "BrandID", "BrandName", "C"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."JobModeID" as "JobModeID", "A"."MethodID" as "MethodID", "ETB", "ETD", "C"."POD" as "POD", "C"."FPOD" as "FPOD", "B"."TransitID" as "TransitID", "ShipperName", "F"."InboundVoyage" as "InboundVoyage", "F"."OutboundVoyage" as "OutboundVoyage", "F"."VesselName" as "VesselName", "A"."CusTypeID" as "CusTypeID", "A"."CusID" as "CusID", "A"."PaymentTypeID" as "PaymentTypeID", "A"."InvNo" as "InvNo", "A"."InvDraftNo" as "InvDraftNo", "C"."KeyNo" as "KeyNo", "C"."Sequence" as "Sequence", "VehicleNumber"
FROM "ORD_EIR" "A"
JOIN "DT_STOCK" "B" ON "A"."VoyageKey" = "B"."VoyageKey" and "A"."VINNo" = "B"."VINNo"
JOIN "DT_MANIFEST" "C" ON "B"."VoyageKey" = "C"."VoyageKey" and "B"."VINNo" = "C"."VINNo" and ("B"."BillOfLading" = "C"."BillOfLading" or "B"."BookingNo" = C.BookingNo)
LEFT JOIN "BS_CAR_BRAND" "D" ON "C"."BrandID" = "D"."BrandID"
LEFT JOIN "BS_CAR_TYPE" "E" ON "C"."CarTypeID" = "E"."CarTypeID"
JOIN "DT_VESSEL_VISIT" "F" ON "A"."VoyageKey" = "F"."VoyageKey"
LEFT JOIN "JOB_GATE" "G" ON "A"."VINNo" = "G"."VINNo"
WHERE "A"."VINNo" =  'VINNO02'
ORDER BY "A"."EirNo"
ERROR - 2019-06-22 12:21:59 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'Block'. - Invalid query: SELECT "B"."rowguid" as "rowguid", "A"."VoyageKey" as "VoyageKey", "A"."EirNo" as "EirNo", "A"."PinCode" as "PinCode", "A"."ClassID" as "ClassID", "A"."BillOfLading" as "BillOfLading", "A"."BookingNo" as "BookingNo", "IssueDate", "ExpDate", "A"."CarWeight" as "CarWeight", "A"."Remark" as "Remark", "B"."IsLocalForeign" as "IsLocalForeign", "A"."VINNo" as "VINNo", "A"."Block" as "Block", "A"."Bay" as "Bay", "A"."Row" as "Row", "A"."Tier" as "Tier", "A"."Area" as "Area", "C"."BrandID" as "BrandID", "BrandName", "C"."CarTypeID" as "CarTypeID", "CarTypeName", "A"."JobModeID" as "JobModeID", "A"."MethodID" as "MethodID", "ETB", "ETD", "C"."POD" as "POD", "C"."FPOD" as "FPOD", "B"."TransitID" as "TransitID", "ShipperName", "F"."InboundVoyage" as "InboundVoyage", "F"."OutboundVoyage" as "OutboundVoyage", "F"."VesselName" as "VesselName", "A"."CusTypeID" as "CusTypeID", "A"."CusID" as "CusID", "A"."PaymentTypeID" as "PaymentTypeID", "A"."InvNo" as "InvNo", "A"."InvDraftNo" as "InvDraftNo", "C"."KeyNo" as "KeyNo", "C"."Sequence" as "Sequence", "VehicleNumber"
FROM "ORD_EIR" "A"
JOIN "DT_STOCK" "B" ON "A"."VoyageKey" = "B"."VoyageKey" and "A"."VINNo" = "B"."VINNo"
JOIN "DT_MANIFEST" "C" ON "B"."VoyageKey" = "C"."VoyageKey" and "B"."VINNo" = "C"."VINNo" and ("B"."BillOfLading" = "C"."BillOfLading" or "B"."BookingNo" = C.BookingNo)
LEFT JOIN "BS_CAR_BRAND" "D" ON "C"."BrandID" = "D"."BrandID"
LEFT JOIN "BS_CAR_TYPE" "E" ON "C"."CarTypeID" = "E"."CarTypeID"
JOIN "DT_VESSEL_VISIT" "F" ON "A"."VoyageKey" = "F"."VoyageKey"
LEFT JOIN "JOB_GATE" "G" ON "A"."VINNo" = "G"."VINNo"
WHERE "A"."VINNo" =  'VINNO02'
ORDER BY "A"."EirNo"
ERROR - 2019-06-22 12:32:46 --> Severity: Notice --> Undefined index: GateInID D:\xampp\htdocs\roro\application\views\gate.php 504
ERROR - 2019-06-22 12:32:46 --> Severity: Notice --> Undefined index: GateInID D:\xampp\htdocs\roro\application\views\gate.php 504
ERROR - 2019-06-22 12:33:35 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server]TCP Provider: A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 - Invalid query: SELECT CASE WHEN (@@OPTIONS | 256) = @@OPTIONS THEN 1 ELSE 0 END AS qi
ERROR - 2019-06-22 12:33:56 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Cannot insert the value NULL into column 'InOut', table 'RORO_DEMO.dbo.JOB_GATE'; column does not allow nulls. INSERT fails. - Invalid query: INSERT INTO "JOB_GATE" ("StockRef", "VoyageKey", "GateInID", "ClassID", "TransitID", "CusTypeID", "CusID", "EirNo", "InvDraftNo", "InvNo", "PaymentTypeID", "BillOfLading", "BookingNo", "VINNo", "KeyNo", "JobTypeID", "JobModeID", "MethodID", "Sequence", "CarWeight", "Block", "Bay", "Row", "Tier", "Area", "Remark", "VehicleNumber", "YardID", "ModifiedBy", "UpdateTime", "CreatedBy", "CreateTime") VALUES ('44B18B88-ADDC-466D-BDEC-D26ABB60C1D6', 'TEST20195615650', 'IN1', '1', NULL, 'KH_THUSAU', 'KH01', '19062200001', NULL, NULL, 'TSAU', 'BILLOFLOADING01', NULL, 'VINNO02', '0', 'GO', 'LAYN', 'BAI-XE', NULL, '150.00', 'A1', '13', '6', '1', NULL, NULL, '1', 'CEH', 'gate', '2019-06-22 12:33:56', 'gate', '2019-06-22 12:33:56')
ERROR - 2019-06-22 12:51:49 --> Query error: [Microsoft][ODBC Driver 11 for SQL Server][SQL Server]Invalid column name 'VMStatus'. - Invalid query: UPDATE "JOB_YARD" SET "VMStatus" = 'D', "DateOut" = '2019-06-22 17:51:49'
WHERE "VINNo" =  'VINNO02'
AND "EirNo" =  '19062200001'
OR "PinCode" =  '19062200001'
ERROR - 2019-06-22 13:05:43 --> Severity: error --> Exception: Call to undefined method data_model::updateYardDataByGate() D:\xampp\htdocs\roro\application\controllers\Gate.php 131
ERROR - 2019-06-22 13:05:58 --> Severity: error --> Exception: Call to undefined method data_model::updateYardDataByGate() D:\xampp\htdocs\roro\application\controllers\Gate.php 131
ERROR - 2019-06-22 13:06:21 --> Severity: error --> Exception: Call to undefined method order_model::updateYardDataByGate() D:\xampp\htdocs\roro\application\controllers\Gate.php 131
