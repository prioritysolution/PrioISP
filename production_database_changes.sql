-- PrioISP production database changes
-- Run once on the production database (Workbench or mysql client).
-- Safe to run again: columns and menus are skipped if they already exist.
-- Procedures are replaced with the versions running on the local database.
-- Do not copy local user ids. Counter users who already have Due Register
-- are granted the Extra Amount menu on this server.

-- ---------------------------------------------------------------------------
-- 1. Columns
-- ---------------------------------------------------------------------------

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'mst_customer' AND COLUMN_NAME = 'Advance_Amt') = 0,
    'ALTER TABLE mst_customer ADD COLUMN Advance_Amt decimal(8,2) NOT NULL DEFAULT 0.00 AFTER Due_Amount',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_renewal' AND COLUMN_NAME = 'Extra_Amt') = 0,
    'ALTER TABLE trans_renewal ADD COLUMN Extra_Amt decimal(8,2) NOT NULL DEFAULT 0.00 AFTER OTT_Amt',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_renewal' AND COLUMN_NAME = 'Advance_Adj') = 0,
    'ALTER TABLE trans_renewal ADD COLUMN Advance_Adj decimal(8,2) NOT NULL DEFAULT 0.00 AFTER Extra_Amt',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_renewal_log' AND COLUMN_NAME = 'Extra_Amt') = 0,
    'ALTER TABLE trans_renewal_log ADD COLUMN Extra_Amt decimal(8,2) NOT NULL DEFAULT 0.00',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_renewal_log' AND COLUMN_NAME = 'Advance_Adj') = 0,
    'ALTER TABLE trans_renewal_log ADD COLUMN Advance_Adj decimal(8,2) NOT NULL DEFAULT 0.00',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ---------------------------------------------------------------------------
-- 2. Advance receipts
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `trans_advance` (
  `Advance_Id` bigint NOT NULL AUTO_INCREMENT,
  `Cust_Id` int NOT NULL,
  `Receipt_No` varchar(200) NOT NULL,
  `Receipt_Date` date DEFAULT NULL,
  `Amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `Mode_Id` tinyint DEFAULT NULL,
  `Txn_Id` varchar(75) DEFAULT NULL,
  `Counter_Id` smallint DEFAULT NULL,
  `Remarks` varchar(150) DEFAULT NULL,
  `Created_By` int DEFAULT NULL,
  `Created_On` datetime DEFAULT CURRENT_TIMESTAMP,
  `Plan_Id` int DEFAULT NULL,
  `Renew_From` date DEFAULT NULL,
  `Renew_Upto` date DEFAULT NULL,
  PRIMARY KEY (`Advance_Id`),
  KEY `idx_adv_cust` (`Cust_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_advance' AND COLUMN_NAME = 'Plan_Id') = 0,
    'ALTER TABLE trans_advance ADD COLUMN Plan_Id int DEFAULT NULL',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_advance' AND COLUMN_NAME = 'Renew_From') = 0,
    'ALTER TABLE trans_advance ADD COLUMN Renew_From date DEFAULT NULL',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql = IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS
      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'trans_advance' AND COLUMN_NAME = 'Renew_Upto') = 0,
    'ALTER TABLE trans_advance ADD COLUMN Renew_Upto date DEFAULT NULL',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

UPDATE trans_advance a
JOIN mst_customer c ON c.Cust_Id = a.Cust_Id
SET a.Plan_Id = c.Package_Id
WHERE a.Plan_Id IS NULL;

UPDATE trans_advance a
JOIN mst_customer c ON c.Cust_Id = a.Cust_Id
SET a.Renew_From = c.Renew_From
WHERE a.Renew_From IS NULL;

UPDATE trans_advance a
JOIN mst_customer c ON c.Cust_Id = a.Cust_Id
SET a.Renew_Upto = c.Renew_Upto
WHERE a.Renew_Upto IS NULL;

-- ---------------------------------------------------------------------------
-- 3. Payment delete log, and payment text collation (error 1267)
-- ---------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `trans_renewal_payment_log` (
  `Log_Id` bigint NOT NULL AUTO_INCREMENT,
  `Payment_Id` bigint DEFAULT NULL,
  `Receipt_No` varchar(200) DEFAULT NULL,
  `Renewal_Id` bigint DEFAULT NULL,
  `Cust_Id` int DEFAULT NULL,
  `Receipt_Date` date DEFAULT NULL,
  `Mode_Id` tinyint DEFAULT NULL,
  `Paid_Amt` decimal(8,2) NOT NULL DEFAULT 0.00,
  `Txn_Id` varchar(75) DEFAULT NULL,
  `Counter_Id` smallint DEFAULT NULL,
  `Created_By` int DEFAULT NULL,
  `Created_On` datetime DEFAULT NULL,
  `Deleted_By` int DEFAULT NULL,
  `Deleted_On` datetime DEFAULT NULL,
  PRIMARY KEY (`Log_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `trans_renewal_payment`
  MODIFY `Receipt_No` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  MODIFY `Txn_Id` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;

-- ---------------------------------------------------------------------------
-- 4. Extra Amount menu
--    Admin sees Is_Admin = 1 immediately.
--    Counter users who already have Due Register get the user menu.
-- ---------------------------------------------------------------------------

INSERT INTO mst_menus (Menu_Id, Menu_Name, SubMenu_Id, SubMenu_Name, Icon, Route, Is_Active, Is_Admin)
SELECT 12, NULL,
       (SELECT COALESCE(MAX(m.SubMenu_Id), 0) + 1 FROM mst_menus m WHERE m.Menu_Id = 12),
       'Extra Amount', NULL, 'admin.report.extra.register', 1, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM mst_menus WHERE Route = 'admin.report.extra.register');

INSERT INTO mst_menus (Menu_Id, Menu_Name, SubMenu_Id, SubMenu_Name, Icon, Route, Is_Active, Is_Admin)
SELECT 6, NULL,
       (SELECT COALESCE(MAX(m.SubMenu_Id), 0) + 1 FROM mst_menus m WHERE m.Menu_Id = 6),
       'Extra Amount', NULL, 'report.extra.register', 1, 0
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM mst_menus WHERE Route = 'report.extra.register');

INSERT INTO mst_user_menu (User_Id, Menu_Sl)
SELECT um.User_Id, extra.Menu_Sl
FROM mst_user_menu um
JOIN mst_menus due ON due.Menu_Sl = um.Menu_Sl AND due.Route = 'report.due.register'
JOIN mst_menus extra ON extra.Route = 'report.extra.register'
WHERE NOT EXISTS (
    SELECT 1 FROM mst_user_menu x
    WHERE x.User_Id = um.User_Id AND x.Menu_Sl = extra.Menu_Sl
);

-- ---------------------------------------------------------------------------
-- 5. Procedures (replaced below)
--    usp_collectPayment
--    usp_getLastBill
--    usp_getRenewalRegister
--    usp_getCounterWiseCollection
--    usp_getCustomerLedger
--    usp_searchDemandCustomer
--    usp_generateDemandManual
-- ---------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `usp_collectPayment`;
DELIMITER $$
CREATE PROCEDURE `usp_collectPayment`(
    IN pRenewalIds    TEXT,
    IN pCustId        INT,
    IN pReceiptDate   DATE,
    IN pModeId        TINYINT,
    IN pDiscount      DECIMAL(8,2),
    IN pNetAmt        DECIMAL(8,2),
    IN pCollectedBy   INT,
    IN pCounterId     SMALLINT,
    IN pTxnId         VARCHAR(75),
    IN pPaymentLines  TEXT
)
BEGIN
    DECLARE vDone          INT DEFAULT 0;
    DECLARE vRenewalId     INT;
    DECLARE vTotalAmt      DECIMAL(8,2);
    DECLARE vRowDisc       DECIMAL(8,2);
    DECLARE vRowReceipt    DECIMAL(8,2);
    DECLARE vGrandTotal    DECIMAL(8,2) DEFAULT 0;
    DECLARE vDiscLeft      DECIMAL(8,2);
    DECLARE vRowCount      INT DEFAULT 0;
    DECLARE vCurrentRow    INT DEFAULT 0;
    DECLARE vRemainingDue  DECIMAL(8,2);
    DECLARE vBillNo        VARCHAR(20);
    DECLARE vLastBillSeq   INT;
    DECLARE vBillYearMonth VARCHAR(6);
    DECLARE vBasicAmt      DECIMAL(8,2);
    DECLARE vCounterComm   DECIMAL(8,2);
    DECLARE vLineCount     INT DEFAULT 0;
    DECLARE vLineIdx       INT DEFAULT 0;
    DECLARE vLineMode      TINYINT;
    DECLARE vLineAmt       DECIMAL(8,2);
    DECLARE vLineTxn       VARCHAR(75);
    DECLARE vLinesSum      DECIMAL(8,2) DEFAULT 0;
    DECLARE vPrimaryMode   TINYINT;
    DECLARE vPrimaryTxn    VARCHAR(75);
    DECLARE vPayModeLabel  VARCHAR(500) DEFAULT '';
    DECLARE vTxnLabel      VARCHAR(500) DEFAULT '';

    DECLARE cur CURSOR FOR
        SELECT Renewal_Id, Total_Amount
        FROM trans_renewal
        WHERE FIND_IN_SET(Renewal_Id, pRenewalIds)
        ORDER BY Renewal_Id ASC;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET vDone = 1;

    -- Build payment lines JSON if not provided (single mode backward compatible)
    IF pPaymentLines IS NULL OR TRIM(pPaymentLines) = '' OR TRIM(pPaymentLines) = '[]' THEN
        SET pPaymentLines = JSON_ARRAY(
            JSON_OBJECT(
                'mode_id', pModeId,
                'amt', pNetAmt,
                'txn', IFNULL(pTxnId, '')
            )
        );
    END IF;

    SET vLineCount = JSON_LENGTH(pPaymentLines);
    IF vLineCount IS NULL OR vLineCount < 1 THEN
        SELECT -1 AS Error_No, 'At least one payment mode is required.' AS Message;
        -- still need empty first result set shape avoided: return error as first set
    ELSE
        SET vLineIdx = 0;
        SET vLinesSum = 0;
        WHILE vLineIdx < vLineCount DO
            SET vLineMode = CAST(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, CONCAT('$[', vLineIdx, '].mode_id'))) AS UNSIGNED);
            SET vLineAmt  = CAST(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, CONCAT('$[', vLineIdx, '].amt'))) AS DECIMAL(8,2));
            IF vLineMode IS NULL OR vLineMode = 0 OR vLineAmt IS NULL OR vLineAmt <= 0 THEN
                SELECT -1 AS Error_No, 'Invalid payment line (mode/amount).' AS Message;
                SET vLineCount = -1;
            END IF;
            SET vLinesSum = vLinesSum + IFNULL(vLineAmt, 0);
            SET vLineIdx = vLineIdx + 1;
        END WHILE;

        IF vLineCount > 0 AND ABS(vLinesSum - pNetAmt) > 0.05 THEN
            SELECT -1 AS Error_No, CONCAT('Payment lines total (', vLinesSum, ') must equal net amount (', pNetAmt, ').') AS Message;
            SET vLineCount = -1;
        END IF;
    END IF;

    IF vLineCount > 0 THEN
        SET vPrimaryMode = CAST(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, '$[0].mode_id')) AS UNSIGNED);
        SET vPrimaryTxn  = NULLIF(TRIM(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, '$[0].txn'))), '');

        SET vBillYearMonth = DATE_FORMAT(pReceiptDate, '%Y%m');

        SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(Receipt_No, '-', -1) AS UNSIGNED)), 0)
        INTO vLastBillSeq
        FROM trans_renewal
        WHERE Receipt_No LIKE CONCAT('BILL-', vBillYearMonth, '-%');

        SET vBillNo = CONCAT('BILL-', vBillYearMonth, '-', LPAD(vLastBillSeq + 1, 4, '0'));

        SELECT COALESCE(SUM(Total_Amount), 0)
        INTO vGrandTotal
        FROM trans_renewal
        WHERE FIND_IN_SET(Renewal_Id, pRenewalIds);

        SELECT COUNT(*) INTO vRowCount
        FROM trans_renewal
        WHERE FIND_IN_SET(Renewal_Id, pRenewalIds);

        SET vDiscLeft = pDiscount;
        SET vDone = 0;

        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO vRenewalId, vTotalAmt;
            IF vDone THEN LEAVE read_loop; END IF;

            SET vCurrentRow = vCurrentRow + 1;

            IF vCurrentRow = vRowCount THEN
                SET vRowDisc = vDiscLeft;
            ELSE
                SET vRowDisc  = ROUND((vTotalAmt / vGrandTotal) * pDiscount, 2);
                SET vDiscLeft = vDiscLeft - vRowDisc;
            END IF;

            SET vRowReceipt = vTotalAmt - vRowDisc;

            SELECT Renew_Amt INTO vBasicAmt FROM trans_renewal WHERE Renewal_Id = vRenewalId;
            SET vCounterComm = CASE WHEN pCounterId IS NULL THEN 0.00
                               ELSE ROUND(vBasicAmt * 0.65 * 0.05, 2)
                               END;

            UPDATE trans_renewal
            SET Pay_Status    = 2,
                Due_Amt       = 0,
                Receipt_No    = vBillNo,
                Receipt_Date  = pReceiptDate,
                Receipt_Mode  = vPrimaryMode,
                Disc_Amount   = vRowDisc,
                Receipt_Amt   = vRowReceipt,
                Counter_Id    = pCounterId,
                Counter_Comm  = vCounterComm,
                Payment_Detls = vPrimaryTxn
            WHERE Renewal_Id = vRenewalId;

        END LOOP;
        CLOSE cur;

        -- Insert payment lines once per receipt (split modes)
        SET vLineIdx = 0;
        WHILE vLineIdx < vLineCount DO
            SET vLineMode = CAST(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, CONCAT('$[', vLineIdx, '].mode_id'))) AS UNSIGNED);
            SET vLineAmt  = CAST(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, CONCAT('$[', vLineIdx, '].amt'))) AS DECIMAL(8,2));
            SET vLineTxn  = NULLIF(TRIM(JSON_UNQUOTE(JSON_EXTRACT(pPaymentLines, CONCAT('$[', vLineIdx, '].txn')))), '');
            IF vLineTxn = 'null' THEN SET vLineTxn = NULL; END IF;

            INSERT INTO trans_renewal_payment
                (Receipt_No, Renewal_Id, Cust_Id, Receipt_Date, Mode_Id, Paid_Amt, Txn_Id, Counter_Id, Created_By, Created_On)
            VALUES
                (vBillNo, NULL, pCustId, pReceiptDate, vLineMode, vLineAmt, vLineTxn, pCounterId, pCollectedBy, NOW());

            SET vLineIdx = vLineIdx + 1;
        END WHILE;

        SELECT COALESCE(SUM(Due_Amt), 0)
        INTO vRemainingDue
        FROM trans_renewal
        WHERE Cust_Id = pCustId AND Pay_Status != 2;

        UPDATE mst_customer
        SET Due_Amount = vRemainingDue,
            Status     = 1,
            Last_PayDt = pReceiptDate
        WHERE Cust_Id = pCustId;

        SELECT
            GROUP_CONCAT(DISTINCT m.Mode ORDER BY m.Mode SEPARATOR ', ')
        INTO vPayModeLabel
        FROM trans_renewal_payment p
        JOIN mst_mode m ON m.Mode_Id = p.Mode_Id
        WHERE p.Receipt_No COLLATE utf8mb4_general_ci = CONVERT(vBillNo USING utf8mb4) COLLATE utf8mb4_general_ci;

        SELECT
            GROUP_CONCAT(NULLIF(TRIM(p.Txn_Id), '') ORDER BY p.Payment_Id SEPARATOR ', ')
        INTO vTxnLabel
        FROM trans_renewal_payment p
        WHERE p.Receipt_No COLLATE utf8mb4_general_ci = CONVERT(vBillNo USING utf8mb4) COLLATE utf8mb4_general_ci;

        SELECT
            r.Receipt_No, r.Receipt_Date, r.Receipt_Amt,
            r.Renew_From, r.Renew_Upto, r.Disc_Amount,
            COALESCE(CONVERT(vTxnLabel USING utf8mb4) COLLATE utf8mb4_general_ci, CONVERT(r.Payment_Detls USING utf8mb4) COLLATE utf8mb4_general_ci) AS Txn_Id,
            c.Cust_Name, c.Account_No, c.User_Id,
            c.Cust_Code,
            c.Billing_Address,
            p.Package_Name,
            COALESCE(CONVERT(vPayModeLabel USING utf8mb4) COLLATE utf8mb4_general_ci, CONVERT(m.Mode USING utf8mb4) COLLATE utf8mb4_general_ci) AS Pay_Mode
        FROM trans_renewal r
        INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
        INNER JOIN mst_package  p ON p.Package_Id = r.Plan_Id
        LEFT  JOIN mst_mode     m ON m.Mode_Id = r.Receipt_Mode
        WHERE FIND_IN_SET(r.Renewal_Id, pRenewalIds)
        ORDER BY r.Renewal_Id ASC;

        SELECT 0 AS Error_No, 'Payment collected successfully.' AS Message;
    END IF;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `usp_getLastBill`;
DELIMITER $$
CREATE PROCEDURE `usp_getLastBill`(
    IN pAccount   VARCHAR(50),
    IN pUserId    VARCHAR(50),
    IN pCode      VARCHAR(50),
    IN pCounterId SMALLINT
)
BEGIN
    SELECT
        r.Receipt_No, r.Receipt_Date, r.Receipt_Amt, r.Disc_Amount,
        COALESCE(r.Extra_Amt, 0) AS Extra_Amt,
        r.Renew_From, r.Renew_Upto,
        COALESCE(
            (SELECT GROUP_CONCAT(NULLIF(TRIM(p.Txn_Id), '') ORDER BY p.Payment_Id SEPARATOR ', ')
             FROM trans_renewal_payment p WHERE CONVERT(p.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci),
            r.Payment_Detls
        ) AS Txn_Id,
        c.Cust_Name, c.Account_No, c.User_Id, c.Cust_Code,
        c.Billing_Address,
        pkg.Package_Name,
        COALESCE(
            (SELECT GROUP_CONCAT(DISTINCT m2.Mode ORDER BY m2.Mode SEPARATOR ', ')
             FROM trans_renewal_payment p2
             JOIN mst_mode m2 ON m2.Mode_Id = p2.Mode_Id
             WHERE CONVERT(p2.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci),
            m.Mode
        ) AS Pay_Mode
    FROM trans_renewal r
    INNER JOIN mst_customer c ON c.Cust_Id    = r.Cust_Id
    INNER JOIN mst_package  pkg ON pkg.Package_Id = r.Plan_Id
    LEFT JOIN  mst_mode     m ON m.Mode_Id    = r.Receipt_Mode
    WHERE r.Pay_Status  = 2
      AND r.Receipt_No IS NOT NULL
      AND (pAccount IS NULL OR c.Account_No = pAccount)
      AND (pUserId  IS NULL OR c.User_Id    = pUserId)
      AND (pCode    IS NULL OR c.Cust_Code  = pCode)
    ORDER BY r.Renewal_Id DESC
    LIMIT 1;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `usp_getRenewalRegister`;
DELIMITER $$
CREATE PROCEDURE `usp_getRenewalRegister`(
    IN pFromDate  DATE,
    IN pToDate    DATE,
    IN pCounterId SMALLINT,
    IN pType      TINYINT
)
BEGIN
    SELECT
        ROW_NUMBER() OVER (ORDER BY SortDate ASC, SortId ASC) AS Sl_No,
        Cust_Name, User_Id, Inv_No, Renewal_Details, Pay_Date,
        Plan_Amount, Extra_Amt, Advance_Adj, GST_Amt, Disc_Amount,
        Paid_Amount, Due_Amt, Demand_Date, Pay_Mode, Txn_Id, Pay_Status
    FROM (
        SELECT
            c.Cust_Name,
            c.User_Id,
            r.Inv_No,
            CONCAT(
                IFNULL(pkg.Package_Name, ''),
                ' ',
                DATE_FORMAT(r.Renew_From, '%d-%b-%Y'),
                ' to ',
                DATE_FORMAT(r.Renew_Upto, '%d-%b-%Y')
            ) AS Renewal_Details,
            r.Receipt_Date AS Pay_Date,
            (r.Total_Amount - COALESCE(r.Extra_Amt, 0)) AS Plan_Amount,
            COALESCE(r.Extra_Amt, 0) AS Extra_Amt,
            COALESCE(r.Advance_Adj, 0) AS Advance_Adj,
            r.GST_Amt,
            r.Disc_Amount,
            r.Receipt_Amt AS Paid_Amount,
            r.Due_Amt,
            r.Demand_Date,
            COALESCE(
                (SELECT GROUP_CONCAT(DISTINCT m2.Mode ORDER BY m2.Mode SEPARATOR ', ')
                 FROM trans_renewal_payment p2
                 JOIN mst_mode m2 ON m2.Mode_Id = p2.Mode_Id
                 WHERE CONVERT(p2.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci),
                m.Mode
            ) AS Pay_Mode,
            COALESCE(
                (SELECT GROUP_CONCAT(NULLIF(TRIM(p3.Txn_Id), '') ORDER BY p3.Payment_Id SEPARATOR ', ')
                 FROM trans_renewal_payment p3 WHERE CONVERT(p3.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci),
                r.Payment_Detls
            ) AS Txn_Id,
            CASE r.Pay_Status
                WHEN 1 THEN 'Unpaid'
                WHEN 2 THEN 'Paid'
                ELSE 'Unknown'
            END AS Pay_Status,
            CASE WHEN pType = 2 THEN r.Receipt_Date ELSE r.Demand_Date END AS SortDate,
            r.Renewal_Id AS SortId
        FROM trans_renewal r
        JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
        LEFT JOIN mst_package pkg ON pkg.Package_Id = r.Plan_Id
        LEFT JOIN mst_mode m ON m.Mode_Id = r.Receipt_Mode
        WHERE (pCounterId IS NULL OR r.Counter_Id = pCounterId)
          AND (
                (pType = 2 AND DATE(r.Receipt_Date) BETWEEN pFromDate AND pToDate)
                OR
                (IFNULL(pType, 0) <> 2 AND DATE(r.Demand_Date) BETWEEN pFromDate AND pToDate)
          )
          AND (
                pType = 1
             OR (pType = 2 AND r.Pay_Status = 2)
             OR (pType = 3 AND r.Pay_Status = 1)
          )

        UNION ALL

        SELECT
            c.Cust_Name,
            c.User_Id,
            a.Receipt_No,
            CONCAT(
                IFNULL(pkg.Package_Name, 'Advance'),
                ' ',
                IF(a.Renew_From IS NULL, 'advance',
                   CONCAT(DATE_FORMAT(a.Renew_From, '%d-%b-%Y'), ' to ', DATE_FORMAT(a.Renew_Upto, '%d-%b-%Y')))
            ),
            a.Receipt_Date,
            0,
            0,
            a.Amount,
            0,
            0,
            a.Amount,
            0,
            a.Receipt_Date,
            m.Mode,
            a.Txn_Id,
            'Advance',
            a.Receipt_Date,
            a.Advance_Id
        FROM trans_advance a
        JOIN mst_customer c ON c.Cust_Id = a.Cust_Id
        LEFT JOIN mst_package pkg ON pkg.Package_Id = a.Plan_Id
        LEFT JOIN mst_mode m ON m.Mode_Id = a.Mode_Id
        WHERE pType = 2
          AND DATE(a.Receipt_Date) BETWEEN pFromDate AND pToDate
          AND (pCounterId IS NULL OR a.Counter_Id = pCounterId)
    ) report_rows;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `usp_getCounterWiseCollection`;
DELIMITER $$
CREATE PROCEDURE `usp_getCounterWiseCollection`(
    IN pFromDate   DATE,
    IN pToDate     DATE,
    IN pCounterId  SMALLINT
)
BEGIN
    SELECT
        ROW_NUMBER() OVER (ORDER BY m.Mode_Id) AS Sl_No,
        m.Mode AS Payment_Mode,
        COALESCE(SUM(p.Paid_Amt), 0) + COALESCE(MAX(adv.Adv_Amt), 0) AS Total_Amount
    FROM mst_mode m
    LEFT JOIN trans_renewal_payment p
        ON p.Mode_Id = m.Mode_Id
        AND DATE(p.Receipt_Date) BETWEEN pFromDate AND pToDate
        AND (pCounterId IS NULL OR p.Counter_Id = pCounterId)
    LEFT JOIN (
        SELECT Mode_Id, SUM(Amount) AS Adv_Amt
        FROM trans_advance
        WHERE DATE(Receipt_Date) BETWEEN pFromDate AND pToDate
          AND (pCounterId IS NULL OR Counter_Id = pCounterId)
        GROUP BY Mode_Id
    ) adv ON adv.Mode_Id = m.Mode_Id
    WHERE m.Is_Active = 1
    GROUP BY m.Mode_Id, m.Mode
    ORDER BY m.Mode_Id;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `usp_getCustomerLedger`;
DELIMITER $$
CREATE PROCEDURE `usp_getCustomerLedger`(
    IN pAccount   VARCHAR(75),
    IN pUserId    VARCHAR(75),
    IN pCode      VARCHAR(50),
    IN pName      VARCHAR(250),
    IN pPhone     VARCHAR(20),
    IN pCounterId SMALLINT
)
BEGIN
    SELECT
        c.Cust_Id,
        c.Cust_Name,
        c.User_Id,
        c.Contact_No,
        c.Billing_Address,
        COALESCE(c.Advance_Amt, 0) AS Advance_Amt,
        c.Renew_From,
        c.Renew_Upto,
        p.Package_Name AS Plan_Name,
        z.Zone_Cd AS Zone_Cd
    FROM mst_customer c
    JOIN mst_package p ON p.Package_Id = c.Package_Id
    LEFT JOIN mst_zone z ON z.Zone_Id = c.Zone_Id
    WHERE
      (pAccount IS NULL OR c.Account_No = pAccount)
      AND (pUserId  IS NULL OR c.User_Id    = pUserId)
      AND (pCode    IS NULL OR c.Cust_Code  = pCode)
      AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName, '%'))
      AND (pPhone   IS NULL OR c.Contact_No LIKE CONCAT('%', pPhone, '%'));

    SELECT Renewal_Id, Inv_No, Bill_No, Demand_Date, Plan_Name, Renew_From, Renew_Upto,
           Total_Amount, Extra_Amt, Disc_Amount, Pay_Amount, Due_Amt, Pay_Date,
           Receipt_Mode, Pay_Status
    FROM (
        SELECT
            r.Renewal_Id,
            r.Inv_No,
            r.Receipt_No AS Bill_No,
            r.Demand_Date,
            pkg.Package_Name AS Plan_Name,
            r.Renew_From,
            r.Renew_Upto,
            (r.Total_Amount - COALESCE(r.Extra_Amt, 0)) AS Total_Amount,
            COALESCE(r.Extra_Amt, 0) AS Extra_Amt,
            r.Disc_Amount,
            r.Receipt_Amt AS Pay_Amount,
            r.Due_Amt,
            r.Receipt_Date AS Pay_Date,
            COALESCE(
                (SELECT GROUP_CONCAT(DISTINCT m2.Mode ORDER BY m2.Mode SEPARATOR ', ')
                 FROM trans_renewal_payment p2
                 JOIN mst_mode m2 ON m2.Mode_Id = p2.Mode_Id
                 WHERE CONVERT(p2.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci = CONVERT(r.Receipt_No USING utf8mb4) COLLATE utf8mb4_general_ci),
                m.Mode
            ) AS Receipt_Mode,
            CASE r.Pay_Status
                WHEN 1 THEN 'Unpaid'
                WHEN 2 THEN 'Paid'
                ELSE 'Unknown'
            END AS Pay_Status
        FROM trans_renewal r
        INNER JOIN mst_customer c ON c.Cust_Id = r.Cust_Id
        LEFT JOIN mst_package pkg ON pkg.Package_Id = r.Plan_Id
        LEFT JOIN mst_mode m ON m.Mode_Id = r.Receipt_Mode
        WHERE
           (pAccount IS NULL OR c.Account_No = pAccount)
          AND (pUserId  IS NULL OR c.User_Id    = pUserId)
          AND (pCode    IS NULL OR c.Cust_Code  = pCode)
          AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName, '%'))
          AND (pPhone   IS NULL OR c.Contact_No LIKE CONCAT('%', pPhone, '%'))

        UNION ALL

        SELECT
            a.Advance_Id,
            a.Receipt_No,
            a.Receipt_No,
            a.Receipt_Date,
            pkg.Package_Name,
            a.Renew_From,
            a.Renew_Upto,
            0,
            0,
            0,
            a.Amount,
            0,
            a.Receipt_Date,
            m.Mode,
            'Advance'
        FROM trans_advance a
        INNER JOIN mst_customer c ON c.Cust_Id = a.Cust_Id
        LEFT JOIN mst_package pkg ON pkg.Package_Id = a.Plan_Id
        LEFT JOIN mst_mode m ON m.Mode_Id = a.Mode_Id
        WHERE
           (pAccount IS NULL OR c.Account_No = pAccount)
          AND (pUserId  IS NULL OR c.User_Id    = pUserId)
          AND (pCode    IS NULL OR c.Cust_Code  = pCode)
          AND (pName    IS NULL OR c.Cust_Name  LIKE CONCAT('%', pName, '%'))
          AND (pPhone   IS NULL OR c.Contact_No LIKE CONCAT('%', pPhone, '%'))
    ) ledger_rows
    ORDER BY Demand_Date ASC, Renewal_Id ASC;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `usp_searchDemandCustomer`;
DELIMITER $$
CREATE PROCEDURE `usp_searchDemandCustomer`(
    IN pAcctNo    VARCHAR(75),
    IN pUserId    VARCHAR(75),
    IN pCustCode  VARCHAR(50),
    IN pCustName  VARCHAR(250)
)
BEGIN
    DECLARE vCustId  INT DEFAULT NULL;
    DECLARE vCount   INT DEFAULT 0;

    SELECT COUNT(*) INTO vCount
    FROM mst_customer
    WHERE (pAcctNo   IS NULL OR Account_No = pAcctNo)
    AND  (pUserId   IS NULL OR User_Id    = pUserId)
    AND  (pCustCode IS NULL OR Cust_Code  = pCustCode)
    AND  (pCustName IS NULL OR Cust_Name  LIKE CONCAT('%', pCustName, '%'));

    IF vCount = 0 THEN
        SELECT -1 AS Error_No, 'Customer not found.' AS Message;

    ELSEIF vCount > 1 THEN
        SELECT 1 AS Error_No, 'Multiple customers found. Please refine your search.' AS Message;

    ELSE
        SELECT Cust_Id INTO vCustId
        FROM mst_customer
        WHERE (pAcctNo   IS NULL OR Account_No = pAcctNo)
        AND  (pUserId   IS NULL OR User_Id    = pUserId)
        AND  (pCustCode IS NULL OR Cust_Code  = pCustCode)
        AND  (pCustName IS NULL OR Cust_Name  LIKE CONCAT('%', pCustName, '%'));

        IF NOT EXISTS (SELECT 1 FROM trans_renewal WHERE Cust_Id = vCustId AND Pay_Status != 2) THEN
            SELECT 0 AS Error_No, 'No pending demands. All bills are paid.' AS Message;
        ELSE
            SELECT
                c.Cust_Id, c.Cust_Code, c.Cust_Name,
                c.Account_No, c.User_Id, c.Contact_No,
                r.Renewal_Id, r.Inv_No,
                CONCAT(DATE_FORMAT(r.Renew_From, '%d/%m/%y'), ' - ', DATE_FORMAT(r.Renew_Upto, '%d/%m/%y')) AS Inv_Period,
                r.Due_Amt, r.Pay_Status, r.Total_Amount, COALESCE(r.Advance_Adj, 0) AS Advance_Adj
            FROM mst_customer c
            INNER JOIN trans_renewal r ON r.Cust_Id = c.Cust_Id
            WHERE c.Cust_Id = vCustId
            AND   r.Pay_Status != 2
            ORDER BY r.Demand_Date ASC;
        END IF;
    END IF;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `usp_generateDemandManual`;
DELIMITER $$
CREATE PROCEDURE `usp_generateDemandManual`(
    IN pCustId      INT,
    IN pRenewFrom   DATE,
    IN pRenewUpto   DATE,
    IN pCreatedBy   INT,
    IN pHomeCounter SMALLINT,
    IN pPackageId   SMALLINT,
    IN pDemandDate  DATE
)
BEGIN
    DECLARE vPlanId    SMALLINT;
    DECLARE vBasicAmt  DECIMAL(8,2);
    DECLARE vGstAmt    DECIMAL(8,2);
    DECLARE vTotalAmt  DECIMAL(8,2);
    DECLARE vPlanDays  INT;
    DECLARE vInvNo     VARCHAR(20);
    DECLARE vLastSeq   INT;
    DECLARE vYearMonth VARCHAR(6);
    DECLARE vZoneComm  DECIMAL(8,2) DEFAULT 0.00;
    DECLARE vCommPct   DECIMAL(5,2) DEFAULT 0.00;
    DECLARE vDemandDt  DATE;
    DECLARE vAdvance   DECIMAL(8,2) DEFAULT 0.00;
    DECLARE vAdj       DECIMAL(8,2) DEFAULT 0.00;
    DECLARE vDue       DECIMAL(8,2) DEFAULT 0.00;
    DECLARE vPayStatus TINYINT DEFAULT 1;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT -1 AS Error_No, 'Database error occurred.' AS Message;
    END;

    SET vDemandDt = COALESCE(pDemandDate, CURRENT_DATE());

    START TRANSACTION;

    IF COALESCE(pPackageId, 0) = 0 THEN
        SELECT Package_Id INTO vPlanId FROM mst_customer WHERE Cust_Id = pCustId;
    ELSE
        SET vPlanId = pPackageId;
    END IF;

    SELECT Basic_Amt, GST_Amt, Total_Amt, Plan_Days
    INTO vBasicAmt, vGstAmt, vTotalAmt, vPlanDays
    FROM mst_package WHERE Package_Id = vPlanId;

    IF (SELECT COALESCE(Comm_Amt, 1) FROM mst_package WHERE Package_Id = vPlanId) = 0 THEN
        SET vZoneComm = 0.00;
    ELSE
        SELECT COALESCE(z.Comm_Pct, 0)
        INTO vCommPct
        FROM mst_customer c
        LEFT JOIN mst_zone z ON z.Zone_Id = c.Zone_Id
        WHERE c.Cust_Id = pCustId;
        SET vZoneComm = ROUND(vBasicAmt * vCommPct / 100, 0);
    END IF;

    SET vYearMonth = DATE_FORMAT(vDemandDt, '%Y%m');

    SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(Inv_No, '-', -1) AS UNSIGNED)), 0)
    INTO vLastSeq
    FROM trans_renewal
    WHERE Inv_No LIKE CONCAT('INV-', vYearMonth, '-%');

    SET vInvNo = CONCAT('INV-', vYearMonth, '-', LPAD(vLastSeq + 1, 4, '0'));

    SELECT COALESCE(Advance_Amt, 0) INTO vAdvance FROM mst_customer WHERE Cust_Id = pCustId;
    IF vAdvance < 0 THEN SET vAdvance = 0; END IF;
    SET vAdj = IF(vAdvance > vTotalAmt, vTotalAmt, vAdvance);
    SET vDue = vTotalAmt - vAdj;
    IF vDue <= 0.009 THEN
        SET vPayStatus = 2;
        SET vDue = 0;
    END IF;

    INSERT INTO trans_renewal (
        Cust_Id, Demand_Date, Plan_Id, Renew_Mnth,
        Renew_From, Renew_Upto, Renew_Amt, OTT_Amt,
        GST_Amt, Total_Amount, Pay_Status, Due_Amt, Inv_No, Counter_Id,
        Zone_Comm, Advance_Adj, Receipt_Date, Receipt_Amt, Payment_Detls,
        Created_By, Created_On
    ) VALUES (
        pCustId, vDemandDt, vPlanId, vPlanDays,
        pRenewFrom, pRenewUpto, vBasicAmt, 0,
        vGstAmt, vTotalAmt, vPayStatus, vDue, vInvNo, pHomeCounter,
        vZoneComm, vAdj,
        IF(vPayStatus = 2, vDemandDt, NULL),
        IF(vPayStatus = 2, 0, NULL),
        IF(vAdj > 0, 'Adjusted from advance', NULL),
        pCreatedBy, NOW()
    );

    UPDATE mst_customer
    SET Renew_From   = pRenewFrom,
        Renew_Upto   = pRenewUpto,
        Due_Amount   = COALESCE(Due_Amount, 0) + vDue,
        Advance_Amt  = COALESCE(Advance_Amt, 0) - vAdj,
        Package_Id   = vPlanId,
        Plan_Amount  = vBasicAmt,
        GST          = vGstAmt,
        Total_Amount = vTotalAmt
    WHERE Cust_Id = pCustId;

    COMMIT;

    SELECT 0 AS Error_No, CONCAT('Renewal generated: ', vInvNo) AS Message;
END$$
DELIMITER ;

